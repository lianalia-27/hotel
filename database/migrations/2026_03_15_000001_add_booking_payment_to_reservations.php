<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {

            // ── Booking / Konfirmasi ─────────────────────────────────
            // Field untuk bagian atas surat konfirmasi reservasi
            $table->string('to_name')->nullable()->after('booking_number');
            $table->string('company_agent')->nullable()->after('to_name');
            $table->string('book_by')->nullable()->after('company_agent');
            $table->string('contact_phone')->nullable()->after('book_by');
            $table->string('contact_email')->nullable()->after('contact_phone');
            $table->string('hotel_telp')->nullable()->after('contact_email');
            $table->string('hotel_fax')->nullable()->after('hotel_telp');
            $table->string('hotel_email')->nullable()->after('hotel_fax');
            $table->date('booking_date')->nullable()->after('hotel_email');

            // ── Pembayaran / Payment ─────────────────────────────────
            // Rekening bank hotel
            $table->string('mandiri_account')->nullable()->after('booking_date');
            $table->string('mandiri_account_name')->nullable()->after('mandiri_account');

            // Kartu kredit jaminan
            $table->string('card_number')->nullable()->after('mandiri_account_name');
            $table->string('card_holder_name')->nullable()->after('card_number');
            $table->string('card_type')->nullable()->after('card_holder_name');
            $table->string('bank_transfer_to')->nullable()->after('card_type');
            $table->string('card_expired')->nullable()->after('bank_transfer_to'); // format: MM/YYYY

        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn([
                'to_name', 'company_agent', 'book_by',
                'contact_phone', 'contact_email',
                'hotel_telp', 'hotel_fax', 'hotel_email', 'booking_date',
                'mandiri_account', 'mandiri_account_name',
                'card_number', 'card_holder_name', 'card_type',
                'bank_transfer_to', 'card_expired',
            ]);
        });
    }
};
