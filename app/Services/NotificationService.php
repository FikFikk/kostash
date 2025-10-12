<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;

class NotificationService
{
    /**
     * Create a new notification
     */
    public static function create(
        User $user,
        string $type,
        string $title,
        string $message,
        array $extra = []
    ): Notification {
        return Notification::create([
            'type' => $type,
            'notifiable_id' => $user->id,
            'notifiable_type' => User::class,
            'data' => json_encode(array_merge([
                'title' => $title,
                'message' => $message,
                'icon' => self::getIconByType($type),
                'url' => null,
                'created_at_human' => now()->format('M d, Y H:i')
            ], $extra)),
        ]);
    }

    /**
     * Create transaction notification
     */
    public static function transaction(User $user, string $action, $transaction, array $extra = []): Notification
    {
        $titles = [
            'created' => 'Tagihan Baru Dibuat',
            'paid' => 'Pembayaran Berhasil',
            'failed' => 'Pembayaran Gagal',
            'pending' => 'Pembayaran Sedang Diproses'
        ];

        // Handle both transaction object and additional data
        if ($transaction) {
            $messages = [
                'created' => "Tagihan sebesar Rp " . number_format($transaction->amount) . " telah dibuat untuk periode " . $transaction->period,
                'paid' => "Pembayaran sebesar Rp " . number_format($transaction->amount) . " telah berhasil diproses",
                'failed' => "Pembayaran sebesar Rp " . number_format($transaction->amount) . " gagal diproses",
                'pending' => "Pembayaran sebesar Rp " . number_format($transaction->amount) . " sedang diverifikasi"
            ];

            $transactionData = [
                'transaction_id' => $transaction->id,
                'amount' => $transaction->amount,
                'period' => $transaction->period ?? null,
                'url' => route('tenant.home')
            ];
        } else {
            // Use additional data when transaction object is not available
            $amount = $extra['amount'] ?? 'Rp 0';
            $description = $extra['description'] ?? '';

            $messages = [
                'created' => "Tagihan baru telah dibuat. {$description}",
                'paid' => "Pembayaran sebesar {$amount} telah berhasil diproses",
                'failed' => "Pembayaran sebesar {$amount} gagal diproses",
                'pending' => "Pembayaran sebesar {$amount} sedang diverifikasi"
            ];

            $transactionData = [
                'amount' => $amount,
                'description' => $description,
                'url' => route('tenant.home')
            ];
        }

        return self::create(
            $user,
            'transaction',
            $titles[$action] ?? 'Notifikasi Transaksi',
            $messages[$action] ?? 'Ada update pada transaksi Anda',
            array_merge($transactionData, $extra)
        );
    }

    /**
     * Create report notification
     */
    public static function report(User $user, string $action, $report, array $extra = []): Notification
    {
        $titles = [
            'created' => 'Laporan Baru Diterima',
            'status_updated' => 'Status Laporan Diperbarui',
            'response_added' => 'Laporan Direspon',
            'response_updated' => 'Respon Laporan Diperbarui',
            'deleted' => 'Laporan Dihapus',
            'resolved' => 'Laporan Diselesaikan',
            'rejected' => 'Laporan Ditolak'
        ];

        if ($report) {
            $messages = [
                'created' => "Laporan baru '{$report->title}' telah diterima dan akan segera ditindaklanjuti",
                'status_updated' => "Status laporan '{$report->title}' telah diperbarui",
                'response_added' => "Laporan '{$report->title}' telah mendapat respon dari admin",
                'response_updated' => "Respon laporan '{$report->title}' telah diperbarui",
                'resolved' => "Laporan '{$report->title}' telah diselesaikan",
                'rejected' => "Laporan '{$report->title}' telah ditolak"
            ];

            // Tentukan url berdasarkan role user
            if (method_exists($user, 'hasRole') ? $user->hasRole('admin') : ($user->role ?? null) === 'admin') {
                $url = route('dashboard.report.show', $report->id);
            } else {
                $url = route('tenant.report.show', $report->id);
            }

            $reportData = [
                'report_id' => $report->id,
                'report_title' => $report->title,
                'url' => $url
            ];
        } else {
            // Use additional data when report object is not available
            $reportTitle = $extra['report_title'] ?? 'laporan Anda';
            $reportId = $extra['report_id'] ?? null;

            $messages = [
                'created' => "Laporan baru '{$reportTitle}' telah diterima dan akan segera ditindaklanjuti",
                'status_updated' => "Status laporan '{$reportTitle}' telah diperbarui",
                'response_added' => "Laporan '{$reportTitle}' telah mendapat respon dari admin",
                'response_updated' => "Respon laporan '{$reportTitle}' telah diperbarui",
                'deleted' => "Laporan '{$reportTitle}' telah dihapus oleh admin",
                'resolved' => "Laporan '{$reportTitle}' telah diselesaikan",
                'rejected' => "Laporan '{$reportTitle}' telah ditolak"
            ];

            // Tentukan url berdasarkan role user
            if (method_exists($user, 'hasRole') ? $user->hasRole('admin') : ($user->role ?? null) === 'admin') {
                $url = $reportId ? route('dashboard.report.show', $reportId) : route('dashboard.report.index');
            } else {
                $url = $reportId ? route('tenant.report.show', $reportId) : route('tenant.report.index');
            }

            $reportData = [
                'report_title' => $reportTitle,
                'url' => $url
            ];
            if ($reportId) {
                $reportData['report_id'] = $reportId;
            }
        }

        return self::create(
            $user,
            'report',
            $titles[$action] ?? 'Notifikasi Laporan',
            $messages[$action] ?? 'Ada update pada laporan Anda',
            array_merge($reportData, $extra)
        );
    }

    /**
     * Create payment notification
     */
    public static function payment(User $user, string $action, $payment, array $extra = []): Notification
    {
        $titles = [
            'success' => 'Pembayaran Berhasil',
            'failed' => 'Pembayaran Gagal',
            'pending' => 'Pembayaran Pending',
            'expired' => 'Pembayaran Kedaluwarsa'
        ];

        $messages = [
            'success' => "Pembayaran Anda sebesar Rp " . number_format($payment->amount ?? 0) . " telah berhasil diproses",
            'failed' => "Pembayaran Anda sebesar Rp " . number_format($payment->amount ?? 0) . " gagal diproses",
            'pending' => "Pembayaran Anda sebesar Rp " . number_format($payment->amount ?? 0) . " sedang diproses",
            'expired' => "Pembayaran Anda sebesar Rp " . number_format($payment->amount ?? 0) . " telah kedaluwarsa"
        ];

        return self::create(
            $user,
            'payment',
            $titles[$action] ?? 'Notifikasi Pembayaran',
            $messages[$action] ?? 'Ada update pada pembayaran Anda',
            array_merge([
                'payment_id' => $payment->id ?? null,
                'amount' => $payment->amount ?? 0,
                'url' => route('tenant.home')
            ], $extra)
        );
    }

    /**
     * Create general notification
     */
    public static function general(User $user, string $title, string $message, array $extra = []): Notification
    {
        return self::create(
            $user,
            'general',
            $title,
            $message,
            $extra
        );
    }

    /**
     * Get notifications by type for user
     */
    public static function getByType(User $user, ?string $type = null, int $limit = 10)
    {
        $query = $user->notifications()->orderBy('created_at', 'desc');

        if ($type && $type !== 'all') {
            $query->where('type', $type);
        }

        return $query->limit($limit)->get();
    }

    /**
     * Get notifications for user
     */
    public static function getForUser(User $user, $limit = 10)
    {
        return Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', User::class)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get unread count for a user
     */
    public static function getUnreadCount(User $user): int
    {
        return Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', User::class)
            ->unread()
            ->count();
    }

    /**
     * Mark all notifications as read for a user
     */
    public static function markAllAsRead(User $user): int
    {
        return Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', User::class)
            ->unread()
            ->update(['read_at' => now()]);
    }

    /**
     * Get icon by notification type
     */
    private static function getIconByType(string $type): string
    {
        return match ($type) {
            'transaction' => 'bx-wallet',
            'payment' => 'bx-credit-card',
            'report' => 'bx-message-alt-detail',
            'general' => 'bx-bell',
            default => 'bx-info-circle'
        };
    }
}
