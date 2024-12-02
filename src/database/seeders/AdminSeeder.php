<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    private array $adminData;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->adminData = [
            'name'     => 'Super Admin',
            'username' => 'admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('admin')
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->seedAdmin();
    }

    /**
     * Seed the Admin model.
     *
     * @return void
     */
    private function seedAdmin(): void
    {
        Admin::truncate();
        Admin::create($this->adminData);
    }

}
