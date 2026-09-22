<?php

namespace Tests\Feature;

use App\Models\HistoryRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HistoryPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_history_page_is_displayed(): void
    {
        $response = $this->get('/history');

        $response->assertStatus(200);
        $response->assertSee('العمليات السابقة');
        $response->assertSee('لا توجد عمليات محفوظة');
    }

    public function test_the_history_page_displays_a_saved_record(): void
    {
        HistoryRecord::create([
            'operation_type' => 'image',
            'summary_ar' => 'الحالة المحتملة: تبقع الأوراق',
            'occurred_at' => now(),
        ]);

        $response = $this->get('/history');

        $response->assertStatus(200);
        $response->assertSee('الحالة المحتملة: تبقع الأوراق');
        $response->assertSee('تحليل صورة');
    }
}
