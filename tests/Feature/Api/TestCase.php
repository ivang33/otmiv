<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class ApiTestCase extends TestCase
{
    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Создаем тестового пользователя
        $role = Role::firstOrCreate(['name' => 'User']);

        $this->user = User::factory()->create([
            'role_id' => $role->id
        ]);
    }

    protected function headers()
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }
}
