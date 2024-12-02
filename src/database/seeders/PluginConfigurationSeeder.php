<?php

namespace Database\Seeders;

use App\Enums\PluginCode;
use App\Models\PluginConfiguration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PluginConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plugins = [
            [
                'code' => PluginCode::TAWK->value,
                'name' => "Tawk.to Configuration",
                'short_key' => [
                    'api_key' => "demo"
                ],
                'status' => \App\Enums\Status::INACTIVE->value
            ],
            [
                'code' => PluginCode::GOOGLE_ANALYTICS->value,
                'name' => "Google Analytics",
                'short_key' => [
                    'api_key' => "demo"
                ],
                'status' => \App\Enums\Status::INACTIVE->value
            ],
            [
                'code' => PluginCode::HOORY->value,
                'name' => "Hoory Configuration",
                'short_key' => [
                    'api_key' => "demo"
                ],
                'status' => \App\Enums\Status::INACTIVE->value
            ],

        ];
        PluginConfiguration::truncate();
        collect($plugins)->each(fn($plugin) => PluginConfiguration::create($plugin));
    }
}
