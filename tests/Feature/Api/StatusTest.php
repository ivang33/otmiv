<?php

namespace Tests\Feature\Api;

use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_statuses()
    {
        // Создаем тестовые статусы
        Status::factory()->count(3)->create();

        // Делаем запрос
        $response = $this->get('/api/statuses', $this->headers());

        // Проверяем ответ
        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    /** @test */
    public function status_has_required_fields()
    {
        $status = Status::factory()->create([
            'name' => 'Test Status'
        ]);

        $response = $this->get('/api/statuses', $this->headers());

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Test Status']);
    }
}
