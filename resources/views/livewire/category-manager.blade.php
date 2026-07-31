<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800 dark:text-white font-display">{{ __('Service Categories') }}</h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs mt-1 font-medium">{{ __('Manage IT Infrastructure Ticket Categories & Service Desk Scopes') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Add Category Form -->
        <div class="neu-flat p-6 h-fit">
            <h3 class="text-base font-extrabold text-slate-800 dark:text-white font-display mb-4">{{ __('Add New Category') }}</h3>
            <form wire:submit.prevent="createCategory" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('Category Name') }} *</label>
                    <input type="text" wire:model="name" placeholder="Contoh: Cloud Infrastructure" class="neu-input w-full px-3.5 py-2.5 text-xs font-semibold">
                    @error('name') <span class="text-rose-600 dark:text-rose-400 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('Description') }}</label>
                    <textarea wire:model="description" rows="3" placeholder="{{ __('Tulis deskripsi singkat...') }}" class="neu-input w-full px-3.5 py-2.5 text-xs font-semibold"></textarea>
                    @error('description') <span class="text-rose-600 dark:text-rose-400 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="neu-button-primary w-full py-3 text-xs font-bold uppercase cursor-pointer">
                    {{ __('Save Category') }}
                </button>
            </form>
        </div>

        <!-- Categories List -->
        <div class="lg:col-span-2 neu-flat p-6">
            <h3 class="text-base font-extrabold text-slate-800 dark:text-white font-display mb-4">{{ __('Existing Categories') }}</h3>
            <div class="space-y-4">
                @foreach ($categories as $cat)
                    <div class="neu-flat-sm p-4 flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-slate-800 dark:text-slate-100 text-sm">{{ $cat->name }}</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">{{ $cat->description }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="neu-badge px-3 py-1 text-xs text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-950/60 font-bold">
                                {{ $cat->tickets_count }} {{ __('Tickets') }}
                            </span>
                            <button wire:click="openDeleteModal({{ $cat->id }})" class="neu-button-danger p-2.5 text-rose-600 hover:text-rose-700 transition-all rounded-xl cursor-pointer flex items-center justify-center shrink-0" title="{{ __('Hapus Kategori') }}">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Delete Category Modal -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div class="neu-flat w-full max-w-md p-6 bg-[#e6eef8] dark:bg-[#141b27] relative border border-white/60 dark:border-slate-800 text-center">
                <div class="w-12 h-12 neu-pressed rounded-full text-rose-600 flex items-center justify-center mx-auto mb-4 font-black text-xl">
                    <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h3 class="font-display font-extrabold text-lg text-slate-800 dark:text-white mb-2">{{ __('Konfirmasi Hapus Kategori') }}</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 mb-6 font-medium">{{ __('Apakah Anda yakin ingin menghapus kategori layanan ini?') }}</p>

                <div class="flex items-center justify-center gap-4">
                    <button type="button" wire:click="closeDeleteModal" class="neu-button px-5 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 cursor-pointer">{{ __('Batal') }}</button>
                    <button type="button" wire:click="deleteCategory" class="neu-button-danger px-6 py-2.5 text-xs font-bold uppercase cursor-pointer">{{ __('Ya, Hapus Kategori') }}</button>
                </div>
            </div>
        </div>
    @endif
</div>
