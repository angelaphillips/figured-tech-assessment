<?php

namespace App\Domain\Inventory;

interface InventoryValuation
{
    public function performValuation(int $units) : float;

}
