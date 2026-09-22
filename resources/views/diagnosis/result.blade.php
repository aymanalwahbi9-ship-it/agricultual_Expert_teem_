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
        <p class="text-sm font-bold text-green-700">
            نتيجة العملية
        </p>

        <h1 class="mt-2 text-3xl font-black text-slate-900 sm:text-4xl">
            نتيجة التشخيص الزراعي
        </h1>

        @if ($result['crop'] ?? null)
            <p class="mt-3 text-slate-600">
                المحصول:
                <strong class="text-slate-900">
                    {{ $result['crop']->name_ar }}
                </strong>
            </p>
        @endif

        <p class="mt-3 leading-7 text-slate-600">
            هذه النتيجة إرشادية أولية مبنية على بيانات الإدخال والمحاكاة المحلية.
        </p>
    </div>

    @if ($result['soil'])
        <section class="card mb-6">
            <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <p class="text-sm font-bold text-amber-700">
                        مصدر النتيجة
                    </p>

                    <h2 class="mt-1 text-2xl font-black text-slate-900">
                        تحليل التربة
                    </h2>
                </div>

                <span class="rounded-full bg-amber-100 px-4 py-2 text-sm font-bold text-amber-800">
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
                    <p class="text-sm font-bold text-green-700">
                        مصدر النتيجة
                    </p>

                    <h2 class="mt-1 text-2xl font-black text-slate-900">
                        تحليل صورة النبات
                    </h2>
                </div>

                <span class="rounded-full bg-blue-100 px-4 py-2 text-sm font-bold text-blue-800">
                    محاكاة تعليمية
                </span>
            </div>

            <div class="mt-6 rounded-2xl border border-green-200 bg-green-50 p-5">
                <p class="text-sm font-bold text-green-800">
                    الحالة المحتملة
                </p>

                <h3 class="mt-2 text-3xl font-black text-green-950">
                    {{ $result['image']['label'] }}
                </h3>

                <p class="mt-4 text-lg font-bold text-slate-800">
                    درجة الاحتمال:
                    {{ number_format($result['image']['confidence'] * 100, 0) }}٪
                </p>
            </div>

            <div class="mt-6">
                <h3 class="font-black text-slate-900">
                    المؤشرات المحتملة
                </h3>

                <ul class="mt-3 space-y-2">
                    @foreach ($result['image']['indicators'] as $indicator)
                        <li class="rounded-xl bg-slate-50 px-4 py-3 text-slate-700">
                            {{ $indicator }}
                        </li>
                    @endforeach
                </ul>
            </div>

            @if ($result['recommendation'])
                <div class="mt-6 rounded-2xl border border-green-200 bg-green-50 p-5">
                    <p class="text-sm font-bold text-green-700">
                        التوصية الأولية
                    </p>

                    <h3 class="mt-2 text-xl font-black text-green-950">
                        {{ $result['recommendation']->title_ar }}
                    </h3>

                    <p class="mt-3 leading-8 text-green-900">
                        {{ $result['recommendation']->content_ar }}
                    </p>

                    @if ($result['recommendation']->warning_ar)
                        <p class="mt-4 rounded-xl bg-white/70 p-3 text-sm leading-7 text-amber-900">
                            {{ $result['recommendation']->warning_ar }}
                        </p>
                    @endif

                    @if ($result['recommendation']->knowledgeEntry)
                        <p class="mt-4 text-xs text-green-800">
                            المصدر:
                            {{ $result['recommendation']->knowledgeEntry->source_name }}
                        </p>

                        @if ($result['recommendation']->knowledgeEntry->reviewed_at)
                            <p class="mt-1 text-xs text-green-800">
                                تاريخ المراجعة:
                                {{ $result['recommendation']->knowledgeEntry->reviewed_at->format('Y-m-d') }}
                            </p>
                        @endif
                    @endif
                </div>
            @else
                <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm leading-7 text-amber-900">
                    لم نجد توصية موثقة كافية لهذه الحالة في قاعدة المعرفة.
                </div>
            @endif

            <div class="mt-6 rounded-2xl border border-blue-200 bg-blue-50 p-4 text-sm leading-7 text-blue-900">
                هذه النتيجة محاكاة تعليمية وليست تشخيصًا مؤكدًا.
                يمكنك البحث عن الحالة في قاعدة المعرفة أو مراجعة مهندس زراعي.
            </div>

            <a
                href="{{ route('knowledge.index', ['term' => $result['image']['label']]) }}"
                class="primary-button mt-5"
            >
                البحث عن هذه الحالة في قاعدة المعرفة
            </a>
        </section>
    @endif

    <div class="flex flex-wrap gap-3">
        <a
            href="{{ route('diagnosis.create') }}"
            class="secondary-button"
        >
            تنفيذ تشخيص جديد
        </a>

        <a
            href="{{ route('home') }}"
            class="secondary-button"
        >
            العودة إلى الرئيسية
        </a>
    </div>
@endsection
