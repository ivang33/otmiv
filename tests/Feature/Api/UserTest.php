<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_register_new_user()
    {
        $userData = [
            'name' => 'Тестовый User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'address' => 'Москва, ул. Тестовая 1',
            'role_id' => 2
        ];

        $response = $this->post('/api/register', $userData, $this->headers());

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'User created successfully'
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Тестовый User'
        ]);
    }

    /** @test */
    public function can_get_all_users()
    {
        User::factory()->count(3)->create();

        $response = $this->get('/api/users', $this->headers());

        $response->assertStatus(200)
            ->assertJsonCount(4); // +1 админ из setUp
    }

    /** @test */
    public function can_get_single_user()
    {
        $user = User::factory()->create();

        $response = $this->get("/api/users/{$user->id}", $this->headers());

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name
                ]
            ]);
    }

    /** @test */
    public function can_update_user()
    {
        $user = User::factory()->create();

        $updateData = [
            'name' => 'Обновленное имя',
            'address' => 'Новый адрес'
        ];

        $response = $this->put("/api/users/{$user->id}", $updateData, $this->headers());

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User updated successfully'
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Обновленное имя'
        ]);
    }
}
