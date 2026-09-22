<?php

namespace Database\Factories;

use App\Models\Crop;
use App\Models\SoilRule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SoilRule>
 */
class SoilRuleFactory extends Factory
{
    protected $model = SoilRule::class;

    public function definition(): array
    {
        return [
            'crop_id' => Crop::factory(),
            'element' => fake()->randomElement(['N', 'P', 'K', 'pH', 'moisture', 'temperature']),
            'unit' => fake()->randomElement(['ppm', '%', 'C', '']),
            'low_max' => 20,
            'suitable_min' => 20,
            'suitable_max' => 40,
            'high_min' => 40,
        ];
    }
}
