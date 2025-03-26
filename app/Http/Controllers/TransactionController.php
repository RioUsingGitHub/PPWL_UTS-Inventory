<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Item;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-transactions', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-transactions', ['only' => ['create', 'store']]);
    }

    public function index()
    {
        $transactions = Transaction::with(['item', 'user'])->latest()->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['item', 'user']);
        return view('transactions.show', compact('transaction'));
    }

    public function create()
    {
        $items = Item::has('inventory')->get();
        return view('transactions.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'type' => 'required|in:on_hand,off_hand',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $item = Item::findOrFail($validated['item_id']);
        $inventory = $item->inventory;

        // Calculate totals
        $quantity = $validated['quantity'];
        $totalPrice = $quantity * $item->unit_price;
        $totalWeight = $quantity * $item->unit_weight;

        // Create transaction record
        $transaction = Transaction::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'total_weight' => $totalWeight,
            'notes' => $validated['notes'],
        ]);

        // Update inventory
        if ($validated['type'] == 'on_hand') {
            $inventory->update([
                'on_hand_quantity' => $inventory->on_hand_quantity + $quantity,
            ]);
        } else {
            // Verify we have enough on_hand quantity
            if ($inventory->on_hand_quantity < $quantity) {
                return back()->withErrors(['quantity' => 'Not enough on-hand quantity available.'])->withInput();
            }
            
            $inventory->update([
                'on_hand_quantity' => $inventory->on_hand_quantity - $quantity,
                'off_hand_quantity' => $inventory->off_hand_quantity + $quantity,
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }
}