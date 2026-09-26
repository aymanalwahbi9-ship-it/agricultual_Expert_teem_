@extends('layouts.app')

@section('title', 'سجل العمليات')

@section('content')
    <div class="mb-8">
        <span class="section-tag bg-emerald-100 text-emerald-800">
            سجل المستخدم
        </span>

        <h1 class="section-title mt-4">
            العمليات السابقة
        </h1>

        <p class="section-copy">
            هنا تظهر عمليات تحليل الصورة وتحليل التربة التي تم تنفيذها.
        </p>
    </div>

    @if ($records->isEmpty())
        <section class="info-banner border-amber-200 bg-gradient-to-r from-amber-50 to-orange-50">
            <h2 class="text-xl font-black text-amber-950">
                لا توجد عمليات محفوظة
            </h2>

            <p class="mt-3 leading-7 text-amber-900">
                عند تنفيذ أول عملية تشخيص ستظهر تفاصيلها هنا.
            </p>

            <a href="{{ route('diagnosis.create') }}" class="primary-button mt-5">
                بدء أول تشخيص
            </a>
        </section>
    @else
        <div class="grid gap-5">
            @foreach ($records as $record)
                <article class="card">
                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                        <div>
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-black text-emerald-800">
                                @switch($record->operation_type)
                                    @case('image')
                                        تحليل صورة
                                        @break

                                    @case('soil')
                                        تحليل تربة
                                        @break

                                    @case('combined')
                                        تحليل مدمج
                                        @break

                                    @default
                                        عملية زراعية
                                @endswitch
                            </span>

                            <h2 class="mt-4 text-xl font-black text-slate-900">
                                {{ $record->summary_ar }}
                            </h2>
                        </div>

                        <div class="text-sm font-bold text-slate-500">
                            {{ $record->occurred_at?->format('Y-m-d H:i') }}
                        </div>
                    </div>

                    @if ($record->diagnosisCase?->crop)
                        <p class="mt-4 text-sm text-slate-600">
                            المحصول:
                            <strong class="text-slate-900">
                                {{ $record->diagnosisCase->crop->name_ar }}
                            </strong>
                        </p>
                    @endif
                </article>
            @endforeach
        </div>
    @endif
@endsection
