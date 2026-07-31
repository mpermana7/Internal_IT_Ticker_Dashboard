<div x-data="{
        show: false,
        message: '{{ session('message') ? addslashes(session('message')) : '' }}',
        type: '{{ session('type') ?? 'success' }}',
        timer: null,
        init() {
            if (this.message && this.message.trim() !== '') {
                this.trigger(this.message, this.type);
            }
            window.addEventListener('notify', (e) => {
                this.parseAndTrigger(e.detail);
            });
            if (window.Livewire) {
                Livewire.on('notify', (data) => {
                    this.parseAndTrigger(data);
                });
            }
        },
        parseAndTrigger(data) {
            if (!data) return;
            let msg = '';
            let t = 'success';
            if (typeof data === 'string') {
                msg = data;
            } else if (Array.isArray(data) && data.length > 0) {
                let first = data[0];
                msg = typeof first === 'string' ? first : (first.message || first[0] || '');
                t = first.type || 'success';
            } else if (typeof data === 'object') {
                msg = data.message || data[0] || '';
                t = data.type || 'success';
            }
            if (msg) {
                this.trigger(msg, t);
            }
        },
        trigger(msg, type = 'success') {
            this.message = msg;
            this.type = type;
            this.show = true;
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                this.show = false;
            }, 5000);
        }
    }"
    @notify.window="parseAndTrigger($event.detail)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="opacity-0 translate-y-[-20px] scale-90"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
    x-transition:leave-end="opacity-0 translate-y-[-20px] scale-90"
    class="fixed top-6 right-6 z-[200] max-w-md w-full px-4 sm:px-0 pointer-events-none"
    style="display: none;">

    <div class="neu-flat p-4 backdrop-blur-2xl rounded-2xl shadow-2xl border flex items-center justify-between gap-3.5 transition-all duration-300 pointer-events-auto"
        :class="{
            'bg-emerald-50 dark:bg-emerald-950/90 border-emerald-500/40 dark:border-emerald-600/80 text-emerald-950 dark:text-emerald-100 shadow-[0_10px_30px_rgba(16,185,129,0.25)]': type === 'success',
            'bg-amber-50 dark:bg-amber-950/90 border-amber-500/40 dark:border-amber-600/80 text-amber-950 dark:text-amber-100 shadow-[0_10px_30px_rgba(245,158,11,0.25)]': type === 'warning',
            'bg-rose-50 dark:bg-rose-950/90 border-rose-500/40 dark:border-rose-600/80 text-rose-950 dark:text-rose-100 shadow-[0_10px_30px_rgba(244,63,94,0.25)]': type === 'danger' || type === 'error'
        }">
        <div class="flex items-center gap-3 min-w-0">
            <!-- Icon container with matching theme pill badge -->
            <div class="w-10 h-10 rounded-xl neu-pressed flex items-center justify-center shrink-0 shadow-inner"
                :class="{
                    'text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/60': type === 'success',
                    'text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-900/60': type === 'warning',
                    'text-rose-600 dark:text-rose-400 bg-rose-100 dark:bg-rose-900/60': type === 'danger' || type === 'error'
                }">
                <template x-if="type === 'success'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </template>
                <template x-if="type === 'warning'">
                    <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                </template>
                <template x-if="type === 'danger' || type === 'error'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </template>
            </div>

            <div class="flex flex-col min-w-0">
                <span class="text-[10px] font-black uppercase tracking-wider opacity-75"
                    :class="{
                        'text-emerald-700 dark:text-emerald-300': type === 'success',
                        'text-amber-700 dark:text-amber-300': type === 'warning',
                        'text-rose-700 dark:text-rose-300': type === 'danger' || type === 'error'
                    }"
                    x-text="type === 'success' ? 'Sukses' : (type === 'warning' ? 'Diproses / Peringatan' : 'Hapus / Ditutup')"></span>
                <span class="text-xs font-extrabold leading-snug truncate" x-text="message"></span>
            </div>
        </div>

        <button type="button" @click="show = false" class="neu-button px-2 py-1.5 rounded-xl transition-colors shrink-0"
            :class="{
                'text-emerald-700 dark:text-emerald-300 hover:bg-emerald-200/50 dark:hover:bg-emerald-900/50': type === 'success',
                'text-amber-700 dark:text-amber-300 hover:bg-amber-200/50 dark:hover:bg-amber-900/50': type === 'warning',
                'text-rose-700 dark:text-rose-300 hover:bg-rose-200/50 dark:hover:bg-rose-900/50': type === 'danger' || type === 'error'
            }">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</div>
