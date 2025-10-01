<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShiftDaily;

class ShiftDailySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShiftDaily::create([
            'shift_daily_code' => 'shift_pagi',
            'day_type' => 'weekday',
            'shift_daily_code_ph' => 'Off Day',
            'start_time' => '08:00',
            'end_time' => '16:00',
            'grace_for_late' => 10,
            'productive_work_time' => 480,
        ]);
        ShiftDaily::create([
            'shift_daily_code' => 'shift_malam',
            'day_type' => 'weekday',
            'shift_daily_code_ph' => 'Off Day',
            'start_time' => '18:00',
            'end_time' => '00:00',
            'grace_for_late' => 10,
            'productive_work_time' => 480,
        ]);
    }
}
