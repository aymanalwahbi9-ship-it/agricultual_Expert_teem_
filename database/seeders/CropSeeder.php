<?php

namespace Database\Seeders;

use App\Models\Crop;
use Illuminate\Database\Seeder;

class CropSeeder extends Seeder
{
    public function run(): void
    {
        $crops = [
            [
                'name_ar' => 'البن اليمني',
                'name_en' => 'Yemeni Coffee',
                'description' => 'محصول البن اليمني الشهير، يحتاج إلى تربة جيدة التصريف ومناخ معتدل وظل جزئي.',
                'is_active' => true,
            ],
            [
                'name_ar' => 'الطماطم',
                'name_en' => 'Tomato',
                'description' => 'محصول خضري واسع الانتشار، حساس للأمراض الفطرية ونقص العناصر.',
                'is_active' => true,
            ],
            [
                'name_ar' => 'البطاطس',
                'name_en' => 'Potato',
                'description' => 'محصول درني يحتاج إلى تربة رملية خفيفة ودرجات حرارة معتدلة.',
                'is_active' => true,
            ],
            [
                'name_ar' => 'القمح',
                'name_en' => 'Wheat',
                'description' => 'محصول حبوب أساسي، يتأثر بصدأ الأوراق ونقص النيتروجين.',
                'is_active' => true,
            ],
            [
                'name_ar' => 'الذرة الشامية',
                'name_en' => 'Maize',
                'description' => 'محصول حبوب يتحمل الجفاف نسبياً ويحتاج إلى تسميد متوازن.',
                'is_active' => true,
            ],
            [
                'name_ar' => 'القات',
                'name_en' => 'Khat',
                'description' => 'محصول منتشر في اليمن، يحتاج إلى متابعة مستمرة للآفات والأمراض.',
                'is_active' => false,
            ],
        ];

        foreach ($crops as $crop) {
            Crop::create($crop);
        }
    }
}
