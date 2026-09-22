<?php

namespace Tests\Unit;

use App\Services\MockImageAnalyzer;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ImageAnalyzerTest extends TestCase
{
    private MockImageAnalyzer $analyzer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->analyzer = new MockImageAnalyzer;
    }

    #[Test]
    public function it_accepts_valid_image_and_returns_mock_result(): void
    {
        $image = UploadedFile::fake()->image('plant.jpg', 800, 600);

        $result = $this->analyzer->analyze($image);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('condition_name', $result);
        $this->assertArrayHasKey('detected_symptoms', $result);
        $this->assertArrayHasKey('confidence', $result);
        $this->assertArrayHasKey('notes', $result);
        $this->assertArrayHasKey('is_definitive', $result);
    }

    #[Test]
    public function it_returns_clear_mock_result_with_expected_structure(): void
    {
        $image = UploadedFile::fake()->image('plant.png', 500, 500);

        $result = $this->analyzer->analyze($image);

        $this->assertNotEmpty($result['condition_name']);
        $this->assertIsArray($result['detected_symptoms']);
        $this->assertGreaterThan(0, count($result['detected_symptoms']));
        $this->assertGreaterThanOrEqual(0.0, $result['confidence']);
        $this->assertLessThanOrEqual(1.0, $result['confidence']);
        $this->assertFalse($result['is_definitive']);
    }

    #[Test]
    public function it_rejects_invalid_file_type(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $this->analyzer->analyze($file);
    }

    #[Test]
    public function it_rejects_oversized_image(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $file = UploadedFile::fake()->image('huge.jpg')->size(6000);

        $this->analyzer->analyze($file);
    }
}
