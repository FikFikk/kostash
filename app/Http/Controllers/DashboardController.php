<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Gallery;
use App\Models\GlobalSetting;
use App\Models\Meter;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data dasar
        $bills = Bill::all();
        $galleries = Gallery::all();
        $globalSettings = GlobalSetting::all();
        $meters = Meter::all();
        $rooms = Room::all();
        $users = User::all();

        // Statistik Revenue (dari tabel bills)
        $totalRevenue = $meters->sum('total_bill');
        $totalPaidBills = $bills->where('status', 'paid')->sum('total_amount');
        $totalUnpaidBills = $bills->where('status', 'unpaid')->sum('total_amount');

        // Statistik Bills
        $totalBills = $bills->count();
        $totalPaidBillsCount = $bills->where('status', 'paid')->count();
        $totalUnpaidBillsCount = $bills->where('status', 'unpaid')->count();

        // Average charges
        $averageRoomCharge = $bills->avg('room_charge') ?? 0;
        $averageWaterCharge = $bills->avg('water_charge') ?? 0;
        $averageElectricCharge = $bills->avg('electric_charge') ?? 0;
        $averageTotalAmount = $bills->avg('total_amount') ?? 0;

        // Statistik Users (berdasarkan role)
        $totalUsers = $users->count();
        $totalAdmins = $users->where('role', 'admin')->count();
        $totalTenants = $users->where('role', 'tenants')->count();
        $totalActiveUsers = $users->where('status', 'aktif')->count();
        $totalInactiveUsers = $users->where('status', 'tidak_aktif')->count();

        // Statistik Rooms (berdasarkan status dan occupancy)
        $totalRooms = $rooms->count();
        $availableRooms = $rooms->where('status', 'available')->count();
        $occupiedRooms = $rooms->where('status', 'occupied')->count();
        
        // Rooms dengan penghuni (cek dari users->room_id)
        $roomsWithTenants = $users->whereNotNull('room_id')->pluck('room_id')->unique()->count();
        $roomsWithoutTenants = $totalRooms - $roomsWithTenants;
        $occupancyRate = $totalRooms > 0 ? ($roomsWithTenants / $totalRooms) * 100 : 0;

        // Statistik Meters
        $totalMeters = $meters->count();
        $totalWaterUsage = $meters->sum('total_water') ?? 0;
        $totalElectricUsage = $meters->sum('total_electric') ?? 0;
        $totalBillFromMeters = $meters->sum('total_bill') ?? 0;
        $averageWaterUsage = $meters->avg('total_water') ?? 0;
        $averageElectricUsage = $meters->avg('total_electric') ?? 0;

        // Global Settings (harga dari global_settings)
        $monthlyRoomPrice = $globalSettings->where('id', 1)->first()->monthly_room_price ?? 0;
        $waterPrice = $globalSettings->where('id', 1)->first()->water_price ?? 0;
        $electricPrice = $globalSettings->where('id', 1)->first()->electric_price ?? 0;

        // Statistik Gallery
        $totalGalleryItems = $galleries->count();

        $startOfThisMonth = Carbon::now()->startOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->startOfMonth()->subDay();

        $tenantsThisMonth = User::where('role', 'tenants')
            ->whereBetween('created_at', [$startOfThisMonth, now()])
            ->count();

        $tenantsLastMonth = User::where('role', 'tenants')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();

        // growth dalam persentase
        $growthPercent = $tenantsLastMonth > 0
            ? (($tenantsThisMonth - $tenantsLastMonth) / $tenantsLastMonth) * 100
            : ($tenantsThisMonth > 0 ? 100 : 0);

        // Data untuk Chart - Monthly Revenue
        $monthlyRevenue = $bills->where('status', 'paid')
            ->groupBy(function($bill) {
                return date('Y-m', strtotime($bill->created_at));
            })
            ->map(function($bills) {
                return $bills->sum('total_amount');
            })
            ->take(12); // Ambil 12 bulan terakhir

        // Bill status distribution untuk pie chart
        $billStatusDistribution = [
            'paid' => $totalPaidBillsCount,
            'unpaid' => $totalUnpaidBillsCount
        ];

        // Room status distribution untuk pie chart
        $roomStatusDistribution = [
            'available' => $availableRooms,
            'occupied' => $occupiedRooms
        ];

        // User role distribution
        $userRoleDistribution = [
            'admin' => $totalAdmins,
            'tenants' => $totalTenants
        ];

        // Recent activities (5 latest bills dengan relasi)
        $recentBills = Bill::with(['user', 'room', 'meter'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Top 5 highest bills
        $topBills = $bills->sortByDesc('total_amount')->take(5);

        // Monthly usage trends
        $monthlyWaterUsage = $meters->groupBy(function($meter) {
                return date('Y-m', strtotime($meter->created_at));
            })
            ->map(function($meters) {
                return $meters->sum('total_water');
            })
            ->take(12);

        $monthlyElectricUsage = $meters->groupBy(function($meter) {
                return date('Y-m', strtotime($meter->created_at));
            })
            ->map(function($meters) {
                return $meters->sum('total_electric');
            })
            ->take(12);

        // Room facilities analysis (dari JSON field)
        $facilitiesCount = [];
        foreach($rooms as $room) {
            if($room->facilities) {
                $facilities = json_decode($room->facilities, true);
                if(is_array($facilities)) {
                    foreach($facilities as $facility) {
                        $facilitiesCount[$facility] = ($facilitiesCount[$facility] ?? 0) + 1;
                    }
                }
            }
        }

        return view('dashboard.admin.home.index', compact(
            // Data dasar
            'bills', 'galleries', 'globalSettings', 'meters', 'rooms', 'users',
            
            // Revenue Statistics
            'totalRevenue', 'totalPaidBills', 'totalUnpaidBills',
            'averageRoomCharge', 'averageWaterCharge', 'averageElectricCharge', 'averageTotalAmount',
            
            // Bill Statistics
            'totalBills', 'totalPaidBillsCount', 'totalUnpaidBillsCount',
            
            // User Statistics
            'totalUsers', 'totalAdmins', 'totalTenants', 'totalActiveUsers', 'totalInactiveUsers', 'growthPercent',
            
            // Room Statistics
            'totalRooms', 'availableRooms', 'occupiedRooms',
            'roomsWithTenants', 'roomsWithoutTenants', 'occupancyRate',
            
            // Meter Statistics
            'totalMeters', 'totalWaterUsage', 'totalElectricUsage', 'totalBillFromMeters',
            'averageWaterUsage', 'averageElectricUsage',
            
            // Global Settings
            'monthlyRoomPrice', 'waterPrice', 'electricPrice',
            
            // Gallery Statistics
            'totalGalleryItems',
            
            // Chart/Graph Data
            'monthlyRevenue', 'billStatusDistribution', 'roomStatusDistribution', 'userRoleDistribution',
            'monthlyWaterUsage', 'monthlyElectricUsage',
            
            // Additional Data
            'recentBills', 'topBills', 'facilitiesCount'
        ));
    }
}
