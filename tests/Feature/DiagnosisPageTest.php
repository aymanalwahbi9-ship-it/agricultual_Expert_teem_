<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
