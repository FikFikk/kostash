<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportResponse;
use App\Models\ReportStatusHistory;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReportResponseRequest;
use App\Http\Requests\UpdateReportResponseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ReportResponseController extends Controller
{
    // Cache constants
    private const CACHE_TTL = 3600; // 1 hour
    private const CACHE_PREFIX = 'report_response_';

    // Status constants
    private const STATUS_PENDING = 'pending';
    private const STATUS_IN_PROGRESS = 'in_progress';
    private const STATUS_COMPLETED = 'completed';

    public function __construct()
    {
        // Apply middleware di constructor untuk efisiensi
        // $this->middleware('auth');
    }

    /**
     * Store a new report response with optimized database operations
     */
    public function store(StoreReportResponseRequest $request, Report $report): RedirectResponse
    {
        $response = DB::transaction(function () use ($request, $report) {
            $responseData = array_merge($request->validated(), [
                'report_id' => $report->id,
                'admin_id' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $response = ReportResponse::create($responseData);
            $this->handleCompletionTimestamp($response);
            if ($response->report && $response->report->user) {
                NotificationService::report($response->report->user, 'response_added', $response->report, [
                    'response_message' => $response->response_text,
                    'admin_name' => Auth::user()->name
                ]);
            }
            $this->clearReportCaches($response->report);
            return $response;
        });
        return $this->successResponse('Respons berhasil dikirim', $response);
    }

    /**
     * Update a report response (admin or tenant)
     */
    public function update(Request $request, Report $report, ReportResponse $response)
    {
        $user = Auth::user();
        // Only admin who owns response or tenant who owns response can edit
        $isAdmin = $user->role === 'admin' && $response->admin_id === $user->id;
        $isTenant = $user->role === 'tenants' && $response->admin_id === $user->id;
        if (!$isAdmin && !$isTenant) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'response_text' => 'required|string|min:3|max:1000',
            'action_taken' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        $response->update(array_merge($validated, [
            'updated_at' => now(),
        ]));

        // Notifikasi ke lawan peran
        // if ($isAdmin && $report->user) {
        //     NotificationService::report($report->user, 'response_updated', $report, [
        //         'response_message' => $response->response_text,
        //         'admin_name' => $user->name
        //     ]);
        // } elseif ($isTenant) {
        //     $admins = \App\Models\User::where('role', 'admin')->get();
        //     foreach ($admins as $admin) {
        //         NotificationService::report($admin, 'response_updated', $report, [
        //             'message' => "Tenant mengedit balasan laporan: {$user->name} ({$user->email})",
        //             'response_text' => $response->response_text
        //         ]);
        //     }
        // }

        $this->clearReportCaches($report);

        return back()->with('success', 'Response berhasil diedit.');
    }

    /**
     * Delete report response with authorization check
     */
    public function destroy(ReportResponse $response): RedirectResponse
    {
        // Optimized authorization check
        if (!$this->canDeleteResponse($response)) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus respons ini');
        }

        DB::transaction(function () use ($response) {
            $report = $response->report;

            // Soft delete untuk audit trail
            $response->delete();

            // Update report status jika diperlukan
            $this->updateReportStatusAfterDeletion($report);

            // Clear caches
            $this->clearReportCaches($report);
        });

        return $this->successResponse('Respons berhasil dihapus');
    }

    /**
     * Helper methods untuk optimasi dan clean code
     */

    /**
     * Update report status dengan kondisi yang optimal
     */
    private function updateReportStatus(Report $report, string $currentStatus, string $newStatus): void
    {
        if ($report->status === $currentStatus) {
            // You can add your logic here if needed
        }
    }

    /**
     * Tenant store response to their own report
     */
    public function tenantStore(Request $request, Report $report)
    {
        $user = Auth::user();
        // Only allow if report belongs to tenant
        if ($user->role !== 'tenants' || $report->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'response_text' => 'required|string|min:3|max:1000',
        ]);

        DB::transaction(function () use ($report, $user, $validated) {
            $response = new \App\Models\ReportResponse();
            $response->report_id = $report->id;
            $response->admin_id = $user->id; // set ke id user tenant
            $response->response_text = $validated['response_text'];
            $response->created_at = now();
            $response->updated_at = now();
            $response->save();

            // Kirim notifikasi ke semua admin
            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                \App\Services\NotificationService::report($admin, 'response_added', $report, [
                    'message' => "Tenant membalas laporan: {$user->name} ({$user->email})",
                    'response_text' => $response->response_text
                ]);
            }
        });

        return redirect()->route('tenant.report.show', $report->id)->with('success', 'Response berhasil dikirim');
    }

    /**
     * Handle completion timestamp dengan efficient query
     */
    private function handleCompletionTimestamp(ReportResponse $response): void
    {
        if ($response->report->status === self::STATUS_COMPLETED && !$response->actual_completion) {
            $response->update(['actual_completion' => now()]);
        }
    }

    /**
     * Log status history untuk audit trail
     */
    private function logStatusHistory(Report $report, string $status): void
    {
        ReportStatusHistory::create([
            'report_id' => $report->id,
            'old_status' => $report->getOriginal('status'), // Status sebelumnya
            'new_status' => $status, // Status baru
            'changed_by' => Auth::id(),
            'changed_at' => now(),
        ]);
    }

    /**
     * Check if user can delete response
     */
    private function canDeleteResponse(ReportResponse $response): bool
    {
        $user = Auth::user();
        return $user->role === 'admin' && $response->admin_id === $user->id;
    }

    /**
     * Update report status after response deletion
     */
    private function updateReportStatusAfterDeletion(Report $report): void
    {
        // Jika tidak ada response lagi, kembalikan ke pending
        if ($report->responses()->count() === 0) {
            $oldStatus = $report->status;
            $report->update(['status' => self::STATUS_PENDING]);

            // Log dengan old_status dan new_status
            ReportStatusHistory::create([
                'report_id' => $report->id,
                'old_status' => $oldStatus,
                'new_status' => self::STATUS_PENDING,
                'changed_by' => Auth::id(),
                'changed_at' => now(),
            ]);
        }
    }

    /**
     * Clear report-related caches
     */
    private function clearReportCaches(Report $report): void
    {
        $cacheKeys = [
            self::CACHE_PREFIX . 'report_' . $report->id,
            self::CACHE_PREFIX . 'responses_' . $report->id,
            'reports_dashboard_' . Auth::id(),
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Standardized success response
     */
    private function successResponse(string $message, $data = null): RedirectResponse
    {
        $response = back()->with('success', $message);

        if ($data) {
            $response->with('data', $data);
        }

        return $response;
    }

    /**
     * Get cached report responses untuk optimasi query
     */
    private function getCachedReportResponses(int $reportId): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'responses_' . $reportId,
            self::CACHE_TTL,
            fn() => ReportResponse::with('admin:id,name')
                ->where('report_id', $reportId)
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

    /**
     * Bulk operations untuk multiple responses (bonus optimization)
     */
    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'response_ids' => 'required|array',
            'response_ids.*' => 'exists:report_responses,id',
            'status' => 'required|string|in:pending,in_progress,completed'
        ]);

        DB::transaction(function () use ($request) {
            ReportResponse::whereIn('id', $request->response_ids)
                ->update([
                    'status' => $request->status,
                    'updated_at' => now()
                ]);

            // Clear related caches
            $reportIds = ReportResponse::whereIn('id', $request->response_ids)
                ->pluck('report_id')
                ->unique();

            foreach ($reportIds as $reportId) {
                Cache::forget(self::CACHE_PREFIX . 'responses_' . $reportId);
            }
        });

        return response()->json(['message' => 'Bulk update berhasil']);
    }
}
