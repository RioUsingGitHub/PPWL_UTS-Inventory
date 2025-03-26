<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-inventory', ['only' => ['index', 'show', 'export']]);
        $this->middleware('permission:edit-inventory', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-inventory', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $query = Inventory::with('item');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('item', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // Stock level filter
        if ($request->filled('stock')) {
            switch ($request->stock) {
                case 'low':
                    $query->where('on_hand_quantity', '<=', 10)
                          ->where('on_hand_quantity', '>', 0);
                    break;
                case 'out':
                    $query->where('on_hand_quantity', '<=', 0);
                    break;
                case 'normal':
                    $query->where('on_hand_quantity', '>', 10);
                    break;
            }
        }

        // Get statistics
        $totalItems = Inventory::count();
        $totalValue = Inventory::join('items', 'inventories.item_id', '=', 'items.id')
            ->selectRaw('SUM(inventories.on_hand_quantity * items.unit_price) as total_value')
            ->first()->total_value ?? 0;
        $lowStockCount = Inventory::where('on_hand_quantity', '<=', 10)
            ->where('on_hand_quantity', '>', 0)
            ->count();
        $locations = Inventory::distinct('location')->pluck('location')->filter();
        $locationCount = $locations->count();

        $inventory = $query->paginate(10);

        return view('inventory.index', compact(
            'inventory',
            'totalItems',
            'totalValue',
            'lowStockCount',
            'locationCount',
            'locations'
        ));
    }

    public function show(Inventory $inventory)
    {
        $inventory->load('item');
        return view('inventory.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        $inventory->load('item');
        return view('inventory.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'on_hand_quantity' => 'required|integer|min:0',
            'location' => 'nullable|string|max:100',
        ]);

        $oldQuantity = $inventory->on_hand_quantity;
        $newQuantity = $validated['on_hand_quantity'];
        $item = $inventory->item;

        $difference = $newQuantity - $oldQuantity;

        $inventory->update([
            'on_hand_quantity' => $newQuantity,
            'off_hand_quantity' => $inventory->off_hand_quantity + ($difference < 0 ? abs($difference) : 0),
            'location' => $validated['location'],
        ]);

        if ($oldQuantity != $newQuantity) {
            $type = $difference > 0 ? 'on_hand' : 'off_hand';
            
            Transaction::create([
                'item_id' => $item->id,
                'user_id' => Auth::id(),
                'type' => $type,
                'quantity' => abs($difference),
                'total_price' => abs($difference) * $item->unit_price,
                'total_weight' => abs($difference) * $item->unit_weight,
                'notes' => 'Manual inventory adjustment',
            ]);
        }

        return redirect()->route('inventory.index')->with('success', 'Inventory updated successfully.');
    }

    public function offhandForm(Item $item)
    {
        $inventory = $item->inventory;
        return view('inventory.offhand', compact('item', 'inventory'));
    }

    public function processOffhand(Request $request, Item $item)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->inventory->on_hand_quantity,
            'notes' => 'nullable|string',
        ]);

        $inventory = $item->inventory;
        $quantity = $validated['quantity'];

        $inventory->update([
            'on_hand_quantity' => $inventory->on_hand_quantity - $quantity,
            'off_hand_quantity' => $inventory->off_hand_quantity + $quantity,
        ]);

        Transaction::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'type' => 'off_hand',
            'quantity' => $quantity,
            'total_price' => $quantity * $item->unit_price,
            'total_weight' => $quantity * $item->unit_weight,
            'notes' => $validated['notes'] ?? 'Items moved to off-hand inventory',
        ]);

        return redirect()->route('inventory.index')->with('success', 'Items moved to off-hand successfully.');
    }

    public function export()
    {
        $inventory = Inventory::with('item')->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="inventory.csv"',
        ];
        
        $callback = function() use ($inventory) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Item Name',
                'SKU',
                'Category',
                'On Hand Quantity',
                'Off Hand Quantity',
                'Location',
                'Unit Price',
                'Total Value',
                'Status'
            ]);

            foreach ($inventory as $inv) {
                $status = 'Normal';
                if ($inv->on_hand_quantity <= 0) {
                    $status = 'Out of Stock';
                } elseif ($inv->on_hand_quantity <= 10) {
                    $status = 'Low Stock';
                }
                
                $totalValue = $inv->on_hand_quantity * $inv->item->unit_price;
                
                fputcsv($file, [
                    $inv->item->name,
                    $inv->item->sku,
                    $inv->item->category,
                    $inv->on_hand_quantity,
                    $inv->off_hand_quantity,
                    $inv->location,
                    $inv->item->unit_price,
                    $totalValue,
                    $status
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventory.index')->with('success', 'Inventory deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        try {
            $file = $request->file('csv_file');
            $path = $file->getRealPath();
            $data = array_map('str_getcsv', file($path));

            // Validate CSV structure
            if (count($data) < 2) {
                return back()->with('error', 'CSV file is empty or invalid format.');
            }

            $headers = array_map('strtolower', $data[0]);
            $requiredHeaders = ['item_id', 'quantity', 'location'];
            
            if (count(array_intersect($headers, $requiredHeaders)) !== count($requiredHeaders)) {
                return back()->with('error', 'Invalid CSV format. Please download the template.');
            }

            // Skip header row
            array_shift($data);

            DB::beginTransaction();
            
            $errors = [];
            $successCount = 0;

            foreach ($data as $index => $row) {
                try {
                    if (count($row) < 3) {
                        throw new \Exception('Invalid row format');
                    }

                    $itemId = trim($row[0]);
                    $quantity = trim($row[1]);
                    $location = trim($row[2]);

                    if (!is_numeric($itemId) || !is_numeric($quantity)) {
                        throw new \Exception('Invalid data types');
                    }

                    $item = Item::find($itemId);
                    if (!$item) {
                        throw new \Exception("Item ID {$itemId} not found");
                    }

                    // Create or update inventory
                    $inventory = Inventory::firstOrCreate(
                        ['item_id' => $itemId],
                        ['location' => $location]
                    );

                    // Create a transaction for the quantity change
                    if ($quantity != $inventory->on_hand_quantity) {
                        $difference = $quantity - $inventory->on_hand_quantity;
                        
                        Transaction::create([
                            'item_id' => $itemId,
                            'user_id' => auth()->id(),
                            'type' => $difference > 0 ? 'on_hand' : 'off_hand',
                            'quantity' => abs($difference),
                            'total_price' => abs($difference) * $item->unit_price,
                            'total_weight' => abs($difference) * $item->unit_weight,
                            'notes' => 'Bulk import adjustment',
                        ]);

                        // Update inventory quantity
                        $inventory->update([
                            'on_hand_quantity' => $quantity,
                            'location' => $location
                        ]);
                    }

                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            DB::commit();

            if (count($errors) > 0) {
                return back()
                    ->with('warning', 'Import completed with some errors: ' . implode(', ', $errors))
                    ->with('success', "Successfully imported {$successCount} items.");
            }

            return back()->with('success', "Successfully imported {$successCount} items.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="inventory_import_template.csv"',
        ];
        
        $callback = function() {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, [
                'item_id',
                'quantity',
                'location'
            ]);

            // Add example row
            fputcsv($file, [
                '1',
                '10',
                'Warehouse A'
            ]);
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}