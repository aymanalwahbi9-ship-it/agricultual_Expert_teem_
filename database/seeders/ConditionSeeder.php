<?php

namespace Database\Seeders;

use App\Models\Condition;
use Illuminate\Database\Seeder;

class ConditionSeeder extends Seeder
{
    public function run(): void
    {
        $conditions = [
            [
                'name_ar' => 'اللفحة المتأخرة',
                'name_en' => 'Late Blight',
                'type' => 'disease',
                'description' => 'مرض فطري يسببه Phytophthora infestans، يظهر كبقع بنية على الأوراق والثمار.',
                'is_active' => true,
            ],
            [
                'name_ar' => 'البياض الدقيقي',
                'name_en' => 'Powdery Mildew',
                'type' => 'disease',
                'description' => 'مرض فطري يظهر كمسحوق أبيض على سطح الأوراق.',
                'is_active' => true,
            ],
            [
                'name_ar' => 'حشرة المن',
                'name_en' => 'Aphids',
                'type' => 'pest',
                'description' => 'حشرات صغيرة تمتص عصارة النبات وتسبب تجعد الأوراق ونقل الفيروسات.',
                'is_active' => true,
            ],
            [
                'name_ar' => 'دودة ثمار الطماطم',
                'name_en' => 'Tomato Fruit Worm',
                'type' => 'pest',
                'description' => 'يرقات تحفر داخل ثمار الطماطم وتسبب تلف المحصول.',
                'is_active' => true,
            ],
            [
                'name_ar' => 'نقص النيتروجين',
                'name_en' => 'Nitrogen Deficiency',
                'type' => 'nutrient_deficiency',
                'description' => 'يظهر كاصفرار عام في الأوراق السفلية وضعف النمو.',
                'is_active' => true,
            ],
            [
                'name_ar' => 'نقص البوتاسيوم',
                'name_en' => 'Potassium Deficiency',
                'type' => 'nutrient_deficiency',
                'description' => 'احتراق حواف الأوراق وضعف مقاومة النبات.',
                'is_active' => true,
            ],
            [
                'name_ar' => 'نقص الحديد',
                'name_en' => 'Iron Deficiency',
                'type' => 'nutrient_deficiency',
                'description' => 'اصفرار بين العروق في الأوراق الحديثة.',
                'is_active' => true,
            ],
            [
                'name_ar' => 'ملوحة التربة',
                'name_en' => 'Soil Salinity',
                'type' => 'soil_disorder',
                'description' => 'ارتفاع الأملاح في التربة يسبب ذبول وضعف امتصاص الماء.',
                'is_active' => true,
            ],
            [
                'name_ar' => 'صدأ البن',
                'name_en' => 'Coffee Rust',
                'type' => 'disease',
                'description' => 'مرض فطري يصيب البن اليمني، بقع برتقالية على السطح السفلي للأوراق.',
                'is_active' => true,
            ],
            [
                'name_ar' => 'الذبول الفيوزاريومي',
                'name_en' => 'Fusarium Wilt',
                'type' => 'disease',
                'description' => 'مرض يسبب ذبول مفاجئ واصفرار وموت النبات.',
                'is_active' => true,
            ],
        ];

        foreach ($conditions as $condition) {
            Condition::create($condition);
        }
    }
}
