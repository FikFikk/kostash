<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportResponse;
use App\Models\ReportStatusHistory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReportResponseRequest;
use App\Http\Requests\UpdateReportResponseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportResponseController extends Controller
{
    /**
     * Store a new response to a report (Admin only).
     * Versi ini sudah diperbaiki untuk mencegah duplikasi histori status.
     */
    public function store(StoreReportResponseRequest $request, Report $report)
    {
        // Otorisasi dan validasi kini ditangani oleh StoreReportResponseRequest.

        DB::transaction(function () use ($request, $report) {
            // 1. Buat catatan respons dari admin.
            ReportResponse::create(array_merge($request->validated(), [
                'report_id' => $report->id,
                'admin_id'  => Auth::id(),
            ]));

            // 2. Jika status laporan masih 'pending', ubah menjadi 'in_progress'.
            //    Saat baris ini dijalankan, ReportObserver akan otomatis berjalan
            //    dan membuat SATU catatan histori.
            if ($report->status === 'pending') {
                $report->update(['status' => 'in_progress']);
            }

            // DIHAPUS: Blok ReportStatusHistory::create(...) yang manual sudah dihapus dari sini
            // untuk mencegah duplikasi.

        }); // DB::commit() akan otomatis dijalankan jika tidak ada error.

        return back()->with('success', 'Respons berhasil dikirim');
    }

    /**
     * Update an existing response.
     */
    public function update(UpdateReportResponseRequest $request, ReportResponse $response)
    {
        // Otorisasi dan validasi ditangani oleh UpdateReportResponseRequest.
        $response->update($request->validated());
        
        if($response->report->status === 'completed' && !$response->actual_completion) {
            $response->update(['actual_completion' => now()]);
        }

        return back()->with('success', 'Respons berhasil diperbarui');
    }

    /**
     * Delete a response.
     */
    public function destroy(ReportResponse $response)
    {
        // Anda bisa menambahkan otorisasi di sini jika diperlukan
        if (Auth::user()->role !== 'admin' || $response->admin_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $response->delete();
        
        return back()->with('success', 'Respons berhasil dihapus');
    }
}