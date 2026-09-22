<?php

namespace Database\Seeders;

use App\Models\Condition;
use App\Models\Crop;
use App\Models\KnowledgeEntry;
use Illuminate\Database\Seeder;

class KnowledgeEntrySeeder extends Seeder
{
    public function run(): void
    {
        $entries = [
            [
                'crop' => 'الطماطم',
                'condition' => 'اللفحة المتأخرة',
                'content_type' => 'symptom',
                'title_ar' => 'أعراض اللفحة المتأخرة على الطماطم',
                'content_ar' => 'تظهر بقع مائية داكنة على حواف الأوراق تتحول إلى بنية، مع نمو زغبي أبيض على السطح السفلي في الرطوبة العالية. تصاب الثمار ببقع بنية صلبة.',
                'keywords' => ['لفحة', 'بقع بنية', 'طماطم', 'Phytophthora'],
                'source_name' => 'دليل أمراض الخضار - وزارة الزراعة اليمنية',
                'source_reference' => 'https://example.com/late-blight',
                'reviewed_at' => '2025-01-15',
            ],
            [
                'crop' => 'البن اليمني',
                'condition' => 'صدأ البن',
                'content_type' => 'symptom',
                'title_ar' => 'صدأ البن اليمني - الأعراض والانتشار',
                'content_ar' => 'يظهر صدأ البن كبقع صفراء على السطح العلوي للأوراق وبقع برتقالية مسحوقية على السطح السفلي. يؤدي إلى تساقط الأوراق وضعف الإنتاج.',
                'keywords' => ['صدأ', 'بن يمني', 'بقع برتقالية'],
                'source_name' => 'مركز البحوث الزراعية - ذمار',
                'source_reference' => null,
                'reviewed_at' => '2025-02-10',
            ],
            [
                'crop' => 'الطماطم',
                'condition' => 'نقص النيتروجين',
                'content_type' => 'explanation',
                'title_ar' => 'نقص النيتروجين في الطماطم',
                'content_ar' => 'النيتروجين عنصر أساسي لنمو الأوراق. نقصه يسبب اصفرار الأوراق السفلية أولاً ثم ينتقل للأعلى، مع تقزم النبات وصغر حجم الثمار.',
                'keywords' => ['نيتروجين', 'اصفرار', 'تسميد'],
                'source_name' => 'دليل التسميد المتوازن',
                'source_reference' => null,
                'reviewed_at' => '2025-03-01',
            ],
            [
                'crop' => 'البطاطس',
                'condition' => 'اللفحة المتأخرة',
                'content_type' => 'initial_action',
                'title_ar' => 'إجراءات أولية عند ظهور اللفحة في البطاطس',
                'content_ar' => 'إزالة الأوراق المصابة فوراً وحرقها، تجنب الري بالرش، تحسين التهوية، وعدم ملامسة النباتات السليمة بعد المصابة.',
                'keywords' => ['إجراء أولي', 'بطاطس', 'لفحة'],
                'source_name' => 'إرشادات المكافحة المتكاملة',
                'source_reference' => null,
                'reviewed_at' => '2025-01-20',
            ],
            [
                'crop' => null,
                'condition' => 'حشرة المن',
                'content_type' => 'recommendation',
                'title_ar' => 'مكافحة حشرة المن بطرق عضوية',
                'content_ar' => 'يمكن مكافحة المن برش محلول صابوني (صابون زراعي) أو مستخلص النيم، وتشجيع الأعداء الحيوية مثل الدعسوقة. تجنب الإفراط في التسميد النيتروجيني.',
                'keywords' => ['من', 'مكافحة عضوية', 'نيم'],
                'source_name' => 'دليل الزراعة العضوية اليمنية',
                'source_reference' => null,
                'reviewed_at' => '2025-02-15',
            ],
            [
                'crop' => 'القمح',
                'condition' => 'ملوحة التربة',
                'content_type' => 'explanation',
                'title_ar' => 'تأثير ملوحة التربة على القمح',
                'content_ar' => 'الملوحة تقلل امتصاص الماء وتسبب احتراق حواف الأوراق. القمح يتحمل ملوحة حتى 6 ديسيسيمنز/متر، بعدها ينخفض الإنتاج.',
                'keywords' => ['ملوحة', 'قمح', 'تحمل'],
                'source_name' => 'بحوث التربة والمياه',
                'source_reference' => null,
                'reviewed_at' => '2025-03-10',
            ],
            [
                'crop' => 'الطماطم',
                'condition' => 'نقص البوتاسيوم',
                'content_type' => 'symptom',
                'title_ar' => 'أعراض نقص البوتاسيوم',
                'content_ar' => 'يظهر احتراق على حواف الأوراق القديمة مع بقع بنية، وضعف في عقد الثمار وسوء تلوينها.',
                'keywords' => ['بوتاسيوم', 'احتراق حواف'],
                'source_name' => 'دليل نقص العناصر',
                'source_reference' => null,
                'reviewed_at' => '2025-01-30',
            ],
            [
                'crop' => 'الذرة الشامية',
                'condition' => 'نقص النيتروجين',
                'content_type' => 'recommendation',
                'title_ar' => 'توصية تسميد النيتروجين للذرة',
                'content_ar' => 'يضاف النيتروجين على دفعتين: الأولى عند الزراعة والثانية عند مرحلة 4-6 أوراق. يفضل استخدام اليوريا مع الري.',
                'keywords' => ['ذرة', 'تسميد', 'يوريا'],
                'source_name' => 'دليل زراعة الذرة',
                'source_reference' => null,
                'reviewed_at' => '2025-02-20',
            ],
        ];

        foreach ($entries as $data) {
            $cropId = null;
            $conditionId = null;

            if ($data['crop']) {
                $crop = Crop::where('name_ar', $data['crop'])->first();
                $cropId = $crop?->id;
            }
            if ($data['condition']) {
                $cond = Condition::where('name_ar', $data['condition'])->first();
                $conditionId = $cond?->id;
            }

            KnowledgeEntry::create([
                'crop_id' => $cropId,
                'condition_id' => $conditionId,
                'content_type' => $data['content_type'],
                'title_ar' => $data['title_ar'],
                'content_ar' => $data['content_ar'],
                'keywords' => $data['keywords'],
                'source_name' => $data['source_name'],
                'source_reference' => $data['source_reference'],
                'reviewed_at' => $data['reviewed_at'],
                'is_active' => true,
            ]);
        }
    }
}
