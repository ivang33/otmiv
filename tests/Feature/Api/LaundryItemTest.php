<?php

namespace Tests\Feature\Api;

use App\Models\LaundryItem;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LaundryItemTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_laundry_item()
    {
        $category = Category::factory()->create();
        $status = Status::factory()->create();

        $itemData = [
            'name' => 'Футболка Nike',
            'description' => 'Черная футболка размер L',
            'price' => 25.50,
            'category_id' => $category->id,
            'status_id' => $status->id,
            'user_id' => $this->user->id
        ];

        $response = $this->post('/api/laundry-items', $itemData, $this->headers());

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Футболка Nike',
                'price' => 25.50
            ]);

        $this->assertDatabaseHas('laundry_items', [
            'name' => 'Футболка Nike',
            'user_id' => $this->user->id
        ]);
    }

    /** @test */
    public function can_get_all_laundry_items()
    {
        LaundryItem::factory()->count(5)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->get('/api/laundry-items', $this->headers());

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }

    /** @test */
    public function can_update_laundry_item()
    {
        $item = LaundryItem::factory()->create([
            'user_id' => $this->user->id
        ]);

        $updateData = [
            'name' => 'Обновленная футболка',
            'price' => 30.00
        ];

        $response = $this->put("/api/laundry-items/{$item->id}", $updateData, $this->headers());

        $response->assertStatus(200);

        $this->assertDatabaseHas('laundry_items', [
            'id' => $item->id,
            'name' => 'Обновленная футболка',
            'price' => 30.00
        ]);
    }

    /** @test */
    public function can_delete_laundry_item()
    {
        $item = LaundryItem::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->delete("/api/laundry-items/{$item->id}", [], $this->headers());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('laundry_items', [
            'id' => $item->id
        ]);
    }
}
