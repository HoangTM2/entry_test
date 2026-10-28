<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table("bookings")->truncate();
        Schema::enableForeignKeyConstraints();

        $names = ["山田 太郎", "佐藤 花子", "鈴木 一郎", "Nguyen Van A", "Tran Thi B", "田中 美咲"];
        $hotelIds = Hotel::query()->orderBy("hotel_id")->limit(30)->pluck("hotel_id");

        foreach ($hotelIds as $index => $hotelId) {
            $checkin = now()->startOfDay()->addDays($index % 14)->setHour(14);

            Booking::create([
                "hotel_id" => $hotelId,
                "customer_name" => $names[$index % count($names)],
                "customer_contact" => sprintf("090-%04d-%04d", 1000 + $index, 2000 + $index),
                "chekin_time" => $checkin,
                "checkout_time" => $checkin->copy()->addDays(1 + $index % 3)->setHour(10),
            ]);
        }
    }
}
