<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShiftGroupDetail;

class ShiftGroupDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShiftGroupDetail::create(
            [
                'day_order' => 1,
                'shift_group_id' => 1,
                'shift_daily_id' => 1,
            ]
        );
        ShiftGroupDetail::create(
            [
                'day_order' => 2,
                'shift_group_id' => 1,
                'shift_daily_id' => 2,
            ]
        );
    }
}
