<?php

namespace Tests\Feature;

use App\Models\Crop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DiagnosisPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_diagnosis_page_is_displayed(): void
    {
        $response = $this->get('/diagnosis');

        $response->assertStatus(200);
        $response->assertSee('افهم حالة محصولك');
        $response->assertSee('أدخل معلومات المحصول');
    }

    public function test_a_valid_image_diagnosis_can_be_submitted(): void
    {
        $crop = Crop::factory()->create([
            'name_ar' => 'الطماطم',
            'is_active' => true,
        ]);

        $response = $this->post('/diagnosis', [
            'crop_id' => $crop->id,
            'operation_type' => 'image',
            'image' => UploadedFile::fake()->create('plant.png', 100, 'image/png'),
        ]);

        $response->assertStatus(200);
        $response->assertSee('نتيجة التشخيص الزراعي');
        $response->assertSee('الطماطم');
    }
}
