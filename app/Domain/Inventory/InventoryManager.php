<?php

namespace App\Domain\Inventory;

use App\Models\InventoryMovement;

class InventoryManager
{
    public int $inventory_id;

    /**
     * @param int $inventory_id
     */
    public function __construct(int $inventory_id)
    {
        $this->inventory_id = $inventory_id;
    }

    /**
     * Get currently available inventory count
     *
     * @return int
     */
    public function getCurrentInventoryCount() : int
    {
        $inventory_movement = (new InventoryMovement);
        $total_purchased = $inventory_movement->getTotalInventoryPurchased($this->inventory_id);
        $total_applied = $inventory_movement->getTotalInventoryApplied($this->inventory_id);

        return $total_purchased - $total_applied;
    }

    /**
     * Determine the first purchase with unused inventory
     *
     * @return array|null
     */
    public function findEarliestPurchaseWithUnusedInventory () : ?array
    {
        // Get all purchases for this inventory
        $inventory_movement = (new InventoryMovement);
        $purchases = $inventory_movement
            ->where('type','Purchase')
            ->where('inventory_id', $this->inventory_id)
            ->orderByDesc('date')
            ->get();

        if ($purchases->isEmpty()) {
            return NULL;
        }

        /*
        * Work out the earliest purchase that still have unused inventory
        * using the count of inventory available and work backwards
        */
        $counter = $this->getCurrentInventoryCount();

        foreach ($purchases as $purchase)
        {
            $counter = $counter - $purchase->quantity;
            if ($counter <= 0) {
                break;
            }
        }

        $unused_units_remaining = $purchase->quantity - abs($counter);

        return [
            'id' => $purchase->id,
            'quantity' => $unused_units_remaining,
            'unit_price' => $purchase->unit_price
        ];
    }
}
