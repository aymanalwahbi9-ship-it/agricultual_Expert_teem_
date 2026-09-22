@extends('layouts.app')

@section('title', 'البحث في قاعدة المعرفة')

@section('content')
    <div class="mb-8">
        <p class="text-sm font-bold text-blue-700">
            قاعدة المعرفة الزراعية
        </p>

        <h1 class="mt-2 text-3xl font-black text-slate-900 sm:text-4xl">
            ابحث عن حالة أو عرض زراعي
        </h1>

        <p class="mt-4 max-w-3xl leading-8 text-slate-600">
            اكتب كلمة مثل: اصفرار، ذبول، بقع، حشرة، أو نقص النيتروجين.
            سيعرض النظام المعلومات المتوفرة في قاعدة المعرفة المحلية فقط.
        </p>
    </div>

    <section class="card">
        <form method="GET" action="{{ route('knowledge.index') }}">
            <div class="grid gap-5 md:grid-cols-[1fr_1fr_auto] md:items-end">
                <div>
                    <label for="term" class="input-label">
                        كلمة البحث
                    </label>

                    <input
                        id="term"
                        name="term"
                        type="search"
                        value="{{ $term }}"
                        class="input-control"
                        placeholder="مثال: اصفرار الأوراق"
                    >
                </div>

                <div>
                    <label for="crop_id" class="input-label">
                        المحصول
                    </label>

                    <select id="crop_id" name="crop_id" class="input-control">
                        <option value="">كل المحاصيل</option>

                        @foreach ($crops as $crop)
                            <option
                                value="{{ $crop->id }}"
                                @selected((int) $cropId === $crop->id)
                            >
                                {{ $crop->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="primary-button">
                    تنفيذ البحث
                </button>
            </div>
        </form>
    </section>

    @if ($term !== '' || $cropId > 0)
        <div class="mt-8 flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-bold text-blue-700">
                    نتائج البحث
                </p>

                <h2 class="mt-1 text-2xl font-black text-slate-900">
                    {{ $results->count() }} نتيجة موثقة
                </h2>
            </div>
        </div>

        @if ($results->isEmpty())
            <section class="mt-5 rounded-3xl border border-amber-200 bg-amber-50 p-6 text-amber-900">
                <h2 class="text-xl font-black">
                    لم نجد معلومات كافية
                </h2>

                <p class="mt-2 leading-7">
                    جرّب كلمة أخرى أو اختر محصولًا مختلفًا. لا ينشئ النظام توصية
                    جديدة من عنده عندما لا توجد معلومة موثقة.
                </p>
            </section>
        @else
            <div class="mt-5 grid gap-5">
                @foreach ($results as $entry)
                    <article class="card border-blue-100">
                        <div class="flex flex-col justify-between gap-4 sm:flex-row">
                            <div>
                                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800">
                                    {{ $entry->content_type === 'recommendation' ? 'توصية إرشادية' : 'معلومة زراعية' }}
                                </span>

                                <h3 class="mt-4 text-xl font-black text-slate-900">
                                    {{ $entry->title_ar }}
                                </h3>
                            </div>

                            @if ($entry->condition)
                                <span class="h-fit rounded-full bg-slate-100 px-3 py-1 text-sm font-bold text-slate-600">
                                    {{ $entry->condition->name_ar }}
                                </span>
                            @endif
                        </div>

                        <p class="mt-4 leading-8 text-slate-700">
                            {{ $entry->content_ar }}
                        </p>

                        <div class="mt-5 flex flex-wrap gap-3 text-sm text-slate-500">
                            @if ($entry->crop)
                                <span class="rounded-full bg-green-50 px-3 py-1 text-green-800">
                                    المحصول: {{ $entry->crop->name_ar }}
                                </span>
                            @endif

                            <span class="rounded-full bg-slate-100 px-3 py-1">
                                المصدر: {{ $entry->source_name }}
                            </span>

                            @if ($entry->reviewed_at)
                                <span class="rounded-full bg-slate-100 px-3 py-1">
                                    تاريخ المراجعة: {{ $entry->reviewed_at->format('Y-m-d') }}
                                </span>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    @else
        <section class="mt-8 rounded-3xl border border-blue-100 bg-blue-50 p-6 text-blue-900">
            <h2 class="text-xl font-black">
                ابدأ البحث
            </h2>

            <p class="mt-2 leading-7">
                اختر محصولًا أو اكتب كلمة بحث، ثم اضغط «تنفيذ البحث».
            </p>
        </section>
    @endif
@endsection
