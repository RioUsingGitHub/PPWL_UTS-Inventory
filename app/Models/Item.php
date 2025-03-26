<?php
// app/Models/Item.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'sku', 
        'description', 
        'unit_price', 
        'unit_weight', 
        'category'
    ];

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}