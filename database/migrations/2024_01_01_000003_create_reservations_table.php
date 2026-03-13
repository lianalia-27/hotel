<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('profession')->nullable();
            $table->string('company')->nullable();
            $table->string('nationality')->default('Indonesia');
            $table->string('id_card_number')->nullable(); // KTP
            $table->string('passport_number')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('member_number')->nullable();
            $table->timestamps();
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('guest_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // receptionist
            $table->integer('num_persons')->default(1);
            $table->date('arrival_date');
            $table->time('arrival_time')->nullable();
            $table->date('departure_date');
            $table->integer('total_nights')->storedAs('DATEDIFF(departure_date, arrival_date)');
            $table->decimal('room_rate', 12, 2);
            $table->decimal('total_amount', 12, 2)->nullable();
            $table->enum('status', ['reserved', 'checked_in', 'checked_out', 'cancelled'])->default('reserved');
            $table->string('safety_deposit_box')->nullable();
            $table->string('issued_by')->nullable();
            $table->date('issued_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('guests');
    }
};
