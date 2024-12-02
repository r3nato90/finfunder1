<?php

namespace Database\Seeders;

use App\Enums\Frontend\SectionKey;
use App\Models\Frontend;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FrontendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataFiles = collect(SectionKey::toArray())
            ->map(static fn ($value) => resource_path("data/{$value}.php"))
            ->filter(fn ($filePath) => file_exists($filePath))
            ->all();

        $dataToInsert = collect($dataFiles)
            ->flatMap(fn ($filePath) => include $filePath)
            ->filter(fn ($data) => is_array($data))
            ->toArray();

        Frontend::truncate();

        DB::table('frontends')->insert($dataToInsert);


    }
}
