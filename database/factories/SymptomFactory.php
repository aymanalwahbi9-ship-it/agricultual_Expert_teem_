<?php

namespace Database\Factories;

use App\Models\Symptom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Symptom>
 */
class SymptomFactory extends Factory
{
    protected $model = Symptom::class;

    public function definition(): array
    {
        return [
            'name_ar' => fake()->sentence(3),
            'description' => fake()->sentence(),
        ];
    }
}
