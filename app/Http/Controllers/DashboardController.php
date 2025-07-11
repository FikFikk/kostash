<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Meter;
use App\Models\Transaction;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->startOfMonth()->subDay();

        // Core Statistics
        $stats = $this->getCoreStatistics($currentMonth, $lastMonth, $lastMonthEnd);

        // Financial Data
        $financialData = $this->getFinancialData($currentMonth, $lastMonth, $lastMonthEnd);

        // Room Analytics
        $roomAnalytics = $this->getRoomAnalytics();

        // Recent Activities
        $recentData = $this->getRecentActivities();

        // Chart Data with filter
        $chartData = $this->getChartData($request->get('period', '12_months'));

        // Alert Data
        $alerts = $this->getAlerts();

        // Additional data for view compatibility
        $viewData = $this->getViewCompatibleData($stats, $financialData, $roomAnalytics);

        // Check if this is an AJAX request
        if ($request->ajax()) {
            return response()->json($chartData);
        }

        return view('dashboard.admin.home.index', array_merge(
            $stats,
            $financialData,
            $roomAnalytics,
            $recentData,
            $chartData,
            $alerts,
            $viewData
        ));
    }

    private function getViewCompatibleData($stats, $financialData, $roomAnalytics)
    {
        // Map existing data to view variable names
        $totalRevenue = $stats['totalRevenueThisMonth'];
        $revenueGrowthPercent = $stats['revenueGrowth'];
        $totalTenants = $stats['totalActiveTenants'];
        
        // Calculate tenant growth percentage
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->startOfMonth()->subDay();
        
        $totalTenantsLastMonth = User::whereHas('room')
            ->where('created_at', '<=', $lastMonthEnd)
            ->count();
        
        $growthPercent = 0;
        if ($totalTenantsLastMonth > 0) {
            $growthPercent = (($totalTenants - $totalTenantsLastMonth) / $totalTenantsLastMonth) * 100;
        }
        
        // Get pending transactions count
        $totalPendingTransactionsCount = Meter::whereIn('payment_status', ['unpaid', 'partial'])
            ->count();
        
        $totalPendingTransactions = $stats['totalOutstanding'];

        return compact(
            'totalRevenue',
            'revenueGrowthPercent', 
            'totalTenants',
            'growthPercent',
            'totalPendingTransactionsCount',
            'totalPendingTransactions'
        );
    }

    private function getChartData($period = '12_months')
    {
        $monthlyRevenue = collect();
        $now = Carbon::now();
        
        // Determine the period range
        switch ($period) {
            case '6_months':
                $monthsBack = 5;
                break;
            case 'ytd':
                $monthsBack = $now->month - 1;
                break;
            case '1_year':
                $monthsBack = 11;
                break;
            case '3_years':
                $monthsBack = 35;
                break;
            case '5_years':
                $monthsBack = 59;
                break;
            default:
                $monthsBack = 11; // 12_months
        }

        // Build the collection from oldest to newest
        for ($i = $monthsBack; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            // Get revenue for this month using paid_at field
            $revenue = Meter::where('payment_status', 'paid')
                ->whereBetween('paid_at', [
                    $monthStart->format('Y-m-d H:i:s'),
                    $monthEnd->format('Y-m-d H:i:s')
                ])
                ->sum('total_bill');

            // If no data found using paid_at, try using period field as fallback
            if ($revenue == 0) {
                $revenue = Meter::where('payment_status', 'paid')
                    ->whereBetween('period', [
                        $monthStart->format('Y-m-01'),
                        $monthEnd->format('Y-m-d')
                    ])
                    ->sum('total_bill');
            }

            $monthlyRevenue->push([
                'month' => $month->format('M Y'),
                'revenue' => (float) $revenue,
                'period' => $month->format('Y-m'), // For debugging
            ]);
        }

        // Debug: Log the data to check if it's being populated correctly
        Log::info('Chart Data for period: ' . $period, [
            'monthsBack' => $monthsBack,
            'data' => $monthlyRevenue->toArray()
        ]);

        return compact('monthlyRevenue');
    }

    private function getCoreStatistics($currentMonth, $lastMonth, $lastMonthEnd)
    {
        // Total Revenue This Month from Meters
        $totalRevenueThisMonth = Meter::where('payment_status', 'paid')
            ->whereBetween('paid_at', [
                $currentMonth,
                $currentMonth->copy()->endOfMonth()
            ])
            ->sum('total_bill');

        // Total Revenue Last Month from Meters  
        $totalRevenueLastMonth = Meter::where('payment_status', 'paid')
            ->whereBetween('paid_at', [
                $lastMonth,
                $lastMonthEnd
            ])
            ->sum('total_bill');

        // Calculate growth percentage
        $revenueGrowth = 0;
        if ($totalRevenueLastMonth > 0) {
            $revenueGrowth = (($totalRevenueThisMonth - $totalRevenueLastMonth) / $totalRevenueLastMonth) * 100;
        }

        // Total Outstanding Bills
        $totalOutstanding = Meter::whereIn('payment_status', ['unpaid', 'partial'])
            ->sum('total_bill');

        // Total Rooms
        $totalRooms = Room::count();

        // Total Active Tenants
        $totalActiveTenants = User::whereHas('room')->count();

        return compact(
            'totalRevenueThisMonth',
            'totalRevenueLastMonth', 
            'revenueGrowth',
            'totalOutstanding',
            'totalRooms',
            'totalActiveTenants'
        );
    }

    private function getFinancialData($currentMonth, $lastMonth, $lastMonthEnd)
    {
        // Average Bill Amount
        $averageBill = Meter::where('payment_status', 'paid')
            ->whereBetween('paid_at', [
                $currentMonth,
                $currentMonth->copy()->endOfMonth()
            ])
            ->avg('total_bill');

        // Total Water Usage This Month
        $totalWaterUsage = Meter::whereBetween('period', [
                $currentMonth->format('Y-m-01'),
                $currentMonth->copy()->endOfMonth()->format('Y-m-d')
            ])
            ->sum('total_water');

        // Total Electric Usage This Month
        $totalElectricUsage = Meter::whereBetween('period', [
                $currentMonth->format('Y-m-01'),
                $currentMonth->copy()->endOfMonth()->format('Y-m-d')
            ])
            ->sum('total_electric');

        // Collection Rate (Paid vs Total Bills)
        $totalBillsThisMonth = Meter::whereBetween('period', [
                $currentMonth->format('Y-m-01'),
                $currentMonth->copy()->endOfMonth()->format('Y-m-d')
            ])
            ->count();

        $paidBillsThisMonth = Meter::where('payment_status', 'paid')
            ->whereBetween('period', [
                $currentMonth->format('Y-m-01'),
                $currentMonth->copy()->endOfMonth()->format('Y-m-d')
            ])
            ->count();

        $collectionRate = $totalBillsThisMonth > 0 ? ($paidBillsThisMonth / $totalBillsThisMonth) * 100 : 0;

        return compact(
            'averageBill',
            'totalWaterUsage',
            'totalElectricUsage',
            'collectionRate'
        );
    }

    private function getRoomAnalytics()
    {
        // Rooms with tenants
        $roomsWithTenants = Room::whereHas('users')->count();
        
        // Rooms without tenants
        $roomsWithoutTenants = Room::whereDoesntHave('users')->count();
        
        // Occupancy Rate
        $totalRooms = Room::count();
        $occupancyRate = $totalRooms > 0 ? ($roomsWithTenants / $totalRooms) * 100 : 0;

        return compact('roomsWithTenants', 'roomsWithoutTenants', 'occupancyRate', 'totalRooms');
    }

    private function getRecentActivities()
    {
        // Recent Payments
        $recentPayments = Meter::where('payment_status', 'paid')
            ->with(['room', 'user'])
            ->orderBy('paid_at', 'desc')
            ->take(10)
            ->get();

        // Recent Unpaid Bills
        $recentUnpaidBills = Meter::where('payment_status', 'unpaid')
            ->with(['room', 'user'])
            ->orderBy('period', 'desc')
            ->take(10)
            ->get();

        return compact('recentPayments', 'recentUnpaidBills');
    }

    private function getAlerts()
    {
        // Overdue Bills (older than 30 days)
        $overdueBills = Meter::where('payment_status', 'unpaid')
            ->where('period', '<', Carbon::now()->subDays(30)->format('Y-m-01'))
            ->count();

        // High Usage Alerts (above average + 50%)
        $averageWaterUsage = Meter::avg('total_water');
        $averageElectricUsage = Meter::avg('total_electric');
        
        $highUsageAlerts = Meter::where(function($query) use ($averageWaterUsage, $averageElectricUsage) {
                $query->where('total_water', '>', $averageWaterUsage * 1.5)
                      ->orWhere('total_electric', '>', $averageElectricUsage * 1.5);
            })
            ->whereBetween('period', [
                Carbon::now()->startOfMonth()->format('Y-m-01'),
                Carbon::now()->endOfMonth()->format('Y-m-d')
            ])
            ->count();

        return compact('overdueBills', 'highUsageAlerts');
    }
}
