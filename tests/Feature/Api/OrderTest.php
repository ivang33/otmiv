<?php

namespace Tests\Feature\Api;

use App\Models\Order;
use App\Models\PickupPoint;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_order()
    {
        $status = Status::factory()->create();
        $pickupPoint = PickupPoint::factory()->create();

        $orderData = [
            'order_date' => now()->toDateString(),
            'total_price' => 150.00,
            'tracking_code' => 'TRK' . rand(1000, 9999),
            'status_id' => $status->id,
            'user_id' => $this->user->id,
            'pickup_point_id' => $pickupPoint->id
        ];

        $response = $this->post('/api/orders', $orderData, $this->headers());

        $response->assertStatus(201);
    }
}
