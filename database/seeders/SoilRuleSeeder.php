<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\SoilRule;
use Illuminate\Database\Seeder;

class SoilRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            'البن اليمني' => [
                ['element' => 'N', 'unit' => 'ppm', 'low_max' => 20, 'suitable_min' => 20, 'suitable_max' => 40, 'high_min' => 40],
                ['element' => 'P', 'unit' => 'ppm', 'low_max' => 10, 'suitable_min' => 10, 'suitable_max' => 25, 'high_min' => 25],
                ['element' => 'K', 'unit' => 'ppm', 'low_max' => 100, 'suitable_min' => 100, 'suitable_max' => 250, 'high_min' => 250],
                ['element' => 'pH', 'unit' => '', 'low_max' => 5.5, 'suitable_min' => 5.5, 'suitable_max' => 6.5, 'high_min' => 6.5],
                ['element' => 'moisture', 'unit' => '%', 'low_max' => 30, 'suitable_min' => 30, 'suitable_max' => 70, 'high_min' => 70],
                ['element' => 'temperature', 'unit' => 'C', 'low_max' => 15, 'suitable_min' => 15, 'suitable_max' => 28, 'high_min' => 28],
            ],
            'الطماطم' => [
                ['element' => 'N', 'unit' => 'ppm', 'low_max' => 25, 'suitable_min' => 25, 'suitable_max' => 50, 'high_min' => 50],
                ['element' => 'P', 'unit' => 'ppm', 'low_max' => 15, 'suitable_min' => 15, 'suitable_max' => 30, 'high_min' => 30],
                ['element' => 'K', 'unit' => 'ppm', 'low_max' => 150, 'suitable_min' => 150, 'suitable_max' => 300, 'high_min' => 300],
                ['element' => 'pH', 'unit' => '', 'low_max' => 5.8, 'suitable_min' => 5.8, 'suitable_max' => 7.0, 'high_min' => 7.0],
                ['element' => 'moisture', 'unit' => '%', 'low_max' => 40, 'suitable_min' => 40, 'suitable_max' => 75, 'high_min' => 75],
                ['element' => 'temperature', 'unit' => 'C', 'low_max' => 18, 'suitable_min' => 18, 'suitable_max' => 27, 'high_min' => 27],
            ],
            'البطاطس' => [
                ['element' => 'N', 'unit' => 'ppm', 'low_max' => 20, 'suitable_min' => 20, 'suitable_max' => 45, 'high_min' => 45],
                ['element' => 'P', 'unit' => 'ppm', 'low_max' => 12, 'suitable_min' => 12, 'suitable_max' => 28, 'high_min' => 28],
                ['element' => 'K', 'unit' => 'ppm', 'low_max' => 120, 'suitable_min' => 120, 'suitable_max' => 280, 'high_min' => 280],
                ['element' => 'pH', 'unit' => '', 'low_max' => 5.0, 'suitable_min' => 5.0, 'suitable_max' => 6.0, 'high_min' => 6.0],
                ['element' => 'moisture', 'unit' => '%', 'low_max' => 50, 'suitable_min' => 50, 'suitable_max' => 80, 'high_min' => 80],
                ['element' => 'temperature', 'unit' => 'C', 'low_max' => 15, 'suitable_min' => 15, 'suitable_max' => 20, 'high_min' => 20],
            ],
            'القمح' => [
                ['element' => 'N', 'unit' => 'ppm', 'low_max' => 15, 'suitable_min' => 15, 'suitable_max' => 35, 'high_min' => 35],
                ['element' => 'P', 'unit' => 'ppm', 'low_max' => 8, 'suitable_min' => 8, 'suitable_max' => 20, 'high_min' => 20],
                ['element' => 'K', 'unit' => 'ppm', 'low_max' => 80, 'suitable_min' => 80, 'suitable_max' => 200, 'high_min' => 200],
                ['element' => 'pH', 'unit' => '', 'low_max' => 6.0, 'suitable_min' => 6.0, 'suitable_max' => 7.5, 'high_min' => 7.5],
                ['element' => 'moisture', 'unit' => '%', 'low_max' => 30, 'suitable_min' => 30, 'suitable_max' => 60, 'high_min' => 60],
                ['element' => 'temperature', 'unit' => 'C', 'low_max' => 10, 'suitable_min' => 10, 'suitable_max' => 25, 'high_min' => 25],
            ],
            'الذرة الشامية' => [
                ['element' => 'N', 'unit' => 'ppm', 'low_max' => 20, 'suitable_min' => 20, 'suitable_max' => 40, 'high_min' => 40],
                ['element' => 'P', 'unit' => 'ppm', 'low_max' => 10, 'suitable_min' => 10, 'suitable_max' => 25, 'high_min' => 25],
                ['element' => 'K', 'unit' => 'ppm', 'low_max' => 100, 'suitable_min' => 100, 'suitable_max' => 220, 'high_min' => 220],
                ['element' => 'pH', 'unit' => '', 'low_max' => 5.5, 'suitable_min' => 5.5, 'suitable_max' => 7.0, 'high_min' => 7.0],
                ['element' => 'moisture', 'unit' => '%', 'low_max' => 35, 'suitable_min' => 35, 'suitable_max' => 70, 'high_min' => 70],
                ['element' => 'temperature', 'unit' => 'C', 'low_max' => 18, 'suitable_min' => 18, 'suitable_max' => 30, 'high_min' => 30],
            ],
        ];

        foreach ($rules as $cropName => $elements) {
            $crop = Crop::where('name_ar', $cropName)->first();
            if (! $crop) {
                continue;
            }
            foreach ($elements as $rule) {
                SoilRule::create(array_merge(['crop_id' => $crop->id], $rule));
            }
        }
    }
}
