<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportResponse;
use App\Models\ReportStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportResponseController extends Controller
{
    /**
     * Store a new response to a report (Admin only)
     */
    public function store(Request $request, Report $report)
    {
        // Hanya admin yang bisa memberi respons
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'response_text' => 'required|string',
            'action_taken' => 'nullable|string',
            'estimated_completion' => 'nullable|date|after:now',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Create response
            $response = ReportResponse::create([
                'report_id' => $report->id,
                'admin_id' => Auth::id(),
                'response_text' => $request->response_text,
                'action_taken' => $request->action_taken,
                'estimated_completion' => $request->estimated_completion,
                'notes' => $request->notes
            ]);

            // Auto update status ke in_progress jika masih pending
            if ($report->status === 'pending') {
                $report->update(['status' => 'in_progress']);
                
                ReportStatusHistory::create([
                    'report_id' => $report->id,
                    'old_status' => 'pending',
                    'new_status' => 'in_progress',
                    'changed_by' => Auth::id(),
                    'reason' => 'Admin memberikan respons'
                ]);
            }

            DB::commit();
            
            return back()->with('success', 'Respons berhasil dikirim');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal mengirim respons: ' . $e->getMessage()]);
        }
    }

    /**
     * Update response
     */
    public function update(Request $request, ReportResponse $response)
    {
        // Hanya admin pemilik respons yang bisa edit
        if (Auth::user()->role !== 'admin' || $response->admin_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'response_text' => 'required|string',
            'action_taken' => 'nullable|string',
            'estimated_completion' => 'nullable|date|after:now',
            'actual_completion' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $response->update($request->only([
            'response_text',
            'action_taken', 
            'estimated_completion',
            'actual_completion',
            'notes'
        ]));

        return back()->with('success', 'Respons berhasil diperbarui');
    }

    /**
     * Delete response
     */
    public function destroy(ReportResponse $response)
    {
        // Hanya admin pemilik respons yang bisa hapus
        if (Auth::user()->role !== 'admin' || $response->admin_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $response->delete();
        
        return back()->with('success', 'Respons berhasil dihapus');
    }
}