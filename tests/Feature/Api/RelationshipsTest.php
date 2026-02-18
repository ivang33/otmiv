<?php

namespace Tests\Feature\Api;

use App\Models\LaundryItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RelationshipsTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_has_many_laundry_items()
    {
        // Создаем пользователя и его вещи
        LaundryItem::factory()->count(3)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->get("/api/user/{$this->user->id}/laundry-items", $this->headers());

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    /** @test */
    public function laundry_item_belongs_to_user()
    {
        $item = LaundryItem::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->get("/api/laundry-items/{$item->id}", $this->headers());

        $response->assertStatus(200)
            ->assertJsonPath('user_id', $this->user->id);
    }
}
