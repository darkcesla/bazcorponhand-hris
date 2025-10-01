<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShiftGroup;

class ShiftGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShiftGroup::create([
            'group_code' => 'Group 01',
            'group_name' => 'Head Office',
            'overtime_based_on' => 'Request And Attendance',
            'total_days' => 7,
        ]);
    }
}
