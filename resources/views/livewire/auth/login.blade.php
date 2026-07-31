<div class="min-h-[85vh] flex items-center justify-center py-6">
    <div class="w-full max-w-lg">
        <!-- Brand Logo & Header -->
        <div class="text-center mb-6">
            <div class="w-16 h-16 neu-flat flex items-center justify-center mx-auto mb-3.5 text-indigo-600 dark:text-indigo-400">
                <svg class="w-9 h-9 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 002-2H5zm0 10a2 2 0 00-2 2v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 00-2-2H5z" />
                </svg>
            </div>
            <h2 class="text-2xl font-black text-slate-800 dark:text-white font-display tracking-tight">{{ __('IT Desk Command') }}</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 font-semibold mt-1">{{ __('Internal IT Ticket Dashboard') }} &bull; {{ __('Sign In') }}</p>
        </div>

        <!-- 3D Embossed Neumorphic Login Card -->
        <div class="neu-flat p-7 sm:p-8">
            <form wire:submit.prevent="login" class="space-y-4">
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wider">{{ __('Email Address') }}</label>
                    <input type="email" wire:model="email" placeholder="name@company.com" class="neu-input w-full px-4 py-3 text-xs font-semibold">
                    @error('email') <span class="text-rose-600 dark:text-rose-400 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wider">{{ __('Password') }}</label>
                    <input type="password" wire:model="password" placeholder="••••••••" class="neu-input w-full px-4 py-3 text-xs font-semibold">
                    @error('password') <span class="text-rose-600 dark:text-rose-400 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Neumorphic Checkbox & Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="inline-flex items-center gap-2.5 cursor-pointer select-none">
                        <input type="checkbox" wire:model="remember" class="neu-checkbox">
                        <span class="text-xs text-slate-700 dark:text-slate-300 font-extrabold">{{ __('Remember Me') }}</span>
                    </label>
                </div>

                <button type="submit" class="neu-button-primary w-full py-3.5 text-xs font-black uppercase tracking-wider shadow-lg">
                    {{ __('Sign In to Dashboard') }}
                </button>
            </form>

            <!-- Demo Accounts Section with 100% 3D Emboss Style -->
            <div class="mt-7 pt-5 border-t border-slate-300/40 dark:border-slate-800">
                <div class="text-center mb-3">
                    <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-indigo-700 dark:text-indigo-400 uppercase tracking-wider neu-pressed px-3 py-1">
                        {{ __('Quick Live Demo - 1-Click Login') }}
                    </span>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold mt-1">{{ __('Klik akun di bawah untuk mengisi form login secara otomatis:') }}</p>
                </div>

                <div class="grid grid-cols-3 gap-2.5">
                    <!-- IT Admin -->
                    <button type="button" wire:click="fillAccount('admin@it.local')" class="neu-flat-sm p-3 text-center flex flex-col items-center justify-between hover:scale-[1.02] transition-all">
                        <div class="w-8 h-8 neu-pressed rounded-xl flex items-center justify-center text-sm mb-1.5 shrink-0">
                            👑
                        </div>
                        <div class="w-full">
                            <div class="text-xs font-black text-slate-800 dark:text-white leading-tight">IT Admin</div>
                            <div class="text-[9px] font-mono font-bold text-indigo-600 dark:text-indigo-400 truncate mt-0.5" title="admin@it.local">
                                admin@it.local
                            </div>
                        </div>
                        <span class="mt-2.5 neu-button w-full py-1 text-[9px] font-black text-indigo-700 dark:text-indigo-400 uppercase tracking-tight block">
                            {{ __('Klik Disini') }}
                        </span>
                    </button>

                    <!-- Technician -->
                    <button type="button" wire:click="fillAccount('budi@it.local')" class="neu-flat-sm p-3 text-center flex flex-col items-center justify-between hover:scale-[1.02] transition-all">
                        <div class="w-8 h-8 neu-pressed rounded-xl flex items-center justify-center text-sm mb-1.5 shrink-0">
                            🛠️
                        </div>
                        <div class="w-full">
                            <div class="text-xs font-black text-slate-800 dark:text-white leading-tight">Technician</div>
                            <div class="text-[9px] font-mono font-bold text-blue-600 dark:text-blue-400 truncate mt-0.5" title="budi@it.local">
                                budi@it.local
                            </div>
                        </div>
                        <span class="mt-2.5 neu-button w-full py-1 text-[9px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-tight block">
                            {{ __('Klik Disini') }}
                        </span>
                    </button>

                    <!-- User -->
                    <button type="button" wire:click="fillAccount('andri@company.com')" class="neu-flat-sm p-3 text-center flex flex-col items-center justify-between hover:scale-[1.02] transition-all">
                        <div class="w-8 h-8 neu-pressed rounded-xl flex items-center justify-center text-sm mb-1.5 shrink-0">
                            👤
                        </div>
                        <div class="w-full">
                            <div class="text-xs font-black text-slate-800 dark:text-white leading-tight">User</div>
                            <div class="text-[9px] font-mono font-bold text-emerald-600 dark:text-emerald-400 truncate mt-0.5" title="andri@company.com">
                                andri@company.com
                            </div>
                        </div>
                        <span class="mt-2.5 neu-button w-full py-1 text-[9px] font-black text-emerald-700 dark:text-emerald-400 uppercase tracking-tight block">
                            {{ __('Klik Disini') }}
                        </span>
                    </button>
                </div>

                <!-- Footer Password Default Pill -->
                <div class="mt-4 text-center">
                    <span class="neu-pressed px-3.5 py-1 text-[10px] text-slate-500 dark:text-slate-400 font-bold inline-block">
                        {{ __('Password default:') }} <code class="font-mono text-indigo-600 dark:text-indigo-400 font-bold">password</code>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
