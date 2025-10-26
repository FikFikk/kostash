<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportResponse;
use App\Models\ReportStatusHistory;
use App\Models\Room;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\StoreReportResponseRequest;
use App\Http\Requests\UpdateReportStatusRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of reports
     */
    public function index(Request $request)
    {
        $query = Report::with(['user', 'room'])->latest('reported_at');
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin filtering logic
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }
            if ($request->filled('priority')) {
                $query->where('priority', $request->priority);
            }

            $reports = $query->paginate(10);

            $categories = $this->getCategoryOptions();
            $priorities = $this->getPriorityOptions();

            return view('dashboard.admin.report.index', compact('reports', 'categories', 'priorities'));
        }

        $query->where('user_id', $user->id);

        $tenantReportsQuery = Report::where('user_id', $user->id);
        $totalReports = (clone $tenantReportsQuery)->count();
        $pendingReports = (clone $tenantReportsQuery)->whereIn('status', ['pending', 'in_progress'])->count();
        $completedReports = (clone $tenantReportsQuery)->where('status', 'completed')->count();

        $reports = $query->paginate(10);

        return view('dashboard.tenants.report.index', compact(
            'reports',
            'totalReports',
            'pendingReports',
            'completedReports'
        ));
    }

    /**
     * Menampilkan form pembuatan laporan (Hanya untuk Tenant).
     */
    public function create()
    {
        if (Auth::user()->role !== 'tenants') {
            abort(403, 'Akses ditolak.');
        }

        $user = Auth::user();
        if (is_null($user->room_id)) {
            return redirect()->back()->with('error', 'Anda harus terdaftar di sebuah kamar untuk dapat membuat laporan.');
        }

        $room = Room::findOrFail($user->room_id);

        $categories = $this->getCategoryOptions();
        $priorities = $this->getPriorityOptions();

        return view('dashboard.tenants.report.create', compact('room', 'categories', 'priorities'));
    }

    /**
     * Menyimpan laporan baru menggunakan Form Request.
     */
    public function store(StoreReportRequest $request)
    {
        // Otorisasi & Validasi kini ditangani oleh StoreReportRequest.

        DB::transaction(function () use ($request) {
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('uploads/reports', 'public');
                    $imagePaths[] = $path;
                }
            }

            // Observer 'created' akan berjalan setelah ini untuk mencatat histori.
            $report = Report::create(array_merge($request->validated(), [
                'user_id' => Auth::id(),
                'status' => 'pending',
                'images' => $imagePaths,
                'reported_at' => now()
            ]));

            // Send notification to user (tenant)
            $user = Auth::user();
            if ($user) {
                NotificationService::report($user, 'created', $report);
            }

            // Send notification to all admin
            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                NotificationService::report($admin, 'created', $report, [
                    'message' => "Laporan baru dari tenant: {$user->name} ({$user->email})"
                ]);
            }
        });

        return redirect()->route('tenant.report.index')->with('success', 'Laporan berhasil dibuat');
    }

    /**
     * Menampilkan detail laporan dengan view yang sesuai untuk Admin atau Tenant.
     */
    public function show(Report $report)
    {
        $user = Auth::user();
        $report->load(['user', 'room', 'responses.admin', 'statusHistory.changedBy']);

        if ($user->role === 'admin') {
            // Mengarahkan ke view admin
            return view('dashboard.admin.report.show', compact('report'));
        }

        // Logika untuk tenant
        if ($user->role === 'tenants') {
            if ($report->user_id !== $user->id) {
                abort(403, 'Unauthorized.');
            }
            // Mengarahkan ke view tenant
            return view('dashboard.tenants.report.show', compact('report'));
        }

        return abort(403);
    }

    /**
     * Update status laporan (Hanya Admin) menggunakan Form Request.
     */
    public function updateStatus(UpdateReportStatusRequest $request, Report $report)
    {
        // Otorisasi & Validasi ditangani oleh UpdateReportStatusRequest.
        $oldStatus = $report->status;

        // Observer 'updating' akan berjalan setelah ini untuk mencatat histori.
        $report->update($request->validated());

        // Send notification to the report owner when status changes
        $newStatus = $report->status;
        if ($oldStatus !== $newStatus && $report->user) {
            NotificationService::report($report->user, 'status_updated', $report, [
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ]);
        }

        return back()->with('success', 'Status laporan berhasil diperbarui');
    }

    /**
     * Menghapus laporan (Admin & Tenant).
     */
    public function destroy(Report $report)
    {
        $user = Auth::user();

        // Aturan: Hanya bisa hapus jika status 'pending'
        if ($report->status !== 'pending') {
            return back()->withErrors(['error' => 'Laporan yang sudah diproses tidak dapat dihapus.']);
        }

        // Aturan: Tenant hanya bisa hapus miliknya sendiri
        if ($user->role === 'tenants' && $report->user_id !== $user->id) {
            return back()->withErrors(['error' => 'Anda tidak memiliki izin untuk menghapus laporan ini.']);
        }

        DB::transaction(function () use ($report, $user) {
            // Store report info before deletion for notification
            $reportOwner = $report->user;
            $reportTitle = $report->title;
            $reportId = $report->id;

            if (!empty($report->images)) {
                Storage::disk('public')->delete($report->images);
            }
            $report->delete();

            // Send notification to report owner if deleted by admin
            if ($user->role === 'admin' && $reportOwner && $reportOwner->id !== $user->id) {
                NotificationService::report($reportOwner, 'deleted', null, [
                    'report_title' => $reportTitle,
                    'report_id' => $reportId,
                    'deleted_by' => 'admin'
                ]);
            }
        });

        // Arahkan kembali sesuai role
        $routeName = $user->role === 'admin' ? 'dashboard.report.index' : 'tenant.report.index';
        return redirect()->route($routeName)->with('success', 'Laporan berhasil dihapus');
    }

    /**
     * Menampilkan halaman statistik (Hanya Admin).
     */
    public function statistics()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $stats = [
            'total_reports' => Report::count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
            'in_progress_reports' => Report::where('status', 'in_progress')->count(),
            'completed_reports' => Report::where('status', 'completed')->count(),
            'rejected_reports' => Report::where('status', 'rejected')->count(),
            'reports_by_category' => Report::selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->pluck('count', 'category'),
            'recent_reports' => Report::with(['user', 'room'])
                ->latest('reported_at')
                ->limit(5)
                ->get()
        ];

        $categories = $this->getCategoryOptions();

        // Mengarahkan ke view statistik admin yang benar
        return view('dashboard.admin.report.statistics', compact('stats', 'categories'));
    }

    // Helper functions untuk menghindari duplikasi kode
    private function getCategoryOptions(): array
    {
        return [
            'electrical' => 'Listrik',
            'water'      => 'Air',
            'facility'   => 'Fasilitas',
            'cleaning'   => 'Kebersihan',
            'security'   => 'Keamanan',
            'other'      => 'Lainnya'
        ];
    }

    private function getPriorityOptions(): array
    {
        return [
            'low'    => 'Rendah',
            'medium' => 'Sedang',
            'high'   => 'Tinggi',
            'urgent' => 'Mendesak'
        ];
    }
}
