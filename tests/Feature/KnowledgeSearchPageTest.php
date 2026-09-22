<?php

namespace Tests\Feature;

use App\Models\KnowledgeEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KnowledgeSearchPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_knowledge_search_page_is_displayed(): void
    {
        $response = $this->get('/knowledge');

        $response->assertStatus(200);
        $response->assertSee('ابحث عن حالة أو عرض زراعي');
        $response->assertSee('ابدأ البحث');
    }

    public function test_it_displays_a_matching_knowledge_entry(): void
    {
        KnowledgeEntry::create([
            'content_type' => 'recommendation',
            'title_ar' => 'اصفرار أوراق الطماطم',
            'content_ar' => 'افحص النيتروجين ونظم الري.',
            'keywords' => ['اصفرار', 'نيتروجين'],
            'source_name' => 'قاعدة المعرفة المحلية',
            'reviewed_at' => now()->toDateString(),
            'is_active' => true,
        ]);

        $response = $this->get('/knowledge?term=اصفرار');

        $response->assertStatus(200);
        $response->assertSee('اصفرار أوراق الطماطم');
        $response->assertSee('افحص النيتروجين ونظم الري.');
    }
}
