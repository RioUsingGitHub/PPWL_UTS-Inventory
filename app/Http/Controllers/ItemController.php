<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Inventory;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-items', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-items', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-items', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-items', ['only' => ['destroy']]);
        $this->middleware('permission:view-items', ['only' => ['export']]);
    }
    
    public function index(Request $request)
    {
        $query = Item::with('inventory');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Price filter
        if ($request->filled('price')) {
            switch ($request->price) {
                case '0-10':
                    $query->where('unit_price', '<=', 10);
                    break;
                case '10-50':
                    $query->where('unit_price', '>', 10)
                          ->where('unit_price', '<=', 50);
                    break;
                case '50-100':
                    $query->where('unit_price', '>', 50)
                          ->where('unit_price', '<=', 100);
                    break;
                case '100+':
                    $query->where('unit_price', '>', 100);
                    break;
            }
        }

        $items = $query->paginate(10);
        $totalItems = Item::count();
        $categoryCount = Item::distinct('category')->count();
        $averagePrice = Item::avg('unit_price') ?? 0;
        $totalValue = Item::join('inventories', 'items.id', '=', 'inventories.item_id')
            ->selectRaw('SUM(items.unit_price * inventories.on_hand_quantity) as total')
            ->value('total') ?? 0;
        $categories = Item::distinct('category')->pluck('category')->filter();
        
        return view('items.index', compact('items', 'totalItems', 'categoryCount', 'averagePrice', 'totalValue', 'categories'));
    }

    public function create()
    {
        $categories = Item::distinct('category')->pluck('category')->filter();
        return view('items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:items',
            'description' => 'nullable|string',
            'unit_price' => 'required|numeric|min:0',
            'unit_weight' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'initial_quantity' => 'nullable|integer|min:0',
            'location' => 'nullable|string|max:100',
        ]);

        $item = Item::create([
            'name' => $validated['name'],
            'sku' => $validated['sku'],
            'description' => $validated['description'],
            'unit_price' => $validated['unit_price'],
            'unit_weight' => $validated['unit_weight'],
            'category' => $validated['category'],
        ]);

        Inventory::create([
            'item_id' => $item->id,
            'on_hand_quantity' => $validated['initial_quantity'] ?? 0,
            'off_hand_quantity' => 0,
            'location' => $validated['location'] ?? null,
        ]);

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function show(Item $item)
    {
        $item->load('inventory', 'transactions.user');
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $categories = Item::distinct('category')->pluck('category')->filter();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:items,sku,' . $item->id,
            'description' => 'nullable|string',
            'unit_price' => 'required|numeric|min:0',
            'unit_weight' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
        ]);

        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }

    public function export()
    {
        $items = Item::with('inventory')->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="items.csv"',
        ];
        
        $callback = function() use ($items) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'Name',
                'SKU',
                'Category',
                'Description',
                'Unit Price',
                'Unit Weight',
                'On Hand Quantity',
                'Off Hand Quantity',
                'Location',
                'Status'
            ]);
            
            // Add data rows
            foreach ($items as $item) {
                $status = 'Active';
                if (!isset($item->inventory) || $item->inventory->on_hand_quantity <= 0) {
                    $status = 'Out of Stock';
                } elseif ($item->inventory->on_hand_quantity <= $item->inventory->reorder_point) {
                    $status = 'Low Stock';
                }
                
                fputcsv($file, [
                    $item->name,
                    $item->sku,
                    $item->category,
                    $item->description,
                    $item->unit_price,
                    $item->unit_weight,
                    $item->inventory->on_hand_quantity ?? 0,
                    $item->inventory->off_hand_quantity ?? 0,
                    $item->inventory->location ?? '',
                    $status
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}