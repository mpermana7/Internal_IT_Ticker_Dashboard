<div>
    <!-- Back Button & Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('dashboard') }}" class="text-xs text-indigo-600 dark:text-indigo-400 font-bold hover:underline flex items-center gap-1 mb-2">
                {{ __('Back to Dashboard Overview') }}
            </a>
            <div class="flex items-center gap-3">
                <span class="font-mono font-black text-xl text-indigo-700 dark:text-indigo-400 neu-pressed px-3 py-1">{{ $ticket->ticket_number }}</span>
                <span class="neu-badge px-3 py-1 text-xs font-bold text-slate-700 dark:text-slate-300 bg-slate-200 dark:bg-slate-800">
                    {{ $ticket->category->name }}
                </span>
            </div>
            <h1 class="text-2xl font-black text-slate-800 dark:text-white font-display mt-2">{{ $ticket->title }}</h1>
        </div>

        <!-- Neumorphic Status Pills (Card View) -->
        @if(!auth()->user()?->isUser())
        <div class="flex items-center gap-2 neu-flat p-2 rounded-2xl">
            <button wire:click="confirmStatusChange('open')" class="px-4 py-2 text-xs font-bold transition-all rounded-xl cursor-pointer {{ $ticket->status === 'open' ? 'neu-pressed text-amber-600 dark:text-amber-400 font-black border-l-4 border-amber-500 shadow-inner' : 'neu-button text-slate-600 dark:text-slate-300' }}">
                {{ __('Open') }}
            </button>
            <button wire:click="confirmStatusChange('in_progress')" class="px-4 py-2 text-xs font-bold transition-all rounded-xl cursor-pointer {{ $ticket->status === 'in_progress' ? 'neu-pressed text-blue-600 dark:text-blue-400 font-black border-l-4 border-blue-500 shadow-inner' : 'neu-button text-slate-600 dark:text-slate-300' }}">
                {{ __('In Progress') }}
            </button>
            <button wire:click="confirmStatusChange('resolved')" class="px-4 py-2 text-xs font-bold transition-all rounded-xl cursor-pointer {{ $ticket->status === 'resolved' ? 'neu-pressed text-emerald-600 dark:text-emerald-400 font-black border-l-4 border-emerald-500 shadow-inner' : 'neu-button text-slate-600 dark:text-slate-300' }}">
                {{ __('Resolved') }}
            </button>
            <button wire:click="confirmStatusChange('closed')" class="px-4 py-2 text-xs font-bold transition-all rounded-xl cursor-pointer {{ $ticket->status === 'closed' ? 'neu-pressed text-slate-700 dark:text-slate-300 font-black border-l-4 border-slate-500 shadow-inner' : 'neu-button text-slate-600 dark:text-slate-300' }}">
                {{ __('Closed') }}
            </button>
        </div>
        @else
        <!-- Read-only Status Badge for User Role -->
        <div class="neu-flat px-4 py-2.5 rounded-2xl flex items-center gap-2">
            @if ($ticket->status === 'open')
                <span class="w-3 h-3 rounded-full bg-amber-500 animate-pulse"></span>
                <span class="font-extrabold text-xs text-amber-600 dark:text-amber-400 uppercase tracking-wider">{{ __('Open') }}</span>
            @elseif ($ticket->status === 'in_progress')
                <span class="w-3 h-3 rounded-full bg-blue-500 animate-pulse"></span>
                <span class="font-extrabold text-xs text-blue-600 dark:text-blue-400 uppercase tracking-wider">{{ __('In Progress') }}</span>
            @elseif ($ticket->status === 'resolved')
                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                <span class="font-extrabold text-xs text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">{{ __('Resolved') }}</span>
            @else
                <span class="w-3 h-3 rounded-full bg-slate-500"></span>
                <span class="font-extrabold text-xs text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ __('Closed') }}</span>
            @endif
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Conversation & Notes Thread -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Ticket Description Card -->
            <div class="neu-flat p-6">
                <h3 class="text-xs font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">{{ __('Original Ticket Issue Description') }}</h3>
                <p class="text-sm text-slate-800 dark:text-slate-200 leading-relaxed font-medium whitespace-pre-line">{{ $ticket->description }}</p>
                <div class="mt-4 pt-4 border-t border-slate-300 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-medium">
                    <span>{{ __('Submitted by') }} <strong class="text-slate-800 dark:text-white">{{ $ticket->user->name }}</strong> ({{ $ticket->user->department ?? __('Staff') }})</span>
                    <span>{{ $ticket->created_at->format('d M Y - H:i A') }}</span>
                </div>
            </div>

            <!-- Notes & Comments Thread -->
            <div class="neu-flat p-6">
                <h3 class="text-base font-extrabold text-slate-800 dark:text-white font-display mb-4">{{ __('Ticket Notes & Activity Log') }}</h3>

                <div class="space-y-4 mb-6">
                    @forelse ($ticket->comments as $comment)
                        <div class="p-4 rounded-xl {{ $comment->is_internal_note ? 'neu-pressed border-l-4 border-amber-500 bg-amber-50/50 dark:bg-amber-950/30' : 'neu-flat-sm' }}">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-xs text-slate-800 dark:text-slate-100">{{ $comment->user->name }}</span>
                                    <span class="neu-badge px-2 py-0.5 text-[10px] font-bold text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-950/60">
                                        {{ ucfirst($comment->user->role) }}
                                    </span>
                                    @if ($comment->is_internal_note)
                                        <span class="neu-badge px-2 py-0.5 text-[10px] font-extrabold text-amber-800 dark:text-amber-300 bg-amber-200 dark:bg-amber-900/80">
                                            {{ __('INTERNAL IT NOTE') }}
                                        </span>
                                    @endif
                                </div>
                                <span class="text-[10px] text-slate-400 dark:text-slate-400 font-semibold">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-700 dark:text-slate-300 font-medium leading-relaxed">{{ $comment->comment }}</p>
                        </div>
                    @empty
                        <div class="py-6 text-center text-xs text-slate-500 dark:text-slate-400 neu-pressed rounded-xl">
                            {{ __('No internal notes or comments logged yet.') }}
                        </div>
                    @endforelse
                </div>

                <!-- Add Note / Comment Form -->
                <form wire:submit.prevent="addComment" class="pt-4 border-t border-slate-300 dark:border-slate-800 space-y-4">
                    <div class="grid grid-cols-1 {{ (auth()->user()?->isTechnician() || auth()->user()?->isAdmin()) ? 'sm:grid-cols-2' : '' }} gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('Penulis / User') }}</label>
                            <div class="neu-pressed px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center justify-between">
                                <span>{{ auth()->user()?->name ?? 'Guest User' }}</span>
                                <span class="text-[10px] text-indigo-600 dark:text-indigo-400 font-extrabold uppercase">({{ ucfirst(auth()->user()?->role ?? 'User') }})</span>
                            </div>
                        </div>

                        @if(auth()->user()?->isTechnician() || auth()->user()?->isAdmin())
                        <div class="flex items-center pt-5">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="isInternalNote" class="neu-checkbox">
                                <span class="text-xs text-amber-700 dark:text-amber-400 font-bold">{{ __('Tandai sebagai Catatan Internal IT') }}</span>
                            </label>
                        </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('Write Note or Comment') }}</label>
                        <textarea wire:model="commentText" rows="3" placeholder="{{ __('Type internal note or update for this ticket...') }}" class="neu-input w-full px-3.5 py-2.5 text-xs font-medium"></textarea>
                        @error('commentText') <span class="text-rose-600 dark:text-rose-400 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="neu-button-primary px-6 py-2.5 text-xs font-bold uppercase cursor-pointer">
                            {{ __('Post Note / Comment') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="space-y-6">
            <div class="neu-flat p-6 space-y-4">
                <h3 class="text-sm font-extrabold text-slate-800 dark:text-white font-display border-b border-slate-300 dark:border-slate-800 pb-3">{{ __('Ticket Information') }}</h3>

                <div>
                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">{{ __('Status (Color Indicator)') }}</span>
                    <div class="mt-1 flex items-center gap-2">
                        @if ($ticket->status === 'open')
                            <span class="w-3 h-3 rounded-full bg-amber-500 animate-pulse"></span>
                            <span class="font-extrabold text-xs text-amber-700 dark:text-amber-400 uppercase">{{ __('Open') }}</span>
                        @elseif ($ticket->status === 'in_progress')
                            <span class="w-3 h-3 rounded-full bg-blue-500 animate-pulse"></span>
                            <span class="font-extrabold text-xs text-blue-700 dark:text-blue-400 uppercase">{{ __('In Progress') }}</span>
                        @elseif ($ticket->status === 'resolved')
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span class="font-extrabold text-xs text-emerald-700 dark:text-emerald-400 uppercase">{{ __('Resolved') }}</span>
                        @else
                            <span class="w-3 h-3 rounded-full bg-slate-500"></span>
                            <span class="font-extrabold text-xs text-slate-700 dark:text-slate-300 uppercase">{{ __('Closed') }}</span>
                        @endif
                    </div>
                </div>

                <div>
                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">{{ __('Priority') }}</span>
                    <div class="mt-1">
                        @if ($ticket->priority === 'urgent')
                            <span class="neu-badge inline-flex items-center gap-1.5 whitespace-nowrap px-3 py-1 text-xs text-rose-700 dark:text-rose-300 bg-rose-100 dark:bg-rose-950/50 border border-rose-300 dark:border-rose-800/60 font-extrabold uppercase"><span>🚨</span><span>{{ __('Urgent') }}</span></span>
                        @elseif ($ticket->priority === 'high')
                            <span class="neu-badge inline-flex items-center gap-1.5 whitespace-nowrap px-3 py-1 text-xs text-amber-700 dark:text-amber-300 bg-amber-100 dark:bg-amber-950/50 border border-amber-300 dark:border-amber-800/60 font-extrabold uppercase"><span>⚡</span><span>{{ __('High') }}</span></span>
                        @elseif ($ticket->priority === 'medium')
                            <span class="neu-badge inline-flex items-center gap-1.5 whitespace-nowrap px-3 py-1 text-xs text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-950/50 border border-blue-300 dark:border-blue-800/60 font-extrabold uppercase"><span>🔹</span><span>{{ __('Medium') }}</span></span>
                        @else
                            <span class="neu-badge inline-flex items-center gap-1.5 whitespace-nowrap px-3 py-1 text-xs text-slate-600 dark:text-slate-400 bg-slate-200 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 font-extrabold uppercase"><span>▫</span><span>{{ __('Low') }}</span></span>
                        @endif
                    </div>
                </div>

                <div>
                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">{{ __('Assigned Person') }}</span>
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block mt-0.5">
                        {{ $ticket->technician ? $ticket->technician->name : __('Unassigned') }}
                    </span>
                </div>

                <div>
                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">{{ __('Reporter User') }}</span>
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block mt-0.5">{{ $ticket->user->name }}</span>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400 block font-medium">{{ $ticket->user->email }}</span>
                </div>

                <div>
                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">{{ __('Created Date') }}</span>
                    <span class="text-xs font-semibold text-slate-700 dark:text-slate-300 block mt-0.5">{{ $ticket->created_at->format('d M Y - H:i A') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- CONFIRMATION MODAL FOR STATUS CHANGE -->
    @if ($showStatusModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-md">
            <div class="neu-flat w-full max-w-md p-6 bg-[#e6eef8] dark:bg-[#141b27] relative border border-white/60 dark:border-slate-800 rounded-3xl text-center shadow-2xl">
                <div class="w-14 h-14 neu-pressed rounded-full text-amber-500 dark:text-amber-400 flex items-center justify-center mx-auto mb-4 font-black text-2xl">
                    ⚠️
                </div>
                <h3 class="font-display font-extrabold text-lg text-slate-800 dark:text-white mb-2">
                    {{ __('Konfirmasi Perubahan Status') }}
                </h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 mb-6 font-medium leading-relaxed">
                    Apakah Anda yakin ingin mengubah status tiket ini dari 
                    <span class="font-bold text-amber-600 dark:text-amber-400">{{ $this->getStatusLabel($ticket->status) }}</span> 
                    menjadi 
                    <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $this->getStatusLabel($pendingStatus) }}</span>?
                </p>

                <div class="flex items-center justify-center gap-3">
                    <button type="button" wire:click="cancelStatusChange" class="neu-button px-5 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 rounded-xl cursor-pointer">
                        {{ __('Batal') }}
                    </button>
                    <button type="button" wire:click="applyStatusChange" class="neu-button-primary px-6 py-2.5 text-xs font-bold uppercase rounded-xl cursor-pointer">
                        {{ __('Ya, Ubah Status') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
