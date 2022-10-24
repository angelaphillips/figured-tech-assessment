<?php

namespace Tests\Unit;

use App\Domain\Inventory\InventoryManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InventoryManagerTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test for the correct inventory count for an inventory
     *
     * @return void
     */
    public function test_current_inventory_available_count()
    {
        $inventory_manager = new InventoryManager(1);
        $inventory_count = $inventory_manager->getCurrentInventoryCount();

        $this->assertSame(43, $inventory_count);
    }

    /**
     * Test for the correct identification of earlier purchase with units available
     *
     * @return void
     */
    public function test_find_earliest_purchase_with_units_available()
    {
        $inventory_manager = new InventoryManager(1);
        $purchase = $inventory_manager->findEarliestPurchaseWithUnusedInventory();

        $this->assertSame(
            [
                'id' => 11,
                'quantity' => 13,
                'unit_price' => '4.20'
            ],
            $purchase);
    }
}
