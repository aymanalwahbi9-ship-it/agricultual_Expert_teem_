@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')
    <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-emerald-900 via-green-800 to-emerald-700 px-6 py-10 text-white shadow-[0_25px_60px_rgba(6,78,59,0.24)] sm:px-10 sm:py-14">
        <div class="absolute -left-16 -top-16 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>
        <div class="absolute -bottom-20 -right-10 h-72 w-72 rounded-full bg-emerald-950/40 blur-2xl"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.18),transparent_35%)]"></div>

        <div class="relative max-w-3xl">
            <span class="inline-flex rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-bold text-emerald-50">
                نظام إرشاد زراعي محلي
            </span>

            <h1 class="mt-6 text-3xl font-black leading-tight sm:text-5xl">
                مساعدك لفهم حالة المحصول
            </h1>

            <p class="mt-5 max-w-2xl text-base leading-8 text-emerald-50 sm:text-lg">
                أدخل بيانات محصولك أو ارفع صورة للنبات أو ابحث في قاعدة المعرفة للحصول على نتيجة إرشادية واضحة باللغة العربية.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('diagnosis.create') }}" class="primary-button bg-white text-emerald-900 hover:bg-emerald-50">
                    ابدأ التشخيص
                </a>

                <a href="{{ route('knowledge.index') }}" class="secondary-button border-white/20 bg-white/10 text-white hover:bg-white/20">
                    ابحث في المعرفة
                </a>
            </div>
        </div>
    </section>

    <section class="mt-8 grid gap-5 md:grid-cols-3">
        <a href="{{ route('diagnosis.create') }}" class="feature-card border-green-100 bg-gradient-to-br from-white to-green-50/60">
            <div class="mini-icon bg-green-100 text-2xl shadow-green-100">
                🖼️
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

        <a href="{{ route('diagnosis.create') }}" class="feature-card border-amber-100 bg-gradient-to-br from-white to-amber-50/60">
            <div class="mini-icon bg-amber-100 text-2xl shadow-amber-100">
                🌾
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

        <a href="{{ route('knowledge.index') }}" class="feature-card border-blue-100 bg-gradient-to-br from-white to-blue-50/60">
            <div class="mini-icon bg-blue-100 text-2xl shadow-blue-100">
                🔎
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
                    <p class="text-sm font-black text-emerald-700">المحاصيل المدعومة</p>
                    <h2 class="mt-1 text-2xl font-black text-slate-900">
                        اختر محصولك للبدء
                    </h2>
                </div>

                <span class="stat-pill">
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
                            <p class="mt-1 text-sm leading-6 text-slate-500">
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

        <div class="info-banner border-amber-200 bg-gradient-to-br from-amber-50 to-orange-50">
            <p class="text-sm font-black text-amber-800">تنبيه مهم</p>

            <h2 class="mt-2 text-xl font-black text-amber-950">
                النتيجة إرشادية
            </h2>

            <p class="mt-3 leading-7 text-amber-900">
                يستخدم الإصدار الحالي محاكاة تعليمية لتحليل الصورة وقراءات التربة. لا تعتبر النتيجة تشخيصًا نهائيًا، واستشر مهندسًا زراعيًا عند الحاجة.
            </p>
        </div>
    </section>
@endsection
