<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Agent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agents = [
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'John Doe',
                'username' => 'johndoe',
                'email' => 'johndoe@example.com',
                'phone' => '123-456-7890',
                'password' => Hash::make('password123'),
                'status' => Status::ACTIVE->value,
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Jane Smith',
                'username' => 'janesmith',
                'email' => 'janesmith@example.com',
                'phone' => '098-765-4321',
                'password' => Hash::make('password123'),
                'status' => Status::INACTIVE->value,
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Robert Johnson',
                'username' => 'robertjohnson',
                'email' => 'robertjohnson@example.com',
                'phone' => '234-567-8901',
                'password' => Hash::make('password123'),
                'status' => Status::ACTIVE->value,
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Emily Davis',
                'username' => 'emilydavis',
                'email' => 'emilydavis@example.com',
                'phone' => '345-678-9012',
                'password' => Hash::make('password123'),
                'status' => Status::ACTIVE->value,
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Michael Brown',
                'username' => 'michaelbrown',
                'email' => 'michaelbrown@example.com',
                'phone' => '456-789-0123',
                'password' => Hash::make('password123'),
                'status' => Status::ACTIVE->value,
            ],
        ];

        // Insert the agents into the database
        foreach ($agents as $agent) {
            Agent::create($agent);
        }
    }
}
