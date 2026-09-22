<?php

namespace Database\Seeders;

use App\Models\Condition;
use App\Models\KnowledgeEntry;
use App\Models\Recommendation;
use Illuminate\Database\Seeder;

class RecommendationSeeder extends Seeder
{
    public function run(): void
    {
        $recommendations = [
            [
                'condition' => 'اللفحة المتأخرة',
                'knowledge_title' => 'أعراض اللفحة المتأخرة على الطماطم',
                'title_ar' => 'مكافحة اللفحة المتأخرة',
                'content_ar' => 'استخدم مبيد فطري نحاسي مثل أوكسي كلوريد النحاس بتركيز 2.5 جرام/لتر، رش كل 7-10 أيام، مع إزالة الأجزاء المصابة وتحسين التهوية. تجنب الري المسائي.',
                'warning_ar' => 'لا ترش في وقت الظهيرة الحار، والتزم بفترة الأمان 7 أيام قبل الحصاد.',
            ],
            [
                'condition' => 'البياض الدقيقي',
                'knowledge_title' => 'أعراض اللفحة المتأخرة على الطماطم',
                'title_ar' => 'علاج البياض الدقيقي',
                'content_ar' => 'رش الكبريت الميكروني 80% بتركيز 2 جرام/لتر أو بيكربونات البوتاسيوم. تهوية جيدة وتقليل الكثافة النباتية.',
                'warning_ar' => 'الكبريت لا يستخدم عند درجة حرارة فوق 30 مئوية.',
            ],
            [
                'condition' => 'حشرة المن',
                'knowledge_title' => 'مكافحة حشرة المن بطرق عضوية',
                'title_ar' => 'مكافحة المن',
                'content_ar' => 'رش صابون زراعي 1% مع زيت نيم 0.5%. إطلاق الدعسوقة. إزالة الحشائش العائلة. يمكن استخدام أسيتامبريد عند الإصابة الشديدة.',
                'warning_ar' => 'تجنب المبيدات واسعة الطيف للحفاظ على الأعداء الحيوية.',
            ],
            [
                'condition' => 'نقص النيتروجين',
                'knowledge_title' => 'نقص النيتروجين في الطماطم',
                'title_ar' => 'تعويض نقص النيتروجين',
                'content_ar' => 'إضافة سماد يوريا 46% بمعدل 50 كجم/هكتار مع الري، أو نترات الأمونيوم. إضافة سماد عضوي متحلل 10 طن/هكتار.',
                'warning_ar' => 'الإفراط في النيتروجين يسبب زيادة النمو الخضري على حساب الثمار.',
            ],
            [
                'condition' => 'صدأ البن',
                'knowledge_title' => 'صدأ البن اليمني - الأعراض والانتشار',
                'title_ar' => 'مكافحة صدأ البن',
                'content_ar' => 'تقليم لتحسين التهوية، إزالة الأوراق المصابة، رش مبيد نحاسي وقائي قبل موسم الأمطار. زراعة أصناف مقاومة إن وجدت.',
                'warning_ar' => 'الوقاية أهم من العلاج، راقب الحقل أسبوعياً.',
            ],
            [
                'condition' => 'ملوحة التربة',
                'knowledge_title' => 'تأثير ملوحة التربة على القمح',
                'title_ar' => 'معالجة ملوحة التربة',
                'content_ar' => 'غسل التربة بمياه جيدة، إضافة الجبس الزراعي 2-3 طن/هكتار، إضافة مادة عضوية، زراعة محاصيل متحملة، وتحسين الصرف.',
                'warning_ar' => 'لا تستخدم مياه ري مالحة، وحلل التربة كل موسم.',
            ],
            [
                'condition' => 'نقص البوتاسيوم',
                'knowledge_title' => 'أعراض نقص البوتاسيوم',
                'title_ar' => 'تعويض نقص البوتاسيوم',
                'content_ar' => 'إضافة سلفات البوتاسيوم 50% بمعدل 100 كجم/هكتار، أو نترات البوتاسيوم رشاً ورقياً 2%.',
                'warning_ar' => null,
            ],
            [
                'condition' => 'الذبول الفيوزاريومي',
                'knowledge_title' => 'إجراءات أولية عند ظهور اللفحة في البطاطس',
                'title_ar' => 'إدارة الذبول الفيوزاريومي',
                'content_ar' => 'دورة زراعية 4 سنوات، تعقيم التربة شمسياً، استخدام شتلات سليمة، إزالة النباتات المصابة وحرقها، تحسين الصرف.',
                'warning_ar' => 'لا يوجد علاج كيميائي فعال بعد الإصابة، الوقاية أساسية.',
            ],
        ];

        foreach ($recommendations as $rec) {
            $condition = Condition::where('name_ar', $rec['condition'])->first();
            if (! $condition) {
                continue;
            }

            $knowledge = KnowledgeEntry::where('title_ar', $rec['knowledge_title'])->first();
            if (! $knowledge) {
                $knowledge = KnowledgeEntry::where('condition_id', $condition->id)->first();
            }
            if (! $knowledge) {
                $knowledge = KnowledgeEntry::first();
            }

            Recommendation::create([
                'condition_id' => $condition->id,
                'knowledge_entry_id' => $knowledge->id,
                'title_ar' => $rec['title_ar'],
                'content_ar' => $rec['content_ar'],
                'warning_ar' => $rec['warning_ar'],
                'is_active' => true,
            ]);
        }
    }
}
