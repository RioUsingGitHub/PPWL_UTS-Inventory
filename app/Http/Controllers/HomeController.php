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

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Total inventory value
        $totalValue = Inventory::join('items', 'inventories.item_id', '=', 'items.id')
            ->selectRaw('SUM(inventories.on_hand_quantity * items.unit_price) as total_value')
            ->first()->total_value ?? 0;

        // Total items count
        $totalItems = Item::count();

        // Total transactions count
        $totalTransactions = Transaction::count();

        // Last month vs current month transaction growth
        $currentMonthTransactions = Transaction::whereMonth('created_at', Carbon::now()->month)->count();
        $lastMonthTransactions = Transaction::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $transactionGrowth = $lastMonthTransactions > 0 
            ? round((($currentMonthTransactions - $lastMonthTransactions) / $lastMonthTransactions) * 100, 2)
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
            'totalValue', 
            'totalItems', 
            'totalTransactions', 
            'transactionGrowth',
            'chartLabels',
            'chartData',
            'topCategories'
        ));
    }
}