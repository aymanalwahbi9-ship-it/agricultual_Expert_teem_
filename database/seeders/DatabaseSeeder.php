<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CropSeeder::class,
            ConditionSeeder::class,
            SymptomSeeder::class,
            CropConditionSeeder::class,
            ConditionSymptomSeeder::class,
            KnowledgeEntrySeeder::class,
            SoilRuleSeeder::class,
            RecommendationSeeder::class,
            DiagnosisDemoSeeder::class,
        ]);
    }
}
