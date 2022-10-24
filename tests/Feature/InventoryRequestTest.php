<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryRequestTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test that the request inventory page loads ok
     *
     * @return void
    //     */
    public function test_request_inventory_response_success()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('Inventory Management');
    }

    /**
     * Test if the requested units exceeds inventory available should return error message
     *
     * @return void
//     */
    public function test_request_inventory_quantity_exceeds_units_available()
    {
        $response = $this->post('/request_inventory',
            [
                'inventory_id' => 1,
                'units_requested' => 100
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Requested inventory quantity exceeds available inventory.',
            ]);
    }

    /**
     * Test that a valuation will be returned if the inputted amount is valid
     *
     * @return void
    //     */
    public function test_request_inventory_requested_units_available()
    {
        $response = $this->post('/request_inventory',
            [
                'inventory_id' => 1,
                'units_requested' => 20
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => '20 units of inventory valued at 89.60 will be applied.',
            ]);
    }
}
