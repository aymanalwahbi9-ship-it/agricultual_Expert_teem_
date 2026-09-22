@extends('layouts.app')

@section('title', 'بدء التشخيص')

@section('content')
    <div class="mb-8 grid gap-6 lg:grid-cols-[1.25fr_.75fr] lg:items-center">
        <section>
            <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-green-100 px-4 py-2 text-sm font-bold text-green-800">
                <span class="h-2.5 w-2.5 rounded-full bg-green-600"></span>
                خدمة إرشاد زراعي محلية
            </div>

            <h1 class="max-w-3xl text-3xl font-black leading-tight text-slate-900 sm:text-5xl">
                افهم حالة محصولك
                <span class="text-green-700">بخطوات بسيطة</span>
            </h1>

            <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">
                أدخل بيانات التربة أو ارفع صورة للنبات، وسيعرض لك النظام قراءة أولية
                واضحة مع تنبيه إرشادي باللغة العربية.
            </p>

            <div class="mt-6 flex flex-wrap gap-3 text-sm font-bold text-slate-600">
                <span class="rounded-full bg-white px-4 py-2 shadow-sm">واجهة عربية</span>
                <span class="rounded-full bg-white px-4 py-2 shadow-sm">نتائج واضحة</span>
                <span class="rounded-full bg-white px-4 py-2 shadow-sm">محاكاة تعليمية</span>
            </div>
        </section>

        <section class="relative overflow-hidden rounded-3xl bg-green-800 p-7 text-white shadow-xl">
            <div class="absolute -left-12 -top-12 h-40 w-40 rounded-full bg-green-700"></div>
            <div class="absolute -bottom-16 -right-10 h-48 w-48 rounded-full bg-green-900/60"></div>

            <div class="relative">
                <div class="mb-6 text-6xl">🌱</div>

                <h2 class="text-2xl font-black">
                    ابدأ بفحص مزرعتك
                </h2>

                <p class="mt-3 leading-7 text-green-100">
                    استخدم القيم المتوفرة لديك. النتيجة أولية ومساعدة، ويُنصح دائمًا
                    بمراجعة مهندس زراعي عند ظهور مشكلة.
                </p>
            </div>
        </section>
    </div>

    <section class="card">
        <div class="mb-7 border-b border-slate-100 pb-5">
            <p class="text-sm font-bold text-green-700">
                نموذج التشخيص
            </p>

            <h2 class="mt-1 text-2xl font-black text-slate-900">
                أدخل معلومات المحصول
            </h2>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800">
                <p class="font-black">
                    يرجى تصحيح البيانات التالية:
                </p>

                <ul class="mt-2 list-inside list-disc space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('diagnosis.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="crop_id" class="input-label">
                        المحصول
                    </label>

                    <select
                        id="crop_id"
                        name="crop_id"
                        class="input-control"
                        required
                    >
                        <option value="">
                            اختر المحصول
                        </option>

                        @foreach ($crops as $crop)
                            <option
                                value="{{ $crop->id }}"
                                @selected(old('crop_id') == $crop->id)
                            >
                                {{ $crop->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="operation_type" class="input-label">
                        طريقة التشخيص
                    </label>

                    <select
                        id="operation_type"
                        name="operation_type"
                        class="input-control"
                        required
                    >
                        <option value="">
                            اختر طريقة التشخيص
                        </option>

                        <option
                            value="image"
                            @selected(old('operation_type') === 'image')
                        >
                            تحليل صورة النبات
                        </option>

                        <option
                            value="soil"
                            @selected(old('operation_type') === 'soil')
                        >
                            تحليل بيانات التربة
                        </option>

                        <option
                            value="combined"
                            @selected(old('operation_type') === 'combined')
                        >
                            تحليل مدمج
                        </option>
                    </select>
                </div>
            </div>

            <div
                id="image-section"
                class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-5"
            >
                <div class="mb-5 flex items-start gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-100 text-sm font-bold text-green-800">
                        صورة
                    </div>

                    <div>
                        <h3 class="font-black text-slate-900">
                            صورة النبات
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-slate-500">
                            ارفع صورة واضحة للأوراق أو الثمار.
                        </p>
                    </div>
                </div>

                <label for="image" class="input-label">
                    ملف الصورة
                </label>

                <input
                    id="image"
                    type="file"
                    name="image"
                    accept="image/*"
                    class="input-control"
                >

                <p class="mt-2 text-xs text-slate-500">
                    الصيغ المدعومة: JPG وPNG — الحد الأعلى 5 ميجابايت.
                </p>

                <div
                    id="image-preview-container"
                    class="mt-5 hidden rounded-2xl border border-green-200 bg-white p-3"
                >
                    <p class="mb-3 text-sm font-bold text-green-800">
                        معاينة الصورة المختارة
                    </p>

                    <img
                        id="image-preview"
                        src=""
                        alt="معاينة صورة النبات"
                        class="max-h-72 w-full rounded-xl object-contain"
                    >
                </div>
            </div>

            <div
                id="soil-section"
                class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-5"
            >
                <div class="mb-5 flex items-start gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-sm font-bold text-amber-800">
                        تربة
                    </div>

                    <div>
                        <h3 class="font-black text-slate-900">
                            بيانات التربة
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-slate-500">
                            أدخل القيم كما ظهرت في جهاز القياس أو التقرير.
                        </p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <label for="nitrogen" class="input-label">
                            النيتروجين
                        </label>

                        <input
                            id="nitrogen"
                            type="number"
                            step="0.001"
                            min="0"
                            name="nitrogen"
                            value="{{ old('nitrogen') }}"
                            class="input-control"
                            placeholder="مثال: 50"
                        >
                    </div>

                    <div>
                        <label for="phosphorus" class="input-label">
                            الفوسفور
                        </label>

                        <input
                            id="phosphorus"
                            type="number"
                            step="0.001"
                            min="0"
                            name="phosphorus"
                            value="{{ old('phosphorus') }}"
                            class="input-control"
                            placeholder="مثال: 30"
                        >
                    </div>

                    <div>
                        <label for="potassium" class="input-label">
                            البوتاسيوم
                        </label>

                        <input
                            id="potassium"
                            type="number"
                            step="0.001"
                            min="0"
                            name="potassium"
                            value="{{ old('potassium') }}"
                            class="input-control"
                            placeholder="مثال: 50"
                        >
                    </div>

                    <div>
                        <label for="ph" class="input-label">
                            درجة الحموضة pH
                        </label>

                        <input
                            id="ph"
                            type="number"
                            step="0.01"
                            min="0"
                            max="14"
                            name="ph"
                            value="{{ old('ph') }}"
                            class="input-control"
                            placeholder="مثال: 6.5"
                        >
                    </div>

                    <div>
                        <label for="moisture" class="input-label">
                            الرطوبة
                        </label>

                        <input
                            id="moisture"
                            type="number"
                            step="0.001"
                            min="0"
                            max="100"
                            name="moisture"
                            value="{{ old('moisture') }}"
                            class="input-control"
                            placeholder="مثال: 50"
                        >
                    </div>

                    <div>
                        <label for="temperature" class="input-label">
                            درجة الحرارة
                        </label>

                        <input
                            id="temperature"
                            type="number"
                            step="0.001"
                            name="temperature"
                            value="{{ old('temperature') }}"
                            class="input-control"
                            placeholder="مثال: 25"
                        >
                    </div>
                </div>
            </div>

            <div class="mt-8 flex flex-col justify-between gap-4 border-t border-slate-100 pt-6 sm:flex-row sm:items-center">
                <p class="text-sm leading-6 text-slate-500">
                    النتيجة إرشادية أولية ولا تغني عن الاستشارة الزراعية المتخصصة.
                </p>

                <button
                    type="submit"
                    class="primary-button"
                >
                    تنفيذ التشخيص
                    <span class="mr-2">←</span>
                </button>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        const operationType = document.getElementById('operation_type');
        const imageSection = document.getElementById('image-section');
        const soilSection = document.getElementById('soil-section');

        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const imagePreviewContainer = document.getElementById('image-preview-container');

        function updateSections() {
            const selectedType = operationType.value;

            const showImage =
                selectedType === 'image' ||
                selectedType === 'combined';

            const showSoil =
                selectedType === 'soil' ||
                selectedType === 'combined';

            imageSection.classList.toggle('hidden', !showImage);
            soilSection.classList.toggle('hidden', !showSoil);
        }

        operationType.addEventListener('change', updateSections);

        imageInput.addEventListener('change', function (event) {
            const file = event.target.files?.[0];

            if (!file) {
                imagePreviewContainer.classList.add('hidden');
                imagePreview.removeAttribute('src');

                return;
            }

            imagePreview.src = URL.createObjectURL(file);
            imagePreviewContainer.classList.remove('hidden');
        });

        updateSections();
    </script>
@endpush
