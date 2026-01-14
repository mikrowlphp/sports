<div class="sponsor-placement-editor">
    {{-- Preview Area --}}
    <div class="relative w-full aspect-video bg-gradient-to-br from-green-800 to-green-600 rounded-lg overflow-hidden shadow-lg border-4 border-green-900">
        {{-- Field lines decoration --}}
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-1/2 left-0 right-0 h-px bg-white"></div>
            <div class="absolute top-0 bottom-0 left-1/2 w-px bg-white"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-24 h-24 border-2 border-white rounded-full"></div>
        </div>

        {{-- Position Hotspots --}}
        @foreach($this->positions as $position)
            @php
                $positionValue = $position->value;
                $sponsor = $this->selectedSponsors[$positionValue] ?? null;
                $size = $sponsorSizes[$positionValue] ?? 100;
            @endphp

            <div
                class="absolute p-2 transition-all duration-200 {{ $position->cssClasses() }}"
                style="z-index: 10;"
            >
                @if($sponsor)
                    {{-- Sponsor Logo with controls --}}
                    <div class="group relative">
                        <div
                            class="bg-white/90 backdrop-blur rounded-lg shadow-lg p-2 transition-transform hover:scale-105"
                            style="width: {{ $size }}px; height: {{ $size * 0.6 }}px;"
                        >
                            @if($sponsor->logo)
                                <img
                                    src="{{ Storage::url($sponsor->logo) }}"
                                    alt="{{ $sponsor->name }}"
                                    class="w-full h-full object-contain"
                                />
                            @else
                                <div class="w-full h-full flex items-center justify-center text-xs text-gray-500">
                                    {{ $sponsor->name }}
                                </div>
                            @endif
                        </div>

                        {{-- Controls (visible on hover) --}}
                        <div class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity flex gap-1">
                            {{-- Remove button --}}
                            <button
                                type="button"
                                wire:click="removeSponsor('{{ $positionValue }}')"
                                class="w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow-lg"
                                title="{{ __('sports::matches.remove_sponsor') }}"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        {{-- Size slider (visible on hover) --}}
                        <div class="absolute -bottom-8 left-0 right-0 opacity-0 group-hover:opacity-100 transition-opacity">
                            <input
                                type="range"
                                min="50"
                                max="150"
                                value="{{ $size }}"
                                wire:change="updateSize('{{ $positionValue }}', $event.target.value)"
                                class="w-full h-2 bg-white/50 rounded-lg appearance-none cursor-pointer"
                            />
                        </div>
                    </div>
                @else
                    {{-- Empty hotspot --}}
                    <button
                        type="button"
                        wire:click="selectPosition('{{ $positionValue }}')"
                        class="w-16 h-10 bg-white/20 hover:bg-white/40 border-2 border-dashed border-white/50 hover:border-white rounded-lg flex items-center justify-center transition-all cursor-pointer group"
                        title="{{ __($positionValue) }}"
                    >
                        <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                @endif
            </div>
        @endforeach

        {{-- Center label --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white/50 text-sm font-medium pointer-events-none">
            {{ __('sports::matches.video_preview') }}
        </div>
    </div>

    {{-- Legend --}}
    <div class="mt-4 flex flex-wrap gap-2 justify-center text-xs text-gray-500 dark:text-gray-400">
        @foreach($this->positions as $position)
            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded">
                {{ __($position->value) }}
            </span>
        @endforeach
    </div>

    {{-- Sponsor Selector Modal --}}
    <div
        x-data="{ open: false }"
        x-on:open-modal.window="if ($event.detail.id === 'sponsor-selector-modal') open = true"
        x-on:close-modal.window="if ($event.detail.id === 'sponsor-selector-modal') open = false"
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
    >
        {{-- Backdrop --}}
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0 bg-black/50"
            @click="open = false"
        ></div>

        {{-- Modal Content --}}
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white dark:bg-gray-900 rounded-xl shadow-2xl w-full max-w-md max-h-[80vh] overflow-hidden"
        >
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ __('sports::matches.select_sponsor') }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('sports::matches.select_sponsor_desc') }}
                </p>
            </div>

            {{-- Sponsor List --}}
            <div class="p-4 overflow-y-auto max-h-96">
                <div class="grid grid-cols-2 gap-3">
                    @forelse($this->sponsors as $sponsor)
                        <button
                            type="button"
                            wire:click="assignSponsor({{ $sponsor->id }})"
                            class="flex flex-col items-center p-4 bg-gray-50 dark:bg-gray-800 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg border-2 border-transparent hover:border-primary-500 transition-all"
                        >
                            @if($sponsor->logo)
                                <img
                                    src="{{ Storage::url($sponsor->logo) }}"
                                    alt="{{ $sponsor->name }}"
                                    class="w-16 h-12 object-contain mb-2"
                                />
                            @else
                                <div class="w-16 h-12 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <span class="text-sm font-medium text-gray-900 dark:text-white text-center">
                                {{ $sponsor->name }}
                            </span>
                        </button>
                    @empty
                        <div class="col-span-2 text-center py-8 text-gray-500">
                            {{ __('sports::sponsors.no_sponsors') }}
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button
                    type="button"
                    @click="open = false"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
                >
                    {{ __('sports::matches.cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>
