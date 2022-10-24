<?php

namespace App\Domain\Inventory;

use App\Models\InventoryMovement;

class FifoInventoryValuation implements InventoryValuation
{
    public InventoryManager $inventory_manager;
    protected float $valuation = 0;

    /**
     * @param InventoryManager $inventory_manager
     */
    public function __construct(InventoryManager $inventory_manager)
    {
        $this->inventory_manager = $inventory_manager;
    }

    /**
     * Perform valuation
     *
     * @param int $units
     *
     * @return float $valuation
     */
    public function performValuation(int $units) : float
    {
        // Get first purchase with unused inventory remaining and how many units are left
        $earliest_purchase = $this->inventory_manager->findEarliestPurchaseWithUnusedInventory();

        // If there is no inventory, the value is 0
        if ( ! $earliest_purchase) {
            return $this->valuation;
        }

        // If there is enough units from the purchase, we can just apply the simple calculation
        if ($earliest_purchase['quantity'] >= $units) {
            $this->valuation = $units * $earliest_purchase['unit_price'];
            return $this->valuation;
        }

        // Otherwise, get data for newer purchases for further calculation
        $inventory = [$earliest_purchase];
        $inventory_movement = (new InventoryMovement);
        $purchases = $inventory_movement
            ->where('type','Purchase')
            ->where('inventory_id', $this->inventory_manager->inventory_id)
            ->where('id', '>', $earliest_purchase['id'])
            ->get();

        foreach ($purchases as $purchase) {
            $inventory[] = [
                'id' => $purchase['id'],
                'quantity' => $purchase['quantity'],
                'unit_price' => $purchase['unit_price']
            ];
        }

        $counter = $units;

        foreach ($inventory as $inv)
        {
            /*
            * If the units to be valued is less than the quantity available with current purchase
            * calculate the value and exit the loop
            */
            if ($counter <= $inv['quantity']) {
                $this->valuation = $this->valuation + ($counter * $inv['unit_price']);
                break;
            } else {
                // Otherwise continue to calculate value
                $this->valuation = $this->valuation + ($inv['quantity'] * $inv['unit_price']);
                // Decrease counter by number of units value from this purchase
                $counter = $counter - $inv['quantity'];
            }
        }
        return $this->valuation;
    }
}
