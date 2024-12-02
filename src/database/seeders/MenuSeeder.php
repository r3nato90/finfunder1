<?php

namespace Database\Seeders;

use App\Enums\Frontend\SectionKey;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $menuItems = [
            [
                'name' => 'Home',
                'url' => route('home'),
                'is_default' => true,
                'section_key' => null,
            ],
            [
                'name' => 'Trade',
                'url' => route('trade'),
                'is_default' => true,
                'section_key' => null,
            ],
            [
                'name' => 'Pricing',
                'url' => slug('plans'),
                'is_default' => false,
                'section_key' => [
                    SectionKey::PRICING_PLAN->value,
                    SectionKey::MATRIX_PLAN,
                    SectionKey::SERVICE->value,
                    SectionKey::FEATURE->value,
                    SectionKey::FAQ->value,
                ],
            ],
            [
                'name' => 'Features',
                'url' => slug('features'),
                'is_default' => false,
                'section_key' =>  [
                    SectionKey::ABOUT->value,
                    SectionKey::PROCESS->value,
                    SectionKey::SERVICE->value,
                    SectionKey::CHOOSE_US->value,
                    SectionKey::TESTIMONIAL->value,
                ],
            ],
        ];

        Menu::truncate();

        foreach ($menuItems as $menuItem) {
            Menu::create($menuItem);
        }
    }
}
