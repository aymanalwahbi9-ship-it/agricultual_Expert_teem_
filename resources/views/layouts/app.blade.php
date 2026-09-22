<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'الخبير الزراعي')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="page-shell">
        <header class="border-b border-green-900/20 bg-green-900 text-white">
            <div class="container-page">
                <div class="flex min-h-20 items-center justify-between gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/15 text-2xl">
                            ز
                        </span>

                        <span>
                            <span class="block text-lg font-black">
                                الخبير الزراعي
                            </span>

                            <span class="block text-xs text-green-100">
                                مساعد للإرشاد الزراعي
                            </span>
                        </span>
                    </a>

                    <span class="hidden rounded-full bg-white/10 px-4 py-2 text-sm text-green-100 lg:inline-flex">
                        نظام محلي ومحاكاة تعليمية
                    </span>
                </div>

                <nav
                    aria-label="التنقل الرئيسي"
                    class="flex flex-wrap items-center gap-2 border-t border-white/10 py-3 text-sm font-bold"
                >
                    <a
                        href="{{ route('home') }}"
                        class="rounded-xl px-4 py-2 text-green-50 transition hover:bg-white/10"
                    >
                        الرئيسية
                    </a>

                    <a
                        href="{{ route('diagnosis.create') }}"
                        class="rounded-xl px-4 py-2 text-green-50 transition hover:bg-white/10"
                    >
                        التشخيص
                    </a>

                    <a
                        href="{{ route('knowledge.index') }}"
                        class="rounded-xl px-4 py-2 text-green-50 transition hover:bg-white/10"
                    >
                        البحث في المعرفة
                    </a>

                    <a
                        href="{{ route('history.index') }}"
                        class="rounded-xl px-4 py-2 text-green-50 transition hover:bg-white/10"
                    >
                        سجل العمليات
                    </a>

                    <a
                        href="#about-system"
                        class="rounded-xl px-4 py-2 text-green-50 transition hover:bg-white/10"
                    >
                        عن النظام
                    </a>
                </nav>
            </div>
        </header>

        <main class="container-page py-8 sm:py-12">
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>

        <footer
            id="about-system"
            class="border-t border-slate-200 bg-white/70"
        >
            <div class="container-page py-6 text-center text-sm leading-7 text-slate-500">
                <p class="font-bold text-slate-700">
                    نظام الخبير الزراعي
                </p>

                <p>
                    أداة تعليمية مساعدة تعتمد على بيانات التربة وقاعدة المعرفة والمحاكاة المحلية.
                </p>

                <p>
                    النتائج إرشادية ولا تغني عن استشارة المهندس الزراعي أو التحليل المخبري.
                </p>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
