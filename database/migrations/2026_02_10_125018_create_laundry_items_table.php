<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laundry_items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 70);
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('status_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laundry_items');
    }
};
