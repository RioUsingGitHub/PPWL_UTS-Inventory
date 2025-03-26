<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';
    
    protected $fillable = [
        'item_id',
        'on_hand_quantity',
        'off_hand_quantity',
        'location'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getTotalQuantityAttribute()
    {
        return $this->on_hand_quantity + $this->off_hand_quantity;
    }

    public function getCurrentValueAttribute()
    {
        return $this->total_quantity * $this->item->unit_price;
    }
}