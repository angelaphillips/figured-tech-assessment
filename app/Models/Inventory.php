<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventory';

    protected $fillable = ['name', 'description'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Get the inventory movements for the inventory
     *
     * @return object
     */
    public function inventoryMovements() : object
    {
        return $this->hasMany(InventoryMovement::class,'inventory_id', 'id');

    }

    /**
     * Gets the id of an inventory by name
     *
     * @param string $name
     * @return int
     */
    public function getInventoryIdByName(string $name) : int
    {
        return $this->where('name', $name)->value('id');
    }
}
