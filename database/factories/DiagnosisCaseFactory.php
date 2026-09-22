<?php

namespace Database\Factories;

use App\Models\Crop;
use App\Models\DiagnosisCase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DiagnosisCase>
 */
class DiagnosisCaseFactory extends Factory
{
    protected $model = DiagnosisCase::class;

    public function definition(): array
    {
        return [
            'crop_id' => Crop::factory(),
            'operation_type' => fake()->randomElement(['image', 'soil', 'combined', 'search']),
            'status' => fake()->randomElement(['started', 'completed', 'inconclusive', 'failed']),
            'started_at' => now()->subHour(),
            'completed_at' => now(),
        ];
    }
}
