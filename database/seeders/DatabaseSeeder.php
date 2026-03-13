<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RoomType;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@ppkdhotel.com',
            'password' => Hash::make('admin123'),
            'role' => 'administrator',
        ]);

        // Create Receptionist
        User::create([
            'name' => 'Resepsionis 1',
            'email' => 'resepsionis@ppkdhotel.com',
            'password' => Hash::make('resep123'),
            'role' => 'receptionist',
        ]);

        // Room Types
        $types = [
            [
                'name' => 'Standard',
                'code' => 'STD',
                'description' => 'Kamar standar yang nyaman dengan fasilitas dasar.',
                'price_per_night' => 350000,
                'max_capacity' => 2,
                'facilities' => json_encode(['AC', 'TV', 'WiFi', 'Kamar Mandi Dalam', 'Air Panas']),
            ],
            [
                'name' => 'Deluxe',
                'code' => 'DLX',
                'description' => 'Kamar deluxe dengan pemandangan kota dan fasilitas lengkap.',
                'price_per_night' => 550000,
                'max_capacity' => 2,
                'facilities' => json_encode(['AC', 'Smart TV', 'WiFi', 'Kamar Mandi Bathtub', 'Mini Bar', 'Safe Box']),
            ],
            [
                'name' => 'Suite',
                'code' => 'STE',
                'description' => 'Kamar suite luas dengan ruang tamu terpisah.',
                'price_per_night' => 950000,
                'max_capacity' => 3,
                'facilities' => json_encode(['AC', 'Smart TV', 'WiFi', 'Bathtub + Shower', 'Mini Bar', 'Safe Box', 'Ruang Tamu', 'Sofa Bed']),
            ],
            [
                'name' => 'Executive Suite',
                'code' => 'EXC',
                'description' => 'Suite eksklusif untuk tamu korporat dengan layanan premium.',
                'price_per_night' => 1500000,
                'max_capacity' => 4,
                'facilities' => json_encode(['AC', '4K Smart TV', 'WiFi Cepat', 'Jacuzzi', 'Mini Bar Premium', 'Safe Box', 'Ruang Meeting', 'Butler Service']),
            ],
            [
                'name' => 'Presidential Suite',
                'code' => 'PRE',
                'description' => 'Kamar paling mewah dengan fasilitas terbaik dan pelayanan VIP.',
                'price_per_night' => 3500000,
                'max_capacity' => 6,
                'facilities' => json_encode(['AC Sentral', '4K Smart TV x3', 'WiFi Premium', 'Private Pool', 'Bar Lengkap', 'Safe Box', 'Dapur', 'Ruang Meeting', 'Private Butler', 'Concierge 24 Jam']),
            ],
        ];

        foreach ($types as $type) {
            RoomType::create($type);
        }

        // Rooms - Floor 1-6, various types
        $roomData = [
            // Floor 1 - Standard
            ['0101', 1, 1], ['0102', 1, 1], ['0103', 1, 1], ['0104', 1, 1],
            // Floor 2 - Standard + Deluxe
            ['0201', 2, 1], ['0202', 2, 1], ['0203', 2, 2], ['0204', 2, 2],
            // Floor 3 - Deluxe
            ['0301', 3, 2], ['0302', 3, 2], ['0303', 3, 2], ['0304', 3, 2],
            // Floor 4 - Suite
            ['0401', 4, 3], ['0402', 4, 3], ['0403', 4, 3],
            // Floor 5 - Executive Suite
            ['0501', 5, 4], ['0502', 5, 4],
            // Floor 6 - Presidential
            ['0601', 6, 5], ['0602', 6, 5],
        ];

        foreach ($roomData as [$num, $floor, $typeId]) {
            Room::create([
                'room_number' => $num,
                'room_type_id' => $typeId,
                'floor' => $floor,
                'status' => 'available',
            ]);
        }
    }
}
