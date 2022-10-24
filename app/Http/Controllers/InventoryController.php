<?php

namespace App\Http\Controllers;

use App\Domain\Inventory\FifoInventoryValuation;
use App\Domain\Inventory\InventoryManager;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventory = Inventory::all();

        return response()
            ->view('inventory', ['inventory' => $inventory]);
    }

    /**
     * Check request inventory in $ value
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function requestInventory(Request $request)
    {
        $inventory_id = (int) $request->inventory_id;
        $units_requested = (int) $request->units_requested;

        if (!$units_requested)
        {
            return response()->json([
                'message' => 'Please provide a valid value for number of units requested.',
            ]);
        }

        // Check availability of the requested units
        $inventory_manager = new InventoryManager($inventory_id);
        $inventory_available = $inventory_manager->getCurrentInventoryCount();

        if ($inventory_available < $units_requested)
        {
            return response()->json([
                'message' => 'Requested inventory quantity exceeds available inventory.',
            ]);
		}

        // If the requested units are available, get a $ valuation of the requested units using the FIFO valuation method
        $inventory_valuation = (new FifoInventoryValuation($inventory_manager))->performValuation($units_requested);

        return response()->json([
            'message' =>  $units_requested . ' units of inventory valued at '. number_format($inventory_valuation,2) . ' will be applied.',
        ]);
	}
}
