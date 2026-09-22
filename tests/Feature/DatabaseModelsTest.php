<?php

namespace Tests\Feature;

use App\Models\Condition;
use App\Models\ConditionSymptom;
use App\Models\Crop;
use App\Models\CropCondition;
use App\Models\DiagnosisCase;
use App\Models\DiagnosisResult;
use App\Models\DiagnosisResultSource;
use App\Models\HistoryRecord;
use App\Models\ImageObservation;
use App\Models\KnowledgeEntry;
use App\Models\Recommendation;
use App\Models\SoilAssessment;
use App\Models\SoilReading;
use App\Models\SoilRule;
use App\Models\Symptom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseModelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_tables_exist(): void
    {
        $tables = [
            'crops',
            'conditions',
            'symptoms',
            'crop_conditions',
            'condition_symptoms',
            'knowledge_entries',
            'soil_rules',
            'recommendations',
            'diagnosis_cases',
            'image_observations',
            'soil_readings',
            'soil_assessments',
            'diagnosis_results',
            'diagnosis_result_sources',
            'history_records',
        ];

        foreach ($tables as $table) {
            $this->assertTrue(Schema::hasTable($table), "Table {$table} should exist");
        }
    }

    public function test_crops_table_structure(): void
    {
        $this->assertTrue(Schema::hasColumns('crops', ['id', 'name_ar', 'name_en', 'description', 'is_active', 'created_at', 'updated_at']));
        $this->assertTrue(Schema::hasIndex('crops', 'crops_name_ar_index'));
    }

    public function test_conditions_table_structure(): void
    {
        $this->assertTrue(Schema::hasColumns('conditions', ['id', 'name_ar', 'name_en', 'type', 'description', 'is_active']));
    }

    public function test_knowledge_entries_table_structure(): void
    {
        $this->assertTrue(Schema::hasColumns('knowledge_entries', [
            'id', 'crop_id', 'condition_id', 'content_type', 'title_ar', 'content_ar', 'keywords', 'source_name', 'source_reference', 'reviewed_at', 'is_active',
        ]));
    }

    public function test_soil_rules_table_structure(): void
    {
        $this->assertTrue(Schema::hasColumns('soil_rules', [
            'id', 'crop_id', 'element', 'unit', 'low_max', 'suitable_min', 'suitable_max', 'high_min',
        ]));
    }

    public function test_crop_model_can_be_created(): void
    {
        $crop = Crop::create([
            'name_ar' => 'محصول اختبار',
            'name_en' => 'Test Crop',
            'description' => 'وصف تجريبي',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('crops', ['name_ar' => 'محصول اختبار']);
        $this->assertTrue($crop->is_active);
    }

    public function test_condition_model_and_relationships(): void
    {
        $crop = Crop::factory()->create(['name_ar' => 'طماطم اختبار']);
        $condition = Condition::factory()->create(['name_ar' => 'مرض اختبار']);

        // ربط محصول بحالة
        $cropCondition = CropCondition::create([
            'crop_id' => $crop->id,
            'condition_id' => $condition->id,
            'relevance_note' => 'ملاحظة اختبار',
        ]);

        $this->assertTrue($crop->conditions()->exists());
        $this->assertTrue($condition->crops()->exists());
        $this->assertEquals($crop->id, $cropCondition->crop->id);
        $this->assertEquals($condition->id, $cropCondition->condition->id);
    }

    public function test_symptom_and_condition_symptom_relationship(): void
    {
        $condition = Condition::factory()->create();
        $symptom = Symptom::factory()->create();

        $pivot = ConditionSymptom::create([
            'condition_id' => $condition->id,
            'symptom_id' => $symptom->id,
            'weight' => 0.85,
        ]);

        $this->assertTrue($condition->symptoms()->exists());
        $this->assertTrue($symptom->conditions()->exists());
        $this->assertEquals(0.85, (float) $pivot->weight);
    }

    public function test_knowledge_entry_relationships(): void
    {
        $crop = Crop::factory()->create();
        $condition = Condition::factory()->create();

        $entry = KnowledgeEntry::create([
            'crop_id' => $crop->id,
            'condition_id' => $condition->id,
            'content_type' => 'symptom',
            'title_ar' => 'عنوان معرفة اختبار',
            'content_ar' => 'محتوى معرفي موثق',
            'keywords' => ['اختبار', 'معرفة'],
            'source_name' => 'مصدر اختبار',
            'is_active' => true,
        ]);

        $this->assertEquals($crop->id, $entry->crop->id);
        $this->assertEquals($condition->id, $entry->condition->id);
        $this->assertIsArray($entry->keywords);
    }

    public function test_soil_rules_and_assessments(): void
    {
        $crop = Crop::factory()->create();
        $rule = SoilRule::create([
            'crop_id' => $crop->id,
            'element' => 'N',
            'unit' => 'ppm',
            'low_max' => 20,
            'suitable_min' => 20,
            'suitable_max' => 40,
            'high_min' => 40,
        ]);

        $this->assertTrue($crop->soilRules()->exists());
        $this->assertEquals('N', $rule->element);

        $case = DiagnosisCase::create([
            'crop_id' => $crop->id,
            'operation_type' => 'soil',
            'status' => 'started',
            'started_at' => now(),
        ]);

        $reading = SoilReading::create([
            'diagnosis_case_id' => $case->id,
            'source' => 'simulation',
            'nitrogen' => 15,
            'phosphorus' => 10,
            'potassium' => 100,
            'ph' => 6.5,
            'moisture' => 50,
            'temperature' => 25,
            'connection_status' => 'not_applicable',
            'quality_status' => 'valid',
            'recorded_at' => now(),
        ]);

        $assessment = SoilAssessment::create([
            'soil_reading_id' => $reading->id,
            'element' => 'N',
            'value' => 15,
            'status' => 'low',
            'rule_id' => $rule->id,
        ]);

        $this->assertEquals('low', $assessment->status);
        $this->assertTrue($reading->soilAssessments()->exists());
    }

    public function test_recommendation_relationship(): void
    {
        $condition = Condition::factory()->create();
        $knowledge = KnowledgeEntry::factory()->create(['condition_id' => $condition->id]);

        $rec = Recommendation::create([
            'condition_id' => $condition->id,
            'knowledge_entry_id' => $knowledge->id,
            'title_ar' => 'توصية اختبار',
            'content_ar' => 'محتوى التوصية',
            'is_active' => true,
        ]);

        $this->assertEquals($condition->id, $rec->condition->id);
        $this->assertEquals($knowledge->id, $rec->knowledgeEntry->id);
    }

    public function test_diagnosis_flow(): void
    {
        $crop = Crop::factory()->create();
        $condition = Condition::factory()->create();

        $case = DiagnosisCase::create([
            'crop_id' => $crop->id,
            'operation_type' => 'combined',
            'status' => 'completed',
            'started_at' => now()->subHour(),
            'completed_at' => now(),
        ]);

        $imageObs = ImageObservation::create([
            'diagnosis_case_id' => $case->id,
            'source' => 'simulation',
            'condition_id' => $condition->id,
            'confidence' => 0.85,
            'quality_status' => 'valid',
        ]);

        $result = DiagnosisResult::create([
            'diagnosis_case_id' => $case->id,
            'condition_id' => $condition->id,
            'result_type' => 'combined',
            'confidence' => 0.82,
            'status' => 'preliminary',
            'explanation_ar' => 'تفسير تجريبي',
            'advisory_notice_ar' => 'تنبيه تجريبي',
        ]);

        $knowledge = KnowledgeEntry::factory()->create();
        $source = DiagnosisResultSource::create([
            'diagnosis_result_id' => $result->id,
            'knowledge_entry_id' => $knowledge->id,
            'match_score' => 0.90,
        ]);

        $history = HistoryRecord::create([
            'diagnosis_case_id' => $case->id,
            'operation_type' => 'combined',
            'summary_ar' => 'ملخص تجريبي',
            'occurred_at' => now(),
        ]);

        $this->assertTrue($case->imageObservations()->exists());
        $this->assertTrue($case->diagnosisResults()->exists());
        $this->assertTrue($result->sources()->exists());
        $this->assertTrue($case->historyRecords()->exists());
        $this->assertEquals(0.85, (float) $imageObs->confidence);
    }

    public function test_seeders_run_successfully(): void
    {
        $this->seed();

        $this->assertGreaterThan(0, Crop::count());
        $this->assertGreaterThan(0, Condition::count());
        $this->assertGreaterThan(0, Symptom::count());
        $this->assertGreaterThan(0, KnowledgeEntry::count());
        $this->assertGreaterThan(0, SoilRule::count());
        $this->assertGreaterThan(0, Recommendation::count());
    }

    public function test_active_scopes(): void
    {
        Crop::factory()->create(['is_active' => true]);
        Crop::factory()->create(['is_active' => false]);

        $this->assertEquals(1, Crop::active()->count());
    }

    public function test_soft_deletes_on_history(): void
    {
        $history = HistoryRecord::factory()->create();
        $history->delete();

        $this->assertSoftDeleted($history);
        $this->assertTrue(HistoryRecord::withTrashed()->where('id', $history->id)->exists());
    }

    public function test_json_casts(): void
    {
        $entry = KnowledgeEntry::factory()->create([
            'keywords' => ['test', 'زراعي'],
        ]);

        $this->assertIsArray($entry->keywords);
        $this->assertContains('زراعي', $entry->keywords);
    }
}
