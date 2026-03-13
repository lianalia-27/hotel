<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Standard, Deluxe, Suite, Executive Suite, Presidential Suite
            $table->string('code'); // STD, DLX, STE, EXC, PRE
            $table->text('description')->nullable();
            $table->decimal('price_per_night', 12, 2);
            $table->integer('max_capacity')->default(2);
            $table->json('facilities')->nullable(); // ["AC", "TV", "WiFi", ...]
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number')->unique();
            $table->foreignId('room_type_id')->constrained()->onDelete('cascade');
            $table->integer('floor');
            $table->enum('status', ['available', 'occupied', 'cleaning', 'maintenance'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('room_types');
    }
};
