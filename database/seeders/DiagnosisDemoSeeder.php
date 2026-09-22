<?php

namespace Database\Seeders;

use App\Models\Condition;
use App\Models\Crop;
use App\Models\DiagnosisCase;
use App\Models\DiagnosisResult;
use App\Models\DiagnosisResultSource;
use App\Models\HistoryRecord;
use App\Models\ImageObservation;
use App\Models\KnowledgeEntry;
use App\Models\SoilAssessment;
use App\Models\SoilReading;
use App\Models\SoilRule;
use Illuminate\Database\Seeder;

class DiagnosisDemoSeeder extends Seeder
{
    public function run(): void
    {
        $crop = Crop::where('name_ar', 'الطماطم')->first();
        if (! $crop) {
            return;
        }

        $case = DiagnosisCase::create([
            'crop_id' => $crop->id,
            'operation_type' => 'combined',
            'status' => 'completed',
            'started_at' => now()->subHours(2),
            'completed_at' => now()->subHour(),
        ]);

        $imageObs = ImageObservation::create([
            'diagnosis_case_id' => $case->id,
            'file_path' => null,
            'source' => 'simulation',
            'condition_id' => Condition::where('name_ar', 'اللفحة المتأخرة')->first()?->id,
            'confidence' => 0.8750,
            'visible_features' => ['بقع بنية', 'ذبول'],
            'quality_status' => 'valid',
        ]);

        $soilReading = SoilReading::create([
            'diagnosis_case_id' => $case->id,
            'source' => 'simulation',
            'nitrogen' => 18.5,
            'phosphorus' => 12.0,
            'potassium' => 140.0,
            'ph' => 6.20,
            'moisture' => 55.0,
            'temperature' => 24.5,
            'units' => ['nitrogen' => 'ppm', 'ph' => '', 'moisture' => '%'],
            'connection_status' => 'not_applicable',
            'quality_status' => 'valid',
            'recorded_at' => now()->subHours(2),
        ]);

        // تصنيف عناصر التربة
        $elements = [
            'N' => 18.5,
            'P' => 12.0,
            'K' => 140.0,
            'pH' => 6.20,
        ];

        foreach ($elements as $elem => $value) {
            $rule = SoilRule::where('crop_id', $crop->id)->where('element', $elem)->first();
            $status = 'suitable';
            if ($rule) {
                if ($value <= $rule->low_max) {
                    $status = $value < $rule->suitable_min ? 'low' : 'suitable';
                    if ($value < $rule->low_max && $value < $rule->suitable_min) {
                        $status = 'low';
                    }
                }
                if ($value >= $rule->high_min) {
                    $status = 'high';
                }
                // تبسيط المنطق
                if ($value < $rule->suitable_min) {
                    $status = 'low';
                } elseif ($value > $rule->suitable_max) {
                    $status = 'high';
                } else {
                    $status = 'suitable';
                }
            }

            SoilAssessment::create([
                'soil_reading_id' => $soilReading->id,
                'element' => $elem,
                'value' => $value,
                'status' => $status,
                'rule_id' => $rule?->id,
            ]);
        }

        $result = DiagnosisResult::create([
            'diagnosis_case_id' => $case->id,
            'condition_id' => Condition::where('name_ar', 'اللفحة المتأخرة')->first()?->id,
            'result_type' => 'combined',
            'confidence' => 0.82,
            'status' => 'preliminary',
            'supporting_indicators' => ['صورة' => 'بقع بنية 87%', 'تربة' => 'نيتروجين منخفض'],
            'conflicts' => null,
            'explanation_ar' => 'تم تشخيص اللفحة المتأخرة بناءً على تحليل الصورة (ثقة 87.5%) وقراءة التربة التي تظهر نقص نيتروجين مما يضعف المقاومة. النتيجة مدعومة بمعرفة موثقة.',
            'advisory_notice_ar' => 'يرجى مراجعة التوصية وإزالة الأوراق المصابة فوراً.',
        ]);

        $knowledge = KnowledgeEntry::where('title_ar', 'أعراض اللفحة المتأخرة على الطماطم')->first();
        if ($knowledge) {
            DiagnosisResultSource::create([
                'diagnosis_result_id' => $result->id,
                'knowledge_entry_id' => $knowledge->id,
                'match_score' => 0.89,
            ]);
        }

        HistoryRecord::create([
            'diagnosis_case_id' => $case->id,
            'operation_type' => 'combined',
            'summary_ar' => 'تشخيص مدمج للطماطم: اللفحة المتأخرة بثقة 82%',
            'occurred_at' => now()->subHour(),
        ]);
    }
}
