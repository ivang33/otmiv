<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 70);
            $table->string('avatar', 150)->nullable();
            $table->string('email', 30)->unique();
            $table->string('password');
            $table->string('address', 70);
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
