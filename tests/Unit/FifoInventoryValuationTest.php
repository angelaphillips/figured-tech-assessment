<?php

namespace Tests\Unit;

use App\Domain\Inventory\FifoInventoryValuation;
use App\Domain\Inventory\InventoryManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FifoInventoryValuationTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test for valuation if first purchase has sufficient units for user request
     *
     * @return void
     */
    public function test_fifo_inventory_valuation_1()
    {
        $inventory_manager = new InventoryManager(1);
        $valuation = (new FifoInventoryValuation($inventory_manager))->performValuation(10);

        $this->assertIsFloat($valuation);
        $this->assertSame(42.00, $valuation);
    }

    /**
     * Test for valuation of inventory for inventory taken from multiple purchases
     *
     * @return void
     */
    public function test_fifo_inventory_valuation_2()
    {
        $inventory_manager = new InventoryManager(1);
        $valuation = (new FifoInventoryValuation($inventory_manager))->performValuation(20);

        $this->assertIsFloat($valuation);
        $this->assertSame(89.60, $valuation);
    }

    /**
     * Test for valuation if user has requested all remaining units
     *
     * @return void
     */
    public function test_fifo_inventory_valuation_3()
    {
        $inventory_manager = new InventoryManager(1);
        $valuation = (new FifoInventoryValuation($inventory_manager))->performValuation(43);

        $this->assertIsFloat($valuation);
        $this->assertSame(211.60, $valuation);
    }
}


