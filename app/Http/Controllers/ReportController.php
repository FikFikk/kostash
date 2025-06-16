<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportResponse;
use App\Models\ReportStatusHistory;
use App\Models\Room;
use Illuminate\Http\Request;
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
        $query = Report::with(['user', 'room', 'responses'])
            ->orderBy('reported_at', 'desc');

        // Filter untuk admin
        if (Auth::user()->role === 'admin') {
            // Admin bisa lihat semua laporan
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }
            if ($request->filled('priority')) {
                $query->where('priority', $request->priority);
            }
        } else {
            // Tenant hanya bisa lihat laporan sendiri
            $query->where('user_id', Auth::id());
        }

        $reports = $query->paginate(10);
        
        return view('dashboard.tenants.report.index', compact('reports'));
    }

    /**
     * Show the form for creating a new report
     */
    public function create()
    {
        if (auth()->user()->role !== 'tenants') {
            abort(403, 'Akses ditolak. Hanya penyewa yang dapat membuat laporan.');
        }

        $user = auth()->user();

        if (is_null($user->room_id)) {
            return redirect()->back()
                ->with('error', 'Anda harus terdaftar di sebuah kamar untuk dapat membuat laporan.');
        }

        $room = Room::findOrFail($user->room_id);

        $categories = [
            'electrical' => 'Listrik',
            'water'      => 'Air',
            'facility'   => 'Fasilitas',
            'cleaning'   => 'Kebersihan',
            'security'   => 'Keamanan',
            'other'      => 'Lainnya'
        ];
        $priorities = [
            'low'    => 'Rendah',
            'medium' => 'Sedang',
            'high'   => 'Tinggi',
            'urgent' => 'Mendesak'
        ];
        return view('dashboard.tenants.report.create', compact('room', 'categories', 'priorities'));
    }

    /**
     * Store a newly created report
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:electrical,water,facility,cleaning,security,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $imagePaths = [];
            
            // Handle file uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('uploads/reports', 'public');
                    $imagePaths[] = $path;
                }
            }

            // Create report
            $report = Report::create([
                'user_id' => Auth::id(),
                'room_id' => $request->room_id,
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'priority' => $request->priority,
                'status' => 'pending',
                'images' => $imagePaths,
                'reported_at' => now()
            ]);

            DB::commit();
            
            return redirect()->route('tenant.report.index')
                ->with('success', 'Laporan berhasil dibuat');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal membuat laporan: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified report
     */
    public function show(Report $report)
    {

        $user = Auth::user();

        if ($user->role === 'tenants') {
            if ($report->user_id !== $user->id) {
                abort(403, 'Unauthorized.');
            }
        }

        $report->load(['user', 'room', 'responses.admin', 'statusHistory.changedBy']);
        return view('dashboard.tenants.report.show', compact('report'));
    }

    /**
     * Update report status (Admin only)
     */
    public function updateStatus(Request $request, Report $report)
    {
        // Hanya admin yang bisa update status
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,rejected',
            'reason' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $report->status;
            
            // Update status
            $report->update([
                'status' => $request->status
            ]);

            // Create status history
            ReportStatusHistory::create([
                'report_id' => $report->id,
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'changed_by' => Auth::id(),
                'reason' => $request->reason
            ]);

            DB::commit();
            
            return back()->with('success', 'Status laporan berhasil diperbarui');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal memperbarui status: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete report
     */
    public function destroy(Report $report)
    {
        // Authorization check
        if (Auth::user()->role === 'tenants' && $report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hanya bisa hapus jika status masih pending
        if ($report->status !== 'pending') {
            return back()->withErrors(['error' => 'Laporan yang sudah diproses tidak dapat dihapus']);
        }

        DB::beginTransaction();
        try {
            // Delete images
            if (!empty($report->images)) {
                foreach ($report->images as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            $report->delete();
            
            DB::commit();
            
            return redirect()->route('tenant.report.index')
                ->with('success', 'Laporan berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menghapus laporan: ' . $e->getMessage()]);
        }
    }

    /**
     * Get reports statistics (Admin only)
     */
    public function statistics()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
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
                ->orderBy('reported_at', 'desc')
                ->limit(5)
                ->get()
        ];

        return view('dashboard.tenants.report.statistics', compact('stats'));
    }
}
