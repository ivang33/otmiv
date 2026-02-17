<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        Status::create(['name' => 'Pending']);
        Status::create(['name' => 'In Progress']);
        Status::create(['name' => 'Completed']);
        Status::create(['name' => 'Cancelled']);
        Status::create(['name' => 'Ready for Pickup']);
        Status::create(['name' => 'Delivered']);
    }
}
