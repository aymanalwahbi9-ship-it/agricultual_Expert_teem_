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
        <header class="site-header">
            <div class="container-page">
                <div class="flex min-h-20 items-center justify-between gap-4 py-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-600 to-green-700 text-2xl font-black text-white shadow-lg shadow-emerald-200">
                            ز
                        </span>

                        <span>
                            <span class="block text-lg font-black text-slate-900">
                                الخبير الزراعي
                            </span>

                            <span class="block text-xs text-slate-500">
                                مساعد للإرشاد الزراعي
                            </span>
                        </span>
                    </a>

                    <span class="hidden rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-800 lg:inline-flex">
                        نظام محلي ومحاكاة تعليمية
                    </span>
                </div>

                <nav aria-label="التنقل الرئيسي" class="flex flex-wrap items-center gap-2 pb-4 text-sm font-bold">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        الرئيسية
                    </a>

                    <a href="{{ route('diagnosis.create') }}" class="nav-link {{ request()->routeIs('diagnosis.*') ? 'active' : '' }}">
                        التشخيص
                    </a>

                    <a href="{{ route('knowledge.index') }}" class="nav-link {{ request()->routeIs('knowledge.*') ? 'active' : '' }}">
                        البحث في المعرفة
                    </a>

                    <a href="{{ route('history.index') }}" class="nav-link {{ request()->routeIs('history.*') ? 'active' : '' }}">
                        سجل العمليات
                    </a>

                    <a href="#about-system" class="nav-link">
                        عن النظام
                    </a>
                </nav>
            </div>
        </header>

        <main class="container-page py-8 sm:py-12">
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>

        <footer id="about-system" class="border-t border-slate-200 bg-white/80">
            <div class="container-page py-8 text-center text-sm leading-7 text-slate-500">
                <p class="font-black text-slate-800">
                    نظام الخبير الزراعي
                </p>

                <p>
                    أداة تعليمية مساعدة تعتمد على بيانات التربة، قاعدة المعرفة، والمحاكاة المحلية.
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
