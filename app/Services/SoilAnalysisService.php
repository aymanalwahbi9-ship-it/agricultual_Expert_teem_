<?php

namespace App\Services;

use App\Data\SoilReadingData;

final class SoilAnalysisService
{
    /**
     * @return array<string, array{value: float, status: string}>
     */
    public function analyze(SoilReadingData $reading): array
    {
        return [
            'nitrogen' => [
                'value' => $reading->nitrogen,
                'status' => $this->classify(
                    $reading->nitrogen,
                    lowMax: 20.0,
                    suitableMin: 20.0,
                    suitableMax: 80.0
                ),
            ],
            'phosphorus' => [
                'value' => $reading->phosphorus,
                'status' => $this->classify(
                    $reading->phosphorus,
                    lowMax: 10.0,
                    suitableMin: 10.0,
                    suitableMax: 50.0
                ),
            ],
            'potassium' => [
                'value' => $reading->potassium,
                'status' => $this->classify(
                    $reading->potassium,
                    lowMax: 20.0,
                    suitableMin: 20.0,
                    suitableMax: 80.0
                ),
            ],
            'ph' => [
                'value' => $reading->ph,
                'status' => $this->classify(
                    $reading->ph,
                    lowMax: 5.5,
                    suitableMin: 5.5,
                    suitableMax: 7.5
                ),
            ],
            'moisture' => [
                'value' => $reading->moisture,
                'status' => $this->classify(
                    $reading->moisture,
                    lowMax: 30.0,
                    suitableMin: 30.0,
                    suitableMax: 70.0
                ),
            ],
            'temperature' => [
                'value' => $reading->temperature,
                'status' => $this->classify(
                    $reading->temperature,
                    lowMax: 15.0,
                    suitableMin: 15.0,
                    suitableMax: 35.0
                ),
            ],
        ];
    }

    private function classify(
        float $value,
        float $lowMax,
        float $suitableMin,
        float $suitableMax
    ): string {
        if ($value < $suitableMin) {
            return 'low';
        }

        if ($value > $suitableMax) {
            return 'high';
        }

        return 'normal';
    }
}
