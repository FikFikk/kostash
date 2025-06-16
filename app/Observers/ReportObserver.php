<?php

namespace App\Observers;

use App\Models\Report;
use App\Models\ReportStatusHistory;
use Illuminate\Support\Facades\Auth;

class ReportObserver
{
    /**
     * Handle the Report "created" event.
     * Menangani event "created" pada model Report.
     *
     * Event ini dieksekusi HANYA SATU KALI, yaitu tepat setelah sebuah
     * laporan baru berhasil disimpan ke database untuk pertama kalinya.
     * Tujuannya adalah untuk mencatat status awal ('pending').
     *
     * @param  \App\Models\Report  $report
     * @return void
     */
    public function created(Report $report): void
    {
        // Langsung buat catatan histori untuk status awal
        ReportStatusHistory::create([
            'report_id'  => $report->id,
            'old_status' => null, // Status lama masih kosong karena ini data baru
            'new_status' => $report->status, // Status baru pasti 'pending'
            'changed_by' => Auth::id(), // Diubah oleh user yang membuat laporan
            'reason'     => 'Laporan baru dibuat oleh pengguna.',
        ]);
    }

    /**
     * Handle the Report "updated" event.
     * Menangani event "updating" pada model Report.
     *
     * Event ini dieksekusi SETIAP KALI sebuah laporan yang sudah ada
     * akan di-update, TEPAT SEBELUM perubahannya disimpan ke database.
     * Ini memungkinkan kita untuk membandingkan data lama dan data baru.
     *
     * @param  \App\Models\Report  $report
     * @return void
     */
    public function updated(Report $report): void
    {
        // isDirty('status') adalah pengecekan paling penting di sini.
        // Artinya: "Hanya jalankan kode di bawah ini jika kolom 'status' benar-benar ada dalam daftar perubahan."
        // Ini mencegah pembuatan log yang tidak perlu jika admin hanya mengedit judul atau deskripsi.
        if ($report->isDirty('status')) {

            // Siapkan alasan perubahan. Jika ada input 'reason' dari form, gunakan itu.
            // Jika tidak, berikan alasan default yang informatif.
            $reason = request()->input(
                'reason', // Ambil dari input form jika ada
                'Status diperbarui oleh Admin.' // Alasan default
            );

            // Buat catatan histori perubahan status
            ReportStatusHistory::create([
                'report_id'  => $report->id,
                // getOriginal('status') -> mengambil nilai 'status' SEBELUM diubah.
                'old_status' => $report->getOriginal('status'),
                // $report->status -> berisi nilai 'status' YANG BARU.
                'new_status' => $report->status,
                // Diubah oleh admin yang sedang login
                'changed_by' => Auth::id(),
                'reason'     => $reason,
            ]);
        }
    }

    /**
     * Handle the Report "deleted" event.
     */
    public function deleted(Report $report): void
    {
        // Jika ingin melakukan sesuatu saat laporan dihapus,
        // seperti menghapus file terkait secara otomatis (meskipun sudah ada di controller),
        // atau mencatat log penghapusan di tempat lain.
        // Contoh: Log::info("Laporan #{$report->id} telah dihapus oleh user " . Auth::id());
    }

    /**
     * Handle the Report "restored" event.
     */
    public function restored(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "force deleted" event.
     */
    public function forceDeleted(Report $report): void
    {
        //
    }
}
