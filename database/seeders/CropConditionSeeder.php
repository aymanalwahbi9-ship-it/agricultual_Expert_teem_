<?php

namespace Database\Seeders;

use App\Models\Condition;
use App\Models\Crop;
use App\Models\CropCondition;
use Illuminate\Database\Seeder;

class CropConditionSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'البن اليمني' => ['صدأ البن', 'حشرة المن', 'نقص النيتروجين', 'ملوحة التربة'],
            'الطماطم' => ['اللفحة المتأخرة', 'البياض الدقيقي', 'حشرة المن', 'دودة ثمار الطماطم', 'نقص النيتروجين', 'نقص البوتاسيوم', 'الذبول الفيوزاريومي'],
            'البطاطس' => ['اللفحة المتأخرة', 'البياض الدقيقي', 'نقص البوتاسيوم', 'نقص الحديد'],
            'القمح' => ['البياض الدقيقي', 'حشرة المن', 'نقص النيتروجين', 'ملوحة التربة'],
            'الذرة الشامية' => ['حشرة المن', 'نقص النيتروجين', 'نقص البوتاسيوم', 'ملوحة التربة'],
        ];

        foreach ($map as $cropName => $conditionNames) {
            $crop = Crop::where('name_ar', $cropName)->first();
            if (! $crop) {
                continue;
            }
            foreach ($conditionNames as $condName) {
                $condition = Condition::where('name_ar', $condName)->first();
                if (! $condition) {
                    continue;
                }
                CropCondition::firstOrCreate([
                    'crop_id' => $crop->id,
                    'condition_id' => $condition->id,
                ], [
                    'relevance_note' => "حالة {$condName} شائعة في محصول {$cropName} في اليمن",
                ]);
            }
        }
    }
}
