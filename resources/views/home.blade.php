@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')
    <section class="relative overflow-hidden rounded-[2rem] bg-green-900 px-6 py-10 text-white shadow-xl sm:px-10 sm:py-14">
        <div class="absolute -left-16 -top-16 h-56 w-56 rounded-full bg-green-800"></div>
        <div class="absolute -bottom-24 -right-12 h-72 w-72 rounded-full bg-green-950/60"></div>

        <div class="relative max-w-3xl">
            <span class="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm font-bold text-green-100">
                نظام إرشاد زراعي محلي
            </span>

            <h1 class="mt-6 text-3xl font-black leading-tight sm:text-5xl">
                مساعدك لفهم حالة المحصول
            </h1>

            <p class="mt-5 max-w-2xl text-base leading-8 text-green-100 sm:text-lg">
                أدخل بيانات محصولك أو ارفع صورة للنبات أو ابحث في قاعدة المعرفة
                للحصول على نتيجة إرشادية واضحة باللغة العربية.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('diagnosis.create') }}" class="primary-button bg-white text-green-900 hover:bg-green-50">
                    ابدأ التشخيص
                </a>

                <a href="{{ route('knowledge.index') }}" class="secondary-button border-white/30 bg-white/10 text-white hover:bg-white/20">
                    ابحث في المعرفة
                </a>
            </div>
        </div>
    </section>

    <section class="mt-8 grid gap-5 md:grid-cols-3">
        <a href="{{ route('diagnosis.create') }}" class="card group transition hover:-translate-y-1 hover:border-green-300 hover:shadow-lg">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-green-100 text-2xl">
                صورة
            </div>

            <h2 class="mt-5 text-xl font-black text-slate-900">
                تحليل صورة النبات
            </h2>

            <p class="mt-3 leading-7 text-slate-600">
                ارفع صورة واضحة للنبات واعرض الحالة المحتملة ودرجة الاحتمال.
            </p>

            <span class="mt-5 inline-block font-bold text-green-700">
                بدء تحليل الصورة ←
            </span>
        </a>

        <a href="{{ route('diagnosis.create') }}" class="card group transition hover:-translate-y-1 hover:border-amber-300 hover:shadow-lg">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-100 text-2xl">
                تربة
            </div>

            <h2 class="mt-5 text-xl font-black text-slate-900">
                تحليل التربة
            </h2>

            <p class="mt-3 leading-7 text-slate-600">
                أدخل قيم التربة واعرف حالة كل عنصر: منخفض أو مناسب أو مرتفع.
            </p>

            <span class="mt-5 inline-block font-bold text-amber-700">
                بدء تحليل التربة ←
            </span>
        </a>

        <a href="{{ route('knowledge.index') }}" class="card group transition hover:-translate-y-1 hover:border-blue-300 hover:shadow-lg">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-2xl">
                بحث
            </div>

            <h2 class="mt-5 text-xl font-black text-slate-900">
                قاعدة المعرفة
            </h2>

            <p class="mt-3 leading-7 text-slate-600">
                ابحث عن مرض أو عرض أو آفة أو توصية زراعية موثقة.
            </p>

            <span class="mt-5 inline-block font-bold text-blue-700">
                فتح البحث ←
            </span>
        </a>
    </section>

    <section class="mt-8 grid gap-5 lg:grid-cols-[1.2fr_.8fr]">
        <div class="card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-bold text-green-700">المحاصيل المدعومة</p>
                    <h2 class="mt-1 text-2xl font-black text-slate-900">
                        اختر محصولك للبدء
                    </h2>
                </div>

                <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-bold text-slate-600">
                    {{ $crops->count() }} محاصيل
                </span>
            </div>

            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                @forelse ($crops as $crop)
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <p class="font-black text-slate-900">
                            {{ $crop->name_ar }}
                        </p>

                        @if ($crop->description)
                            <p class="mt-1 text-sm text-slate-500">
                                {{ $crop->description }}
                            </p>
                        @endif
                    </div>
                @empty
                    <p class="text-slate-500">
                        لا توجد محاصيل مضافة حاليًا.
                    </p>
                @endforelse
            </div>
        </div>

        <div class="card border-amber-200 bg-amber-50">
            <p class="text-sm font-bold text-amber-800">تنبيه مهم</p>

            <h2 class="mt-2 text-xl font-black text-amber-950">
                النتيجة إرشادية
            </h2>

            <p class="mt-3 leading-7 text-amber-900">
                يستخدم الإصدار الحالي محاكاة تعليمية لتحليل الصورة وقراءات التربة.
                لا تعتبر النتيجة تشخيصًا نهائيًا، واستشر مهندسًا زراعيًا عند الحاجة.
            </p>
        </div>
    </section>
@endsection
