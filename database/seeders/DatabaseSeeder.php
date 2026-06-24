<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create(['name' => 'Administrator', 'email' => 'admin@dhiyata.com', 'password' => Hash::make('password'), 'role' => 'admin']);
        User::factory()->create(['name' => 'Petugas Hotel', 'email' => 'petugas@dhiyata.com', 'password' => Hash::make('password'), 'role' => 'petugas']);
        User::factory()->create(['name' => 'Tamu Dhiyata', 'email' => 'user@dhiyata.com', 'password' => Hash::make('password'), 'role' => 'user']);

        $standard = RoomType::create(['name' => 'Standard', 'description' => 'Kamar nyaman untuk dua tamu.', 'base_price' => 350000, 'capacity' => 2, 'image' => 'standard.jpg']);
        $deluxe = RoomType::create(['name' => 'Deluxe', 'description' => 'Kamar luas dengan pemandangan kota.', 'base_price' => 550000, 'capacity' => 2, 'image' => 'deluxe.jpg']);
        $family = RoomType::create(['name' => 'Family', 'description' => 'Kamar keluarga hingga empat tamu.', 'base_price' => 850000, 'capacity' => 4, 'image' => 'family.jpg']);

        $wifi = Facility::create(['name' => 'Wi-Fi', 'description' => 'Internet nirkabel']);
        $ac = Facility::create(['name' => 'AC', 'description' => 'Pendingin ruangan']);
        $breakfast = Facility::create(['name' => 'Sarapan', 'description' => 'Sarapan untuk dua orang']);

        foreach ([101, 102, 103] as $n) {
            $r = Room::create(['room_type_id' => $standard->id, 'room_number' => (string)$n, 'floor' => 1, 'status' => 'available']);
            $r->facilities()->sync([$wifi->id, $ac->id]);
        }
        foreach ([201, 202] as $n) {
            $r = Room::create(['room_type_id' => $deluxe->id, 'room_number' => (string)$n, 'floor' => 2, 'status' => 'available']);
            $r->facilities()->sync([$wifi->id, $ac->id, $breakfast->id]);
        }
        $r = Room::create(['room_type_id' => $family->id, 'room_number' => '301', 'floor' => 3, 'status' => 'available']);
        $r->facilities()->sync([$wifi->id, $ac->id, $breakfast->id]);

        Guest::factory()->count(10)->create();
    }
}
