<?php

namespace Database\Seeders;

use App\Models\Condition;
use App\Models\ConditionSymptom;
use App\Models\Symptom;
use Illuminate\Database\Seeder;

class ConditionSymptomSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'اللفحة المتأخرة' => [
                'بقع بنية على الأوراق' => 0.90,
                'ذبول مفاجئ' => 0.70,
                'تعفن الجذور' => 0.50,
            ],
            'البياض الدقيقي' => [
                'مسحوق أبيض على الأوراق' => 0.95,
                'تجعد والتفاف الأوراق' => 0.60,
                'تساقط الأزهار' => 0.40,
            ],
            'حشرة المن' => [
                'وجود حشرات صغيرة خضراء' => 0.95,
                'تجعد والتفاف الأوراق' => 0.80,
                'تقزم وضعف النمو' => 0.60,
                'اصفرار عام للنبات' => 0.50,
            ],
            'دودة ثمار الطماطم' => [
                'ثقوب في الثمار' => 0.95,
                'تساقط الأزهار' => 0.50,
            ],
            'نقص النيتروجين' => [
                'اصفرار الأوراق السفلية' => 0.90,
                'تقزم وضعف النمو' => 0.75,
                'اصفرار عام للنبات' => 0.80,
            ],
            'نقص البوتاسيوم' => [
                'احتراق حواف الأوراق' => 0.90,
                'بقع بنية على الأوراق' => 0.60,
                'ضعف عام' => 0.50,
            ],
            'نقص الحديد' => [
                'اصفرار بين العروق' => 0.95,
                'اصفرار الأوراق السفلية' => 0.40,
            ],
            'ملوحة التربة' => [
                'احتراق حواف الأوراق' => 0.80,
                'ذبول مفاجئ' => 0.70,
                'تقزم وضعف النمو' => 0.65,
            ],
            'صدأ البن' => [
                'بقع برتقالية على الأوراق' => 0.95,
                'بقع بنية على الأوراق' => 0.70,
                'تساقط الأزهار' => 0.60,
            ],
            'الذبول الفيوزاريومي' => [
                'ذبول مفاجئ' => 0.95,
                'اصفرار الأوراق السفلية' => 0.80,
                'تعفن الجذور' => 0.85,
            ],
        ];

        foreach ($map as $conditionName => $symptoms) {
            $condition = Condition::where('name_ar', $conditionName)->first();
            if (! $condition) {
                continue;
            }
            foreach ($symptoms as $symptomName => $weight) {
                $symptom = Symptom::where('name_ar', $symptomName)->first();
                if (! $symptom) {
                    // try partial match
                    $symptom = Symptom::where('name_ar', 'LIKE', "%{$symptomName}%")->first();
                }
                if (! $symptom) {
                    continue;
                }
                ConditionSymptom::firstOrCreate([
                    'condition_id' => $condition->id,
                    'symptom_id' => $symptom->id,
                ], [
                    'weight' => $weight,
                ]);
            }
        }
    }
}
