<div class="flex items-center gap-3 neu-flat p-1.5 px-3 backdrop-blur-md rounded-2xl">
    <!-- Language Switcher -->
    <div class="flex items-center neu-pressed p-1 gap-1 rounded-xl">
        <a href="{{ route('lang.switch', 'id') }}" class="px-2.5 py-1 text-xs font-black rounded-lg transition-all {{ app()->getLocale() == 'id' ? 'neu-button text-indigo-600 dark:text-indigo-400' : 'text-slate-500 hover:text-slate-800 dark:text-slate-400' }}" title="Bahasa Indonesia">
            🇮🇩 ID
        </a>
        <a href="{{ route('lang.switch', 'en') }}" class="px-2.5 py-1 text-xs font-black rounded-lg transition-all {{ app()->getLocale() == 'en' ? 'neu-button text-indigo-600 dark:text-indigo-400' : 'text-slate-500 hover:text-slate-800 dark:text-slate-400' }}" title="English">
            🇬🇧 EN
        </a>
    </div>

    <!-- Theme Switcher -->
    <button onclick="toggleNeuTheme()" class="neu-button px-3 py-1.5 text-xs font-bold flex items-center gap-2 group transition-all duration-300 rounded-xl" title="Toggle Light/Dark Theme">
        <div class="relative w-6 h-6 flex items-center justify-center rounded-lg neu-pressed-sm bg-gradient-to-br from-amber-500/10 to-orange-500/10 dark:from-indigo-500/20 dark:to-purple-500/20 text-amber-500 dark:text-indigo-400 group-hover:scale-110 transition-transform duration-300">
            <!-- Sun Icon (Active in Dark mode to switch to Light) -->
            <svg class="w-4 h-4 transition-all duration-500 transform dark:rotate-0 dark:scale-100 dark:opacity-100 -rotate-90 scale-0 opacity-0 absolute filter drop-shadow-[0_0_8px_rgba(251,191,36,0.7)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="4" class="fill-amber-400/20"></circle>
                <path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M4.93 19.07l1.41-1.41m11.32-11.32l1.41-1.41"></path>
            </svg>
            <!-- Moon Icon (Active in Light mode to switch to Dark) -->
            <svg class="w-4 h-4 transition-all duration-500 transform dark:rotate-90 dark:scale-0 dark:opacity-0 rotate-0 scale-100 opacity-100 absolute filter drop-shadow-[0_0_8px_rgba(129,140,248,0.7)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" class="fill-indigo-400/20"></path>
                <circle cx="17" cy="8" r="1" class="fill-indigo-400 stroke-none"></circle>
            </svg>
        </div>
        <span class="neu-theme-label hidden sm:inline font-semibold text-slate-700 dark:text-slate-200">
            {{ __('Dark Mode') }}
        </span>
    </button>
</div>
