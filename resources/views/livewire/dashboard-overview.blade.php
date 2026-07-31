<div>
    <!-- Page Title & Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800 dark:text-white font-display tracking-tight">{{ __('Internal IT Ticket Dashboard') }}</h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs mt-1 font-medium">Neumorphic Soft UI Emboss &bull; MySQL Database Connected</p>
        </div>
        @if(!auth()->user()?->isTechnician())
        <div>
            <button wire:click="openCreateModal" class="neu-button-primary px-5 py-3 font-bold text-xs flex items-center gap-2 tracking-wide uppercase">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                {{ __('Add Ticket') }}
            </button>
        </div>
        @endif
    </div>

    <!-- 1. REQUIRED SUMMARY METRICS (4 CARDS) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Metric 1: Total Tickets -->
        <div class="neu-flat p-6 flex flex-col justify-between relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ __('Total Tickets') }}</span>
                <div class="w-10 h-10 neu-pressed rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-black text-slate-800 dark:text-white font-display">{{ $stats['total'] }}</span>
                <span class="text-[11px] text-slate-500 dark:text-slate-400 block mt-0.5 font-medium">{{ __('All recorded support tickets') }}</span>
            </div>
        </div>

        <!-- Metric 2: Open Tickets -->
        <div class="neu-flat p-6 flex flex-col justify-between relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold text-amber-600 dark:text-amber-400 uppercase tracking-wider">{{ __('Open Tickets') }}</span>
                <div class="w-10 h-10 neu-pressed rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-black text-amber-600 dark:text-amber-400 font-display">{{ $stats['open'] }}</span>
                <span class="text-[11px] text-amber-700/80 dark:text-amber-300/80 block mt-0.5 font-medium">{{ __('Awaiting technician action') }}</span>
            </div>
        </div>

        <!-- Metric 3: In Progress Tickets -->
        <div class="neu-flat p-6 flex flex-col justify-between relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold text-blue-600 dark:text-blue-400 uppercase tracking-wider">{{ __('In Progress Tickets') }}</span>
                <div class="w-10 h-10 neu-pressed rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-black text-blue-600 dark:text-blue-400 font-display">{{ $stats['in_progress'] }}</span>
                <span class="text-[11px] text-blue-700/80 dark:text-blue-300/80 block mt-0.5 font-medium">{{ __('Currently being resolved') }}</span>
            </div>
        </div>

        <!-- Metric 4: High Priority Tickets -->
        <div class="neu-flat p-6 flex flex-col justify-between relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold text-rose-600 dark:text-rose-400 uppercase tracking-wider">{{ __('High Priority Tickets') }}</span>
                <div class="w-10 h-10 neu-pressed rounded-xl flex items-center justify-center text-rose-600 dark:text-rose-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-black text-rose-600 dark:text-rose-400 font-display">{{ $stats['high_priority'] }}</span>
                <span class="text-[11px] text-rose-700/80 dark:text-rose-300/80 block mt-0.5 font-medium">{{ __('High & Urgent priority level') }}</span>
            </div>
        </div>
    </div>

    <!-- 2. BONUS FEATURES: NEUMORPHIC SEARCH, FILTER, AND SORTING BAR -->
    <div class="neu-flat p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <!-- Search Bar -->
            <div class="flex-1 relative">
                <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">{{ __('Search Tickets') }}</label>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ __('Search tickets #, title, or details...') }}" class="neu-input w-full pl-10 pr-4 py-2.5 text-xs font-semibold placeholder-slate-400">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <!-- Filters -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">{{ __('Status') }}</label>
                    <x-neu-select wire:model.live="filterStatus" placeholder="{{ __('All Statuses') }}" :options="[
                        '' => __('All Statuses'),
                        'open' => __('Open'),
                        'in_progress' => __('In Progress'),
                        'resolved' => __('Resolved'),
                        'closed' => __('Closed')
                    ]" />
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">{{ __('Priority') }}</label>
                    <x-neu-select wire:model.live="filterPriority" placeholder="{{ __('All Priorities') }}" :options="[
                        '' => __('All Priorities'),
                        'urgent' => __('Urgent'),
                        'high' => __('High'),
                        'medium' => __('Medium'),
                        'low' => __('Low')
                    ]" />
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">{{ __('Service Categories') }}</label>
                    <x-neu-select wire:model.live="filterCategory" placeholder="{{ __('All Categories') }}" :options="
                        array_merge(['' => __('All Categories')], $categories->pluck('name', 'id')->toArray())
                    " />
                </div>
            </div>

            <!-- Sorting & Ordering Options -->
            <div class="flex items-center gap-2">
                <div class="flex-1">
                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">{{ __('Sort By') }}</label>
                    <x-neu-select wire:model.live="sortBy" placeholder="{{ __('Sort By') }}" :options="[
                        'created_at' => __('Created Date'),
                        'priority' => __('Priority Level'),
                        'status' => __('Status'),
                        'title' => __('Ticket Title')
                    ]" />
                </div>

                <div class="w-36">
                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">{{ __('Urutan') }}</label>
                    <x-neu-select wire:model.live="sortDirection" placeholder="{{ __('Urutan') }}" :options="[
                        'desc' => __('Terbaru'),
                        'asc' => __('Terlama')
                    ]" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h13M3 8h9m-9 4h6m4 0l3-3m0 0l3 3m-3-3v12" /></svg>' />
                </div>
            </div>
        </div>
    </div>

    <!-- 3. NEUMORPHIC TICKET DATA TABLE -->
    <div class="neu-flat p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-display font-extrabold text-lg text-slate-800 dark:text-white">{{ __('Support Ticket Queue') }}</h3>
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 neu-pressed px-3 py-1">
                Showing {{ $tickets->total() }} total tickets
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-y-3">
                <thead>
                    <tr class="text-[11px] font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                        <th class="py-2 px-4 cursor-pointer select-none" wire:click="sort('ticket_number')">
                            {{ __('Ticket #') }}
                        </th>
                        <th class="py-2 px-4 cursor-pointer select-none" wire:click="sort('title')">
                            {{ __('Ticket Title & Category') }}
                        </th>
                        <th class="py-2 px-4 cursor-pointer select-none" wire:click="sort('priority')">
                            {{ __('Priority') }}
                        </th>
                        <th class="py-2 px-4 cursor-pointer select-none" wire:click="sort('status')">
                            {{ __('Status (Color Indicator)') }}
                        </th>
                        <th class="py-2 px-4">
                            {{ __('Assigned Person') }}
                        </th>
                        <th class="py-2 px-4 cursor-pointer select-none" wire:click="sort('created_at')">
                            {{ __('Created Date') }}
                        </th>
                        <th class="py-2 px-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $t)
                        <tr x-data="{ openStatus: false }" :class="openStatus ? 'relative z-50' : 'relative z-1'" class="neu-flat-sm hover:translate-y-[-1px] transition-all">
                            <!-- Ticket Number -->
                            <td class="py-4 px-4 font-mono font-bold text-xs text-indigo-700 dark:text-indigo-400">
                                {{ $t->ticket_number }}
                            </td>

                            <!-- Ticket Title & Category -->
                            <td class="py-4 px-4 max-w-xs">
                                <a href="{{ route('tickets.show', $t->id) }}" class="font-bold text-slate-800 dark:text-white text-sm hover:text-indigo-600 block leading-tight">
                                    {{ $t->title }}
                                </a>
                                <span class="inline-block mt-1 text-[10px] font-bold px-2 py-0.5 text-slate-600 dark:text-slate-300 neu-pressed">
                                    {{ $t->category->name }}
                                </span>
                            </td>

                            <!-- Priority Badge -->
                            <td class="py-4 px-4">
                                @if ($t->priority === 'urgent')
                                    <span class="neu-badge inline-flex items-center gap-1.5 whitespace-nowrap px-3 py-1 text-[10px] font-extrabold text-rose-700 dark:text-rose-300 bg-rose-100 dark:bg-rose-950/50 border border-rose-300 dark:border-rose-800/60 uppercase tracking-wide">
                                        <svg class="w-3.5 h-3.5 text-rose-600 dark:text-rose-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                                        </svg>
                                        <span>{{ __('Urgent') }}</span>
                                    </span>
                                @elseif ($t->priority === 'high')
                                    <span class="neu-badge inline-flex items-center gap-1.5 whitespace-nowrap px-3 py-1 text-[10px] font-extrabold text-amber-700 dark:text-amber-300 bg-amber-100 dark:bg-amber-950/50 border border-amber-300 dark:border-amber-800/60 uppercase tracking-wide">
                                        <svg class="w-3.5 h-3.5 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                                        </svg>
                                        <span>{{ __('High') }}</span>
                                    </span>
                                @elseif ($t->priority === 'medium')
                                    <span class="neu-badge inline-flex items-center gap-1.5 whitespace-nowrap px-3 py-1 text-[10px] font-extrabold text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-950/50 border border-blue-300 dark:border-blue-800/60 uppercase tracking-wide">
                                        <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 6h18M3 18h18"/>
                                        </svg>
                                        <span>{{ __('Medium') }}</span>
                                    </span>
                                @else
                                    <span class="neu-badge inline-flex items-center gap-1.5 whitespace-nowrap px-3 py-1 text-[10px] font-extrabold text-slate-600 dark:text-slate-400 bg-slate-200 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 uppercase tracking-wide">
                                        <svg class="w-3.5 h-3.5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3"/>
                                        </svg>
                                        <span>{{ __('Low') }}</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Status Color Indicator Badge -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    @if ($t->status === 'open')
                                        <span class="neu-badge inline-flex items-center gap-1.5 px-3 py-1 text-xs font-extrabold text-amber-700 dark:text-amber-300 bg-amber-100 dark:bg-amber-950/50 border border-amber-300 dark:border-amber-800/60">
                                            <svg class="w-3.5 h-3.5 text-amber-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ __('Open') }}</span>
                                        </span>
                                    @elseif ($t->status === 'in_progress')
                                        <span class="neu-badge inline-flex items-center gap-1.5 px-3 py-1 text-xs font-extrabold text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-950/50 border border-blue-300 dark:border-blue-800/60">
                                            <svg class="w-3.5 h-3.5 text-blue-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                            </svg>
                                            <span>{{ __('In Progress') }}</span>
                                        </span>
                                    @elseif ($t->status === 'resolved')
                                        <span class="neu-badge inline-flex items-center gap-1.5 px-3 py-1 text-xs font-extrabold text-emerald-700 dark:text-emerald-300 bg-emerald-100 dark:bg-emerald-950/50 border border-emerald-300 dark:border-emerald-800/60">
                                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ __('Resolved') }}</span>
                                        </span>
                                    @else
                                        <span class="neu-badge inline-flex items-center gap-1.5 px-3 py-1 text-xs font-extrabold text-slate-700 dark:text-slate-300 bg-slate-200 dark:bg-slate-800 border border-slate-300 dark:border-slate-700">
                                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                            </svg>
                                            <span>{{ __('Closed') }}</span>
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Assigned Person -->
                            <td class="py-4 px-4">
                                @if ($t->technician)
                                    <div class="font-bold text-xs text-slate-700 dark:text-slate-200">{{ $t->technician->name }}</div>
                                    <div class="text-[10px] text-slate-500 dark:text-slate-400">{{ $t->technician->department ?? 'IT Staff' }}</div>
                                @else
                                    <span class="text-xs font-semibold text-slate-400 italic">{{ __('Unassigned') }}</span>
                                @endif
                            </td>

                            <!-- Created Date -->
                            <td class="py-4 px-4 text-xs font-semibold text-slate-600 dark:text-slate-300">
                                {{ $t->created_at->format('d M Y') }}
                                <span class="block text-[10px] text-slate-400 font-normal">{{ $t->created_at->format('H:i A') }}</span>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('tickets.show', $t->id) }}" class="neu-button px-3 py-1.5 text-[11px] font-bold text-indigo-600 dark:text-indigo-400" title="{{ __('Notes') }}">
                                        {{ __('Notes') }}
                                    </a>

                                    @if(!auth()->user()?->isUser())
                                    <button wire:click="openEditModal({{ $t->id }})" class="neu-button px-3 py-1.5 text-[11px] font-bold text-amber-700 dark:text-amber-400" title="{{ __('Edit') }}">
                                        {{ __('Edit') }}
                                    </button>
                                    @endif

                                    @if(auth()->user()?->isAdmin())
                                    <button wire:click="openDeleteModal({{ $t->id }})" class="neu-button-danger px-3 py-1.5 text-[11px] font-bold" title="{{ __('Delete') }}">
                                        {{ __('Delete') }}
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 neu-flat text-center text-slate-500 font-semibold text-xs">
                                No support tickets found matching your query.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $tickets->links() }}
        </div>
    </div>

    <!-- ADD TICKET MODAL -->
    @if ($showCreateModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div class="neu-flat w-full max-w-xl p-8 bg-[#e6eef8] dark:bg-[#141b27] relative border border-white/60 dark:border-slate-800">
                <div class="flex items-center justify-between pb-4 border-b border-slate-300 dark:border-slate-800">
                    <h3 class="font-display font-extrabold text-xl text-slate-800 dark:text-white">{{ __('Add New IT Support Ticket') }}</h3>
                    <button wire:click="closeCreateModal" class="neu-button w-8 h-8 flex items-center justify-center font-bold text-slate-500">✕</button>
                </div>

                <form wire:submit.prevent="createTicket" class="mt-6 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('Ticket Title') }} *</label>
                        <input type="text" wire:model="title" placeholder="e.g. Printer offline, ERP login issue" class="neu-input w-full px-3.5 py-2.5 text-xs">
                        @error('title') <span class="text-rose-600 text-[11px] mt-1 font-bold block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('Service Categories') }} *</label>
                            <x-neu-select wire:model="category_id" placeholder="{{ __('Service Categories') }}" :options="
                                $categories->pluck('name', 'id')->toArray()
                            " />
                            @error('category_id') <span class="text-rose-600 text-[11px] mt-1 font-bold block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('Priority') }} *</label>
                            <x-neu-select wire:model="priority" placeholder="{{ __('Priority') }}" :options="[
                                'low' => __('Low'),
                                'medium' => __('Medium'),
                                'high' => __('High'),
                                'urgent' => __('Urgent')
                            ]" />
                            @error('priority') <span class="text-rose-600 text-[11px] mt-1 font-bold block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 {{ auth()->user()?->isAdmin() ? 'sm:grid-cols-2' : '' }} gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('Reporter / User') }} *</label>
                            @if(auth()->user()?->isAdmin())
                                <x-neu-select wire:model="user_id" placeholder="User" :options="
                                    $users->pluck('name', 'id')->toArray()
                                " />
                            @else
                                <div class="neu-pressed px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center justify-between">
                                    <span>{{ auth()->user()?->name }}</span>
                                    <span class="text-[10px] text-indigo-600 dark:text-indigo-400 font-extrabold uppercase">({{ __('Pemohon') }})</span>
                                </div>
                            @endif
                        </div>

                        @if(auth()->user()?->isAdmin())
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('Assigned Person') }}</label>
                            <x-neu-select wire:model="assigned_to" placeholder="{{ __('Unassigned') }}" :options="
                                array_merge(['' => __('Unassigned')], $technicians->pluck('name', 'id')->toArray())
                            " />
                        </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Description *</label>
                        <textarea wire:model="description" rows="3" placeholder="Provide details about the issue..." class="neu-input w-full px-3.5 py-2.5 text-xs"></textarea>
                        @error('description') <span class="text-rose-600 text-[11px] mt-1 font-bold block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-300 dark:border-slate-800">
                        <button type="button" wire:click="closeCreateModal" class="neu-button px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300">{{ __('Cancel') }}</button>
                        <button type="submit" class="neu-button-primary px-6 py-2.5 text-xs font-bold uppercase">{{ __('Save Ticket') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- EDIT TICKET MODAL -->
    @if ($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div class="neu-flat w-full max-w-xl p-8 bg-[#e6eef8] dark:bg-[#141b27] relative border border-white/60 dark:border-slate-800">
                <div class="flex items-center justify-between pb-4 border-b border-slate-300 dark:border-slate-800">
                    <h3 class="font-display font-extrabold text-xl text-slate-800 dark:text-white">{{ __('Edit Support Ticket') }}</h3>
                    <button wire:click="closeEditModal" class="neu-button w-8 h-8 flex items-center justify-center font-bold text-slate-500">✕</button>
                </div>

                <form wire:submit.prevent="updateTicket" class="mt-6 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('Ticket Title') }} *</label>
                        @if(auth()->user()?->isTechnician())
                            <div class="neu-pressed px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200">
                                {{ $title }}
                            </div>
                        @else
                            <input type="text" wire:model="title" class="neu-input w-full px-3.5 py-2.5 text-xs">
                            @error('title') <span class="text-rose-600 text-[11px] mt-1 font-bold block">{{ $message }}</span> @enderror
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('Service Categories') }} *</label>
                            @if(auth()->user()?->isTechnician())
                                <div class="neu-pressed px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200">
                                    {{ $categories->find($category_id)?->name }}
                                </div>
                            @else
                                <x-neu-select wire:model="category_id" placeholder="{{ __('Service Categories') }}" :options="
                                    $categories->pluck('name', 'id')->toArray()
                                " />
                            @endif
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('Priority') }} *</label>
                            @if(auth()->user()?->isTechnician())
                                <div class="neu-pressed px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200">
                                    {{ ucfirst($priority) }}
                                </div>
                            @else
                                <x-neu-select wire:model="priority" placeholder="{{ __('Priority') }}" :options="[
                                    'low' => __('Low'),
                                    'medium' => __('Medium'),
                                    'high' => __('High'),
                                    'urgent' => __('Urgent')
                                ]" />
                            @endif
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('Status') }} *</label>
                            <x-neu-select wire:model="status" placeholder="{{ __('Status') }}" :options="[
                                'open' => __('Open'),
                                'in_progress' => __('In Progress'),
                                'resolved' => __('Resolved'),
                                'closed' => __('Closed')
                            ]" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Reporter / User *</label>
                            @if(auth()->user()?->isTechnician())
                                <div class="neu-pressed px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200">
                                    {{ $users->find($user_id)?->name }}
                                </div>
                            @else
                                <x-neu-select wire:model="user_id" placeholder="User" :options="
                                    $users->pluck('name', 'id')->toArray()
                                " />
                            @endif
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('Assigned Person') }}</label>
                            @if(auth()->user()?->isTechnician())
                                <div class="neu-pressed px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200">
                                    {{ auth()->user()->name }}
                                </div>
                            @else
                                <x-neu-select wire:model="assigned_to" placeholder="{{ __('Unassigned') }}" :options="
                                    array_merge(['' => __('Unassigned')], $technicians->pluck('name', 'id')->toArray())
                                " />
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Description *</label>
                        @if(auth()->user()?->isTechnician())
                            <div class="neu-pressed px-3.5 py-2.5 rounded-xl text-xs font-medium text-slate-800 dark:text-slate-200 leading-relaxed whitespace-pre-line min-h-[60px]">
                                {{ $description }}
                            </div>
                        @else
                            <textarea wire:model="description" rows="3" class="neu-input w-full px-3.5 py-2.5 text-xs"></textarea>
                            @error('description') <span class="text-rose-600 text-[11px] mt-1 font-bold block">{{ $message }}</span> @enderror
                        @endif
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-300 dark:border-slate-800">
                        <button type="button" wire:click="closeEditModal" class="neu-button px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300">{{ __('Cancel') }}</button>
                        <button type="submit" class="neu-button-primary px-6 py-2.5 text-xs font-bold uppercase">{{ __('Update Ticket') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- DELETE CONFIRMATION MODAL -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div class="neu-flat w-full max-w-md p-6 bg-[#e6eef8] dark:bg-[#141b27] relative border border-white/60 dark:border-slate-800 text-center">
                <div class="w-12 h-12 neu-pressed rounded-full text-rose-600 flex items-center justify-center mx-auto mb-4 font-black text-xl">
                    ⚠️
                </div>
                <h3 class="font-display font-extrabold text-lg text-slate-800 dark:text-white mb-2">{{ __('Delete Ticket Confirmation') }}</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 mb-6 font-medium">{{ __('Are you sure you want to delete this ticket?') }}</p>

                <div class="flex items-center justify-center gap-4">
                    <button type="button" wire:click="closeDeleteModal" class="neu-button px-5 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300">{{ __('Cancel') }}</button>
                    <button type="button" wire:click="deleteTicket" class="neu-button-danger px-6 py-2.5 text-xs font-bold uppercase">{{ __('Yes, Delete Ticket') }}</button>
                </div>
            </div>
        </div>
    @endif
</div>
