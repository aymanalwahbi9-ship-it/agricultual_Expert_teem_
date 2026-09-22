<?php

namespace Database\Factories;

use App\Models\Condition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Condition>
 */
class ConditionFactory extends Factory
{
    protected $model = Condition::class;

    public function definition(): array
    {
        return [
            'name_ar' => fake()->unique()->word().' '.fake()->numberBetween(1, 10000),
            'name_en' => fake()->word(),
            'type' => fake()->randomElement(['disease', 'pest', 'nutrient_deficiency', 'soil_disorder']),
            'description' => fake()->paragraph(),
            'is_active' => true,
        ];
    }
}
