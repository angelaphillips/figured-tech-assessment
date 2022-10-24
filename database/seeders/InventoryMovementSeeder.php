<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Seeder;
use App\Models\InventoryMovement;

class InventoryMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InventoryMovement::truncate();

        $csvFile = fopen(base_path("database/data/fertiliser-inventory-movements.csv"), "r");

        $row = TRUE;
        while (($data = fgetcsv($csvFile, null, ",")) !== FALSE) {
            if (!$row && !$data == NULL) {
                InventoryMovement::create([
                    "inventory_id" => (new Inventory)->getInventoryIdByName('Fertiliser'),
                    "date" => date("Y-m-d", strtotime(str_replace('/', '-', $data['0']))),
                    "type" => trim($data['1']),
                    "quantity" => abs(trim($data['2'])),
                    "unit_price" => $data['3'] ? floatval(trim($data['3'])) : NULL,
                ]);
            }
            $row = FALSE;
        }

        fclose($csvFile);
    }
}
