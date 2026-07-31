@props([
    'options' => [],
    'placeholder' => 'Pilih...',
    'icon' => null,
    'class' => '',
])

@php
    $formattedOptions = [];
    foreach ($options as $key => $val) {
        if (is_array($val)) {
            $formattedOptions[] = ['value' => (string)($val['value'] ?? $key), 'label' => (string)($val['label'] ?? $val)];
        } else {
            $formattedOptions[] = ['value' => (string)$key, 'label' => (string)$val];
        }
    }

    $wireModel = $attributes->wire('model');
    $modelName = $wireModel ? $wireModel->value() : null;
    $isLive = $wireModel ? ($wireModel->hasModifier('live') || $attributes->has('wire:model.live')) : false;
@endphp

<div x-data="{
        open: false,
        @if($modelName)
        selected: $wire.entangle('{{ $modelName }}'){{ $isLive ? '.live' : '' }},
        @else
        selected: '',
        @endif
        options: {{ json_encode($formattedOptions) }},
        get selectedLabel() {
            if (this.selected === null || this.selected === undefined || this.selected === '') {
                return '{{ $placeholder }}';
            }
            let found = this.options.find(o => String(o.value) === String(this.selected));
            return found ? found.label : '{{ $placeholder }}';
        },
        selectOption(val) {
            this.selected = val;
            this.open = false;
        }
    }" 
    @click.away="open = false" 
    @keydown.escape.window="open = false"
    :class="open ? 'relative z-50 w-full' : 'relative z-10 w-full'"
    class="w-full">
    
    <!-- Trigger Button -->
    <button type="button" 
        @click="open = !open" 
        class="neu-input w-full px-3.5 py-2.5 text-xs font-bold flex items-center justify-between gap-2 text-left text-slate-800 dark:text-slate-100 transition-all focus:outline-none rounded-xl cursor-pointer {{ $class }}">
        
        <div class="flex items-center gap-2 truncate">
            @if($icon)
                <span class="text-indigo-600 dark:text-indigo-400 shrink-0">{!! $icon !!}</span>
            @endif
            <span x-text="selectedLabel" class="truncate font-semibold text-slate-700 dark:text-slate-200"></span>
        </div>

        <svg class="w-4 h-4 text-indigo-500 shrink-0 transition-transform duration-300 transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <!-- Floating 3D Embossed Dropdown Menu -->
    <div x-show="open" 
        x-transition:enter="transition ease-out duration-200" 
        x-transition:enter-start="opacity-0 scale-95 -translate-y-2" 
        x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
        x-transition:leave="transition ease-in duration-150" 
        x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
        x-transition:leave-end="opacity-0 scale-95 -translate-y-2" 
        class="absolute left-0 right-0 z-50 mt-2 p-2 neu-flat max-h-64 overflow-y-auto backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/40" 
        style="display: none;">
        
        <template x-for="opt in options" :key="opt.value">
            <div @click="selectOption(opt.value)" 
                class="px-3.5 py-2.5 my-1 text-xs font-bold rounded-xl cursor-pointer transition-all flex items-center justify-between group"
                :class="String(selected) === String(opt.value) 
                    ? 'neu-pressed text-indigo-600 dark:text-indigo-400 font-extrabold shadow-inner' 
                    : 'text-slate-700 dark:text-slate-300 hover:neu-pressed-sm hover:text-indigo-600 dark:hover:text-indigo-400'">
                <span x-text="opt.label" class="truncate"></span>
                <svg x-show="String(selected) === String(opt.value)" class="w-4 h-4 text-indigo-600 dark:text-indigo-400 shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </template>
    </div>
</div>
