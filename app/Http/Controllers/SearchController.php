<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Inventory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $results = [];

        if (empty($query)) {
            return response()->json($results);
        }

        // Search items if user has permission
        if (Gate::allows('view-items')) {
            $items = Item::where('name', 'like', "%{$query}%")
                ->orWhere('sku', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'type' => 'Item',
                        'id' => $item->id,
                        'title' => $item->name,
                        'subtitle' => "SKU: {$item->sku}",
                        'url' => route('items.show', $item->id)
                    ];
                });
            $results = array_merge($results, $items->toArray());
        }

        // Search inventory if user has permission
        if (Gate::allows('view-inventory')) {
            $inventory = Inventory::with('item')
                ->whereHas('item', function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('sku', 'like', "%{$query}%");
                })
                ->orWhere('location', 'like', "%{$query}%")
                ->limit(5)
                ->get()
                ->map(function ($inv) {
                    return [
                        'type' => 'Inventory',
                        'id' => $inv->id,
                        'title' => $inv->item->name,
                        'subtitle' => "Location: {$inv->location} | Qty: {$inv->on_hand_quantity}",
                        'url' => route('inventory.show', $inv->id)
                    ];
                });
            $results = array_merge($results, $inventory->toArray());
        }

        // Search transactions if user has permission
        if (Gate::allows('view-transactions')) {
            $transactions = Transaction::with(['item', 'user'])
                ->whereHas('item', function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('sku', 'like', "%{$query}%");
                })
                ->orWhereHas('user', function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })
                ->limit(5)
                ->get()
                ->map(function ($transaction) {
                    return [
                        'type' => 'Transaction',
                        'id' => $transaction->id,
                        'title' => $transaction->item->name,
                        'subtitle' => "Type: {$transaction->type} | By: {$transaction->user->name}",
                        'url' => route('transactions.show', $transaction->id)
                    ];
                });
            $results = array_merge($results, $transactions->toArray());
        }

        return response()->json($results);
    }
} 