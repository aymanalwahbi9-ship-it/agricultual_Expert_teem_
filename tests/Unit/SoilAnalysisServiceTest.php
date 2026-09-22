<?php

namespace Tests\Unit;

use App\Data\SoilReadingData;
use App\Services\SoilAnalysisService;
use InvalidArgumentException;
use Tests\TestCase;

class SoilAnalysisServiceTest extends TestCase
{
    public function test_it_classifies_normal_soil_values(): void
    {
        $service = new SoilAnalysisService();

        $reading = new SoilReadingData(
            nitrogen: 50.0,
            phosphorus: 30.0,
            potassium: 50.0,
            ph: 6.5,
            moisture: 50.0,
            temperature: 25.0,
        );

        $result = $service->analyze($reading);

        $this->assertSame('normal', $result['nitrogen']['status']);
        $this->assertSame('normal', $result['phosphorus']['status']);
        $this->assertSame('normal', $result['potassium']['status']);
        $this->assertSame('normal', $result['ph']['status']);
        $this->assertSame('normal', $result['moisture']['status']);
        $this->assertSame('normal', $result['temperature']['status']);
    }

    public function test_it_classifies_low_and_high_values(): void
    {
        $service = new SoilAnalysisService();

        $reading = new SoilReadingData(
            nitrogen: 10.0,
            phosphorus: 60.0,
            potassium: 90.0,
            ph: 8.0,
            moisture: 20.0,
            temperature: 40.0,
        );

        $result = $service->analyze($reading);

        $this->assertSame('low', $result['nitrogen']['status']);
        $this->assertSame('high', $result['phosphorus']['status']);
        $this->assertSame('high', $result['potassium']['status']);
        $this->assertSame('high', $result['ph']['status']);
        $this->assertSame('low', $result['moisture']['status']);
        $this->assertSame('high', $result['temperature']['status']);
    }

    public function test_it_rejects_invalid_ph(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new SoilReadingData(
            nitrogen: 50.0,
            phosphorus: 30.0,
            potassium: 50.0,
            ph: 15.0,
            moisture: 50.0,
            temperature: 25.0,
        );
    }
}
