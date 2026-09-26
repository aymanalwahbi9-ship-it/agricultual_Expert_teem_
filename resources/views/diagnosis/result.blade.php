@extends('layouts.app')

@section('title', 'نتيجة التشخيص')

@section('content')
    @php
        $elementLabels = [
            'nitrogen' => 'النيتروجين',
            'phosphorus' => 'الفوسفور',
            'potassium' => 'البوتاسيوم',
            'ph' => 'درجة الحموضة',
            'moisture' => 'الرطوبة',
            'temperature' => 'درجة الحرارة',
        ];

        $statusLabels = [
            'low' => 'منخفض',
            'normal' => 'مناسب',
            'high' => 'مرتفع',
        ];
    @endphp

    <div class="mb-8">
        <span class="section-tag bg-emerald-100 text-emerald-800">
            نتيجة العملية
        </span>

        <h1 class="section-title mt-4">
            نتيجة التشخيص الزراعي
        </h1>

        @if ($result['crop'] ?? null)
            <p class="mt-4 text-base text-slate-600">
                المحصول:
                <strong class="text-slate-900">
                    {{ $result['crop']->name_ar }}
                </strong>
            </p>
        @endif

        <p class="mt-3 max-w-3xl text-base leading-8 text-slate-600">
            هذه النتيجة إرشادية أولية مبنية على بيانات الإدخال والمحاكاة المحلية، وتُستخدم كدليل سريع لفهم الحالة العامة للنبات أو التربة.
        </p>
    </div>

    <section class="summary-panel mb-6">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-black text-emerald-700">
                    ملخص سريع
                </p>

                <h2 class="mt-2 text-2xl font-black text-slate-900">
                    @if ($result['image'] ?? null)
                        {{ $result['image']['label'] }}
                    @elseif ($result['soil'] ?? null)
                        تقييم التربة
                    @else
                        تحليل زراعي
                    @endif
                </h2>
            </div>

            <div class="flex flex-wrap gap-2">
                @if ($result['image'] ?? null)
                    <span class="status-badge bg-blue-100 text-blue-800">
                        تحليل صورة
                    </span>
                @endif

                @if ($result['soil'] ?? null)
                    <span class="status-badge bg-amber-100 text-amber-800">
                        تحليل تربة
                    </span>
                @endif

                <span class="status-badge bg-emerald-100 text-emerald-800">
                    محاكاة تعليمية
                </span>
            </div>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-3">
            <div class="metric-box">
                <p class="text-sm font-bold text-slate-500">نوع التحليل</p>
                <p class="mt-2 text-xl font-black text-slate-900">
                    {{ ($result['image'] ?? null) ? 'صورة' : (($result['soil'] ?? null) ? 'تربة' : 'مُدمج') }}
                </p>
            </div>

            <div class="metric-box">
                <p class="text-sm font-bold text-slate-500">المحصول</p>
                <p class="mt-2 text-xl font-black text-slate-900">
                    {{ $result['crop']->name_ar ?? 'غير محدد' }}
                </p>
            </div>

            <div class="metric-box">
                <p class="text-sm font-bold text-slate-500">حالة الخلاصة</p>
                <p class="mt-2 text-xl font-black text-slate-900">
                    @if ($result['image'] ?? null)
                        {{ number_format(($result['image']['confidence'] ?? 0) * 100, 0) }}٪
                    @else
                        أولية
                    @endif
                </p>
            </div>
        </div>
    </section>

    @if ($result['soil'])
        <section class="card mb-6">
            <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <p class="text-sm font-black text-amber-700">
                        مصدر النتيجة
                    </p>

                    <h2 class="mt-1 text-2xl font-black text-slate-900">
                        تحليل التربة
                    </h2>
                </div>

                <span class="status-badge bg-amber-100 text-amber-800">
                    قراءة محاكاة
                </span>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200">
                <div class="grid grid-cols-3 bg-slate-100 px-4 py-3 text-sm font-black text-slate-700">
                    <span>العنصر</span>
                    <span>القيمة</span>
                    <span>التصنيف</span>
                </div>

                @foreach ($result['soil'] as $element => $assessment)
                    @php
                        $status = $assessment['status'];

                        $statusClass = match ($status) {
                            'low' => 'bg-red-100 text-red-800',
                            'high' => 'bg-orange-100 text-orange-800',
                            default => 'bg-green-100 text-green-800',
                        };
                    @endphp

                    <div class="grid grid-cols-3 border-t border-slate-200 px-4 py-4 text-sm">
                        <span class="font-bold text-slate-800">
                            {{ $elementLabels[$element] ?? 'عنصر زراعي' }}
                        </span>

                        <span class="text-slate-600">
                            {{ $assessment['value'] }}
                        </span>

                        <span>
                            <span class="inline-flex rounded-full px-3 py-1 font-bold {{ $statusClass }}">
                                {{ $statusLabels[$status] ?? 'غير حاسمة' }}
                            </span>
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm leading-7 text-amber-900">
                تصنيف التربة أولي وتعليمي، ويجب مقارنته بحدود المحصول وتحليل مختبري عند الحاجة.
            </div>
        </section>
    @endif

    @if ($result['image'])
        <section class="card mb-6">
            <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-start">
                <div>
                    <p class="text-sm font-black text-emerald-700">
                        مصدر النتيجة
                    </p>

                    <h2 class="mt-1 text-2xl font-black text-slate-900">
                        تحليل صورة النبات
                    </h2>
                </div>

                <span class="status-badge bg-blue-100 text-blue-800">
                    محاكاة تعليمية
                </span>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-[1.15fr_.85fr]">
                <div class="rounded-[1.5rem] border border-emerald-200 bg-gradient-to-br from-emerald-50 via-white to-green-50 p-5">
                    <p class="text-sm font-black text-emerald-800">
                        الحالة المحتملة
                    </p>

                    <h3 class="mt-2 text-3xl font-black text-emerald-950">
                        {{ $result['image']['label'] }}
                    </h3>

                    <p class="mt-4 text-lg font-bold text-slate-800">
                        درجة الاحتمال:
                        {{ number_format($result['image']['confidence'] * 100, 0) }}٪
                    </p>
                </div>

                <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5">
                    <h3 class="font-black text-slate-900">
                        المؤشرات المحتملة
                    </h3>

                    <ul class="mt-4 space-y-2">
                        @foreach ($result['image']['indicators'] as $indicator)
                            <li class="rounded-xl bg-white px-4 py-3 text-sm leading-7 text-slate-700 shadow-sm">
                                {{ $indicator }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            @if ($result['recommendation'])
                <div class="mt-6 rounded-[1.5rem] border border-emerald-200 bg-gradient-to-br from-emerald-50 to-white p-5">
                    <p class="text-sm font-black text-emerald-700">
                        التوصية الأولية
                    </p>

                    <h3 class="mt-2 text-xl font-black text-emerald-950">
                        {{ $result['recommendation']->title_ar }}
                    </h3>

                    <p class="mt-3 leading-8 text-emerald-900">
                        {{ $result['recommendation']->content_ar }}
                    </p>

                    @if ($result['recommendation']->warning_ar)
                        <p class="mt-4 rounded-xl bg-white/80 p-3 text-sm leading-7 text-amber-900">
                            {{ $result['recommendation']->warning_ar }}
                        </p>
                    @endif

                    @if ($result['recommendation']->knowledgeEntry)
                        <p class="mt-4 text-xs text-emerald-800">
                            المصدر:
                            {{ $result['recommendation']->knowledgeEntry->source_name }}
                        </p>

                        @if ($result['recommendation']->knowledgeEntry->reviewed_at)
                            <p class="mt-1 text-xs text-emerald-800">
                                تاريخ المراجعة:
                                {{ $result['recommendation']->knowledgeEntry->reviewed_at->format('Y-m-d') }}
                            </p>
                        @endif
                    @endif
                </div>
            @else
                <div class="mt-6 rounded-[1.5rem] border border-amber-200 bg-amber-50 p-4 text-sm leading-7 text-amber-900">
                    لم نجد توصية موثقة كافية لهذه الحالة في قاعدة المعرفة.
                </div>
            @endif

            <div class="mt-6 rounded-[1.5rem] border border-blue-200 bg-blue-50 p-4 text-sm leading-7 text-blue-900">
                هذه النتيجة محاكاة تعليمية وليست تشخيصًا مؤكدًا. يمكنك البحث عن الحالة في قاعدة المعرفة أو مراجعة مهندس زراعي.
            </div>

            <a href="{{ route('knowledge.index', ['term' => $result['image']['label']]) }}" class="primary-button mt-5">
                البحث عن هذه الحالة في قاعدة المعرفة
            </a>
        </section>
    @endif

    <div class="flex flex-wrap gap-3">
        <a href="{{ route('diagnosis.create') }}" class="secondary-button">
            تنفيذ تشخيص جديد
        </a>

        <a href="{{ route('home') }}" class="secondary-button">
            العودة إلى الرئيسية
        </a>
    </div>
@endsection
