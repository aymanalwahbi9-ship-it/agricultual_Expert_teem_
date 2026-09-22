<?php

namespace Database\Factories;

use App\Models\Crop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Crop>
 */
class CropFactory extends Factory
{
    protected $model = Crop::class;

    public function definition(): array
    {
        return [
            'name_ar' => fake()->unique()->randomElement(['البن اليمني', 'الطماطم', 'البطاطس', 'القمح', 'الذرة']).' '.fake()->numberBetween(1, 1000),
            'name_en' => fake()->word(),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
