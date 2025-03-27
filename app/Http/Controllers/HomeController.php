<?php
// app/Http/Controllers/HomeController.php (Updated for Dashboard)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Inventory;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Total inventory value and its growth
        $currentInventoryValue = Inventory::join('items', 'inventories.item_id', '=', 'items.id')
            ->selectRaw('SUM(inventories.on_hand_quantity * items.unit_price) as total_value')
            ->first()->total_value ?? 0;

        $lastMonthInventoryValue = Inventory::join('items', 'inventories.item_id', '=', 'items.id')
            ->join('transactions', 'items.id', '=', 'transactions.item_id')
            ->whereMonth('transactions.created_at', Carbon::now()->subMonth()->month)
            ->selectRaw('SUM(transactions.total_price) as total_value')
            ->first()->total_value ?? 0;

        $inventoryGrowth = $lastMonthInventoryValue > 0 
            ? round((($currentInventoryValue - $lastMonthInventoryValue) / $lastMonthInventoryValue) * 100, 2)
            : 100;

        // Items count and growth
        $currentItemsCount = Item::count();
        $lastMonthItemsCount = Item::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $itemsGrowth = $lastMonthItemsCount > 0 
            ? round((($currentItemsCount - $lastMonthItemsCount) / $lastMonthItemsCount) * 100, 2)
            : 100;

        // Transactions count and trends
        $currentMonthTransactions = Transaction::whereMonth('created_at', Carbon::now()->month)->count();
        $lastMonthTransactions = Transaction::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $lastQuarterTransactions = Transaction::whereBetween('created_at', [
            Carbon::now()->subMonths(3)->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count() / 3; // Average per month in last quarter

        $transactionMonthGrowth = $lastMonthTransactions > 0 
            ? round((($currentMonthTransactions - $lastMonthTransactions) / $lastMonthTransactions) * 100, 2)
            : 100;

        $transactionQuarterGrowth = $lastQuarterTransactions > 0 
            ? round((($currentMonthTransactions - $lastQuarterTransactions) / $lastQuarterTransactions) * 100, 2)
            : 100;

        // Sales data and trends
        $currentMonthSales = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->sum('total_price');
        $lastMonthSales = Transaction::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('total_price');
        
        $salesGrowth = $lastMonthSales > 0 
            ? round((($currentMonthSales - $lastMonthSales) / $lastMonthSales) * 100, 2)
            : 100;

        // Monthly transaction data for chart
        $monthlyData = Transaction::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Format data for ChartJS
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('M', mktime(0, 0, 0, $i, 1));
            $chartLabels[] = $monthName;
            $chartData[] = $monthlyData[$i] ?? 0;
        }

        // Top categories by transactions
        $topCategories = Item::join('transactions', 'items.id', '=', 'transactions.item_id')
            ->selectRaw('items.category, COUNT(*) as transaction_count, SUM(transactions.total_price) as total_value')
            ->groupBy('items.category')
            ->orderByDesc('transaction_count')
            ->limit(4)
            ->get();

        return view('pages.dashboard', compact(
            'currentInventoryValue',
            'inventoryGrowth',
            'currentItemsCount',
            'itemsGrowth',
            'currentMonthTransactions',
            'transactionMonthGrowth',
            'transactionQuarterGrowth',
            'currentMonthSales',
            'salesGrowth',
            'chartLabels',
            'chartData',
            'topCategories'
        ));
    }
}