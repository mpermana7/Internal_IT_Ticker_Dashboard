<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? __('Internal IT Ticket Dashboard') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Initial Theme Script to prevent flash -->
    <script>
        if (localStorage.getItem('neu-theme') === 'dark' || (!('neu-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Neumorphism 3D Emboss CSS System (Light & Dark Mode CSS Variables) -->
    <style>
        :root {
            --neu-bg: #e6eef8;
            --neu-shadow-dark: #b8c4d9;
            --neu-shadow-light: #ffffff;
            --neu-text: #2d3748;
        }

        html.dark {
            --neu-bg: #141b27;
            --neu-shadow-dark: #0b0e15;
            --neu-shadow-light: #1d2739;
            --neu-text: #f1f5f9;
        }

        body {
            background-color: var(--neu-bg);
            color: var(--neu-text);
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .font-display {
            font-family: 'Outfit', sans-serif;
        }

        /* 3D EMBOSSED FLAT CARD SURFACE */
        .neu-flat {
            background-color: var(--neu-bg) !important;
            box-shadow: 10px 10px 20px var(--neu-shadow-dark), -10px -10px 20px var(--neu-shadow-light) !important;
            border-radius: 20px;
        }

        .neu-flat-sm {
            background-color: var(--neu-bg) !important;
            box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light) !important;
            border-radius: 14px;
        }

        /* 3D INSET / PRESSED SURFACE */
        .neu-pressed {
            background-color: var(--neu-bg) !important;
            box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light) !important;
            border-radius: 14px;
        }

        .neu-pressed-sm {
            background-color: var(--neu-bg) !important;
            box-shadow: inset 2.5px 2.5px 5px var(--neu-shadow-dark), inset -2.5px -2.5px 5px var(--neu-shadow-light) !important;
            border-radius: 10px;
        }

        /* 3D EMBOSSED BUTTONS */
        .neu-button {
            background-color: var(--neu-bg) !important;
            box-shadow: 6px 6px 12px var(--neu-shadow-dark), -6px -6px 12px var(--neu-shadow-light) !important;
            border-radius: 14px;
            color: var(--neu-text);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .neu-button:hover {
            box-shadow: 8px 8px 16px var(--neu-shadow-dark), -8px -8px 16px var(--neu-shadow-light) !important;
            transform: translateY(-1px);
        }

        .neu-button:active {
            box-shadow: inset 4px 4px 8px var(--neu-shadow-dark), inset -4px -4px 8px var(--neu-shadow-light) !important;
            transform: translateY(0);
        }

        /* PRIMARY EMBOSSED ACCENT BUTTON */
        .neu-button-primary {
            background: linear-gradient(145deg, #5356ff, #3730a3) !important;
            box-shadow: 7px 7px 14px var(--neu-shadow-dark), -7px -7px 14px var(--neu-shadow-light) !important;
            color: #ffffff !important;
            border-radius: 14px;
            transition: all 0.2s ease;
        }

        .neu-button-primary:hover {
            box-shadow: 9px 9px 18px var(--neu-shadow-dark), -9px -9px 18px var(--neu-shadow-light) !important;
            background: linear-gradient(145deg, #4f46e5, #312e81) !important;
        }

        .neu-button-primary:active {
            box-shadow: inset 4px 4px 8px #1e1b4b, inset -4px -4px 8px #6366f1 !important;
        }

        /* DANGER EMBOSSED BUTTON */
        .neu-button-danger {
            background-color: var(--neu-bg) !important;
            box-shadow: 5px 5px 10px var(--neu-shadow-dark), -5px -5px 10px var(--neu-shadow-light) !important;
            color: #f43f5e !important;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        /* 3D INSET INPUTS & TEXTAREAS */
        .neu-input {
            background-color: var(--neu-bg) !important;
            box-shadow: inset 3.5px 3.5px 7px var(--neu-shadow-dark), inset -3.5px -3.5px 7px var(--neu-shadow-light) !important;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 14px;
            color: var(--neu-text) !important;
            transition: all 0.25s ease;
        }

        html.dark .neu-input::placeholder {
            color: #64748b;
        }

        .neu-input:focus {
            outline: none;
            box-shadow: inset 5px 5px 10px var(--neu-shadow-dark), inset -5px -5px 10px var(--neu-shadow-light) !important;
            border-color: #6366f1 !important;
        }

        /* 3D NEUMORPHIC EMBOSS SELECT & OPTION MENU STYLING */
        select.neu-input, select {
            background-color: var(--neu-bg) !important;
            color: var(--neu-text) !important;
            border-radius: 14px !important;
            outline: none !important;
            cursor: pointer;
        }

        select option {
            background-color: var(--neu-bg) !important;
            color: var(--neu-text) !important;
            padding: 12px 16px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
        }

        html.dark select option {
            background-color: #141b27 !important;
            color: #f1f5f9 !important;
        }

        html.dark select option:hover,
        html.dark select option:focus,
        html.dark select option:active,
        html.dark select option:checked {
            background-color: #1e293b !important;
            color: #818cf8 !important;
        }

        html:not(.dark) select option {
            background-color: #e6eef8 !important;
            color: #1e293b !important;
        }

        html:not(.dark) select option:hover,
        html:not(.dark) select option:focus,
        html:not(.dark) select option:active,
        html:not(.dark) select option:checked {
            background-color: #cbd5e1 !important;
            color: #4f46e5 !important;
        }

        /* BADGES */
        .neu-badge {
            box-shadow: 3px 3px 6px var(--neu-shadow-dark), -3px -3px 6px var(--neu-shadow-light) !important;
            border-radius: 9999px;
            font-weight: 700;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.375rem !important;
            white-space: nowrap !important;
        }

        /* NEUMORPHIC CHECKBOX */
        .neu-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 22px;
            height: 22px;
            background-color: var(--neu-bg) !important;
            box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light) !important;
            border-radius: 7px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            cursor: pointer;
            position: relative;
            outline: none;
            transition: all 0.2s ease;
            display: inline-block;
            flex-shrink: 0;
        }

        .neu-checkbox:checked {
            background: linear-gradient(145deg, #5356ff, #4338ca) !important;
            box-shadow: 3px 3px 6px var(--neu-shadow-dark), -3px -3px 6px var(--neu-shadow-light) !important;
        }

        .neu-checkbox:checked::after {
            content: '✓';
            position: absolute;
            color: #ffffff;
            font-size: 13px;
            font-weight: 900;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        html.dark aside {
            background-color: #141b27;
            border-color: rgba(255, 255, 255, 0.05);
        }
    </style>
    @livewireStyles
</head>
<body class="min-h-screen antialiased">

    @auth
        <!-- Authenticated Layout -->
        <div class="min-h-screen flex flex-col md:flex-row">
            <!-- Sidebar -->
            <aside class="w-full md:w-72 bg-[#e6eef8] p-6 border-b md:border-b-0 md:border-r border-slate-300/40 shrink-0 flex flex-col justify-between">
                <div>
                    <!-- Header Logo -->
                    <div class="neu-flat p-4 mb-8 flex items-center gap-3.5">
                        <div class="w-11 h-11 neu-pressed flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-black text-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 002-2H5zm0 10a2 2 0 00-2 2v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="font-display font-extrabold text-base text-slate-800 dark:text-white tracking-tight leading-none">{{ __('IT Desk Command') }}</h1>
                            <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 tracking-wider uppercase mt-1 inline-block">{{ __('Enterprise Dashboard') }}</span>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="space-y-4">
                        <a href="{{ route('dashboard') }}" class="neu-button px-4 py-3.5 flex items-center gap-3.5 text-xs font-bold transition-all {{ request()->routeIs('dashboard') ? 'neu-pressed text-indigo-600 border-l-4 border-indigo-600' : 'text-slate-600 dark:text-slate-300 hover:text-indigo-600' }}">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            {{ __('Dashboard Overview') }}
                        </a>

                        <a href="{{ route('tickets.index') }}" class="neu-button px-4 py-3.5 flex items-center gap-3.5 text-xs font-bold transition-all {{ request()->routeIs('tickets.*') ? 'neu-pressed text-indigo-600 border-l-4 border-indigo-600' : 'text-slate-600 dark:text-slate-300 hover:text-indigo-600' }}">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            {{ __('Ticket Management') }}
                        </a>

                        @if(auth()->user()?->isAdmin())
                        <a href="{{ route('categories.index') }}" class="neu-button px-4 py-3.5 flex items-center gap-3.5 text-xs font-bold transition-all {{ request()->routeIs('categories.*') ? 'neu-pressed text-indigo-600 border-l-4 border-indigo-600' : 'text-slate-600 dark:text-slate-300 hover:text-indigo-600' }}">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M11 7h8M11 11h8M11 15h8" />
                            </svg>
                            {{ __('Service Categories') }}
                        </a>
                        @endif
                    </nav>
                </div>

                <!-- User Profile & Logout -->
                <div class="mt-8 neu-flat p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 neu-pressed rounded-full text-indigo-600 dark:text-indigo-400 font-black flex items-center justify-center text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-xs text-slate-800 dark:text-white truncate">{{ auth()->user()->name }}</h4>
                            <span class="text-[10px] text-indigo-600 dark:text-indigo-400 font-extrabold block uppercase tracking-wider">{{ auth()->user()->role }}</span>
                        </div>
                    </div>
                    <a href="{{ route('logout') }}" class="neu-button-danger w-full py-2 text-center text-xs font-bold block uppercase tracking-wider">
                        {{ __('Log Out') }}
                    </a>
                </div>
            </aside>

            <!-- Main Region -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Top Navbar Header with Theme & Language Switchers -->
                <header class="p-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="neu-pressed px-4 py-2 text-xs font-bold text-indigo-700 dark:text-indigo-400">
                            MySQL &bull; {{ app()->getLocale() == 'id' ? 'Bahasa Indonesia 🇮🇩' : 'English 🇬🇧' }}
                        </span>
                    </div>

                    <!-- Top Controls: Theme Switcher & Language Switcher -->
                    <x-utility-dock />
                </header>

                <main class="p-6 md:p-8 flex-1 max-w-7xl w-full mx-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>
    @else
        <!-- Guest Layout (Login Page) with Fixed Top-Right Utility Dock -->
        <div class="min-h-screen flex items-center justify-center relative p-6">
            <!-- Modern Ergonomic Fixed Utility Dock -->
            <div class="fixed top-5 right-5 z-50">
                <x-utility-dock />
            </div>

            <!-- Login Page Content -->
            <main class="w-full max-w-lg mx-auto">
                {{ $slot }}
            </main>
        </div>
    @endauth

    <script>
        function updateThemeUI() {
            const isDark = document.documentElement.classList.contains('dark');
            document.querySelectorAll('.neu-theme-label').forEach(labelEl => {
                if (labelEl) {
                    labelEl.textContent = isDark ? '{{ __('Light Mode') }}' : '{{ __('Dark Mode') }}';
                }
            });
        }

        function toggleNeuTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('neu-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('neu-theme', 'dark');
            }
            updateThemeUI();
        }

        document.addEventListener('DOMContentLoaded', updateThemeUI);
    </script>

    <!-- Global 3D Neumorphic Floating Toast Component -->
    <x-neu-toast />

    @livewireScripts
</body>
</html>
