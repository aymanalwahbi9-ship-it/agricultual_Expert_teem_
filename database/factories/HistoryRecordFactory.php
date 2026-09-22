<?php

namespace Database\Factories;

use App\Models\DiagnosisCase;
use App\Models\HistoryRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HistoryRecord>
 */
class HistoryRecordFactory extends Factory
{
    protected $model = HistoryRecord::class;

    public function definition(): array
    {
        return [
            'diagnosis_case_id' => DiagnosisCase::factory(),
            'operation_type' => fake()->randomElement(['image', 'soil', 'combined', 'search', 'report']),
            'summary_ar' => fake()->sentence(),
            'occurred_at' => now(),
        ];
    }
}
