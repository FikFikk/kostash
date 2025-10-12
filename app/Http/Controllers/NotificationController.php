<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request, Notification $notification)
    {
        // Ensure notification belongs to current user
        if ($notification->notifiable_id !== Auth::id()) {
            abort(403);
        }

        $notification->markAsRead();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notification marked as read');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $count = NotificationService::markAllAsRead(Auth::user());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "{$count} notifications marked as read"
            ]);
        }

        return back()->with('success', "{$count} notifications marked as read");
    }

    /**
     * Delete notification
     */
    public function destroy(Request $request, Notification $notification)
    {
        // Ensure notification belongs to current user
        if ($notification->notifiable_id !== Auth::id()) {
            abort(403);
        }

        $notification->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notification deleted');
    }

    /**
     * Admin notification page
     */
    public function adminIndex(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            // Admin: tampilkan semua notifikasi
            $notifications = \App\Models\Notification::orderBy('created_at', 'desc')->limit(100)->get();
            $unreadCount = $notifications->whereNull('read_at')->count();
        } else {
            // Non-admin: hanya notifikasi milik user
            $notifications = NotificationService::getForUser($user, 50);
            $unreadCount = NotificationService::getUnreadCount($user);
        }

        // Group notifications by type for tabs
        $groupedNotifications = [
            'all' => $notifications,
            'transaction' => $notifications->where('type', 'transaction'),
            'report' => $notifications->where('type', 'report'),
            'system' => $notifications->whereIn('type', ['payment', 'general'])
        ];

        // Count by type
        $counts = [
            'all' => $notifications->count(),
            'transaction' => $groupedNotifications['transaction']->count(),
            'report' => $groupedNotifications['report']->count(),
            'system' => $groupedNotifications['system']->count(),
            'unread' => $unreadCount
        ];

        return view('dashboard.admin.notifications.index', compact('groupedNotifications', 'counts'));
    }

    /**
     * Admin notification data (AJAX)
     */
    public function adminData(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $type = $request->get('type');
        $search = $request->get('search');

        $query = Notification::with('notifiable')
            ->latest()
            ->when($type, function ($q) use ($type) {
                if ($type === 'system') {
                    return $q->whereIn('type', ['payment', 'general']);
                }
                return $q->where('type', $type);
            })
            ->when($search, function ($q) use ($search) {
                return $q->where('data', 'like', "%{$search}%");
            });

        $notifications = $query->paginate($perPage);

        return response()->json([
            'notifications' => $notifications
        ]);
    }

    /**
     * Tenant notification page  
     */
    public function tenantIndex(Request $request)
    {
        $user = Auth::user();
        $notifications = NotificationService::getForUser($user, 50);
        $unreadCount = NotificationService::getUnreadCount($user);

        // Group notifications by type for tabs
        $groupedNotifications = [
            'all' => $notifications,
            'transaction' => $notifications->where('type', 'transaction'),
            'report' => $notifications->where('type', 'report'),
            'system' => $notifications->whereIn('type', ['payment', 'general'])
        ];

        // Count by type
        $counts = [
            'all' => $notifications->count(),
            'transaction' => $groupedNotifications['transaction']->count(),
            'report' => $groupedNotifications['report']->count(),
            'system' => $groupedNotifications['system']->count(),
            'unread' => $unreadCount
        ];

        return view('dashboard.tenants.notifications.index', compact('groupedNotifications', 'counts'));
    }

    /**
     * Tenant notification data (AJAX)
     */
    public function tenantData(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->get('per_page', 15);
        $type = $request->get('type');
        $search = $request->get('search');

        $query = Notification::where('notifiable_id', $user->id)
            ->latest()
            ->when($type, function ($q) use ($type) {
                if ($type === 'system') {
                    return $q->whereIn('type', ['payment', 'general']);
                }
                return $q->where('type', $type);
            })
            ->when($search, function ($q) use ($search) {
                return $q->where('data', 'like', "%{$search}%");
            });

        $notifications = $query->paginate($perPage);

        return response()->json([
            'notifications' => $notifications
        ]);
    }
}
