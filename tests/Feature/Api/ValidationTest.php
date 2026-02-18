<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidationTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_item_requires_name()
    {
        $response = $this->post('/api/laundry-items', [
            'price' => 100,
        ], $this->getHeaders());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function creating_item_requires_valid_price()
    {
        $response = $this->post('/api/laundry-items', [
            'name' => 'Test',
            'price' => -10,
        ], $this->getHeaders());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['price']);
    }

    /** @test */
    public function user_email_must_be_unique()
    {
        // Создаем пользователя
        User::factory()->create([
            'email' => 'duplicate@test.com'
        ]);

        // Пытаемся создать еще одного с таким же email
        $response = $this->post('/api/register', [
            'name' => 'Test',
            'email' => 'duplicate@test.com',
            'password' => 'password',
            'address' => 'Address',
            'role_id' => 2
        ], $this->getHeaders());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
