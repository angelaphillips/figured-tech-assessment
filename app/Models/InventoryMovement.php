<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventory_movement';

    protected $fillable = ['inventory_id, date, type, quantity, unit_price'];

    /**
     * Get the inventory that the inventory movement is related to
     *
     * @return object
     */
    public function inventory() : object
    {
       return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }

    /**
     * Gets the sum of total inventory purchased
     *
     * @return int
     */
    public function getTotalInventoryPurchased(int $inventory_id) : int
    {
        return $this->where('type', 'Purchase')->where('inventory_id', $inventory_id)->sum('quantity');
    }

    /**
     * Gets the sum of total inventory applied
     *
     * @return int
     */
    public function getTotalInventoryApplied(int $inventory_id) : int
    {
        return $this->where('type', 'Application')->where('inventory_id', $inventory_id)->sum('quantity');
    }

}
