<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTestCase extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $headers;

    protected function setUp(): void
    {
        parent::setUp();

        // Создаем роли
        $this->seedRoles();

        // Создаем тестового пользователя
        $this->user = User::factory()->create();

        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }

    protected function seedRoles(): void
    {
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'User']);
        Role::firstOrCreate(['name' => 'Manager']);
    }

    protected function getHeaders(): array
    {
        return $this->headers;
    }
}
