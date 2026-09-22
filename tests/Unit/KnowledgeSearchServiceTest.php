<?php

namespace Tests\Unit;

use App\Services\KnowledgeSearchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class KnowledgeSearchServiceTest extends TestCase
{
    use RefreshDatabase;

    private KnowledgeSearchService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new KnowledgeSearchService;

        // إنشاء محصول
        $cropId = DB::table('crops')->insertGetId([
            'name_ar' => 'الطماطم',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // إنشاء حالة
        $conditionId = DB::table('conditions')->insertGetId([
            'name_ar' => 'نقص النيتروجين',
            'type' => 'nutrient_deficiency',
            'description' => 'نقص في عنصر النيتروجين',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // سجل نشط (يجب أن يظهر في البحث)
        DB::table('knowledge_entries')->insert([
            'crop_id' => $cropId,
            'condition_id' => $conditionId,
            'content_type' => 'recommendation',
            'title_ar' => 'علاج نقص النيتروجين في الطماطم',
            'content_ar' => 'يُنصح بإضافة سماد نيتروجيني بتركيز مناسب.',
            'keywords' => json_encode(['نيتروجين', 'اصفرار', 'سماد']),
            'source_name' => 'دليل الزراعة',
            'is_active' => true,
            'reviewed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // سجل غير نشط (يجب ألا يظهر أبدًا)
        DB::table('knowledge_entries')->insert([
            'crop_id' => $cropId,
            'condition_id' => $conditionId,
            'content_type' => 'recommendation',
            'title_ar' => 'معلومة قديمة ملغاة',
            'content_ar' => 'هذه معلومة غير نشطة.',
            'keywords' => json_encode(['قديم', 'ملغاة']),
            'source_name' => 'مصدر قديم',
            'is_active' => false,
            'reviewed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    #[Test]
    public function it_finds_active_entry_by_keyword(): void
    {
        $results = $this->service->search(['keyword' => 'نيتروجين']);

        $this->assertGreaterThan(0, $results->count());
        $this->assertStringContainsString('النيتروجين', $results->first()->title_ar);
    }

    #[Test]
    public function it_finds_entry_by_crop_name(): void
    {
        $results = $this->service->search(['crop' => 'الطماطم']);

        $this->assertGreaterThan(0, $results->count());
    }

    #[Test]
    public function it_finds_entry_by_condition_name(): void
    {
        $results = $this->service->search(['condition' => 'نقص النيتروجين']);

        $this->assertGreaterThan(0, $results->count());
    }

    #[Test]
    public function it_returns_empty_when_no_match(): void
    {
        $results = $this->service->search(['keyword' => 'كلمة_غير_موجودة_xyz_123']);

        $this->assertEquals(0, $results->count());
    }

    #[Test]
    public function it_does_not_show_inactive_entries(): void
    {
        $results = $this->service->search(['keyword' => 'قديم']);

        $this->assertEquals(0, $results->count(), 'يجب ألا تظهر السجلات غير النشطة.');
    }

    #[Test]
    public function it_never_returns_inactive_entries_even_with_broad_search(): void
    {
        $results = $this->service->search([]);

        $this->assertGreaterThan(0, $results->count());
        $this->assertLessThanOrEqual(1, $results->count(), 'يجب أن يظهر سجل نشط واحد فقط.');
    }
}
