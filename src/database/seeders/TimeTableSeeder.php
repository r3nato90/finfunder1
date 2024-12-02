<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\TimeTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timeTable = [
            [
                'name' => 'Hours',
                'time' => 1,
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Days',
                'time' => 24,
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Weeks',
                'time' => 168,
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Months',
                'time' => 720,
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Years',
                'time' => 8760,
                'status' => Status::ACTIVE,
            ],

        ];

        TimeTable::truncate();

        foreach ($timeTable as $value) {
            TimeTable::create($value);
        }
    }
}
