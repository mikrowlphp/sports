<div class="match-viewer flex flex-col lg:flex-row gap-4 h-full">
    {{-- Main Player Area - Using VideoPlayer component --}}
    <div class="flex-1 min-w-0">
        <livewire:sports::video-player
            :match="$match"
            :tags="$this->tags"
            :clips="$this->clipsRaw"
            :main-video-url="$this->mainVideo['url'] ?? null"
        />

        {{-- Now Playing Info --}}
        <div class="mt-2 px-1">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                @if($activeClipIndex !== null && isset($this->clips[$activeClipIndex]))
                    {{ $this->clips[$activeClipIndex]['title'] }}
                @else
                    {{ $this->mainVideo['title'] ?? $match->title ?? '' }}
                @endif
            </h2>
        </div>
    </div>

    {{-- Clips Sidebar --}}
    <div class="w-full lg:w-80 xl:w-96 flex-shrink-0">
        <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-3 h-full">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                {{ __('sports::matches.playlist') }}
            </h3>

            <div class="space-y-2 max-h-[60vh] overflow-y-auto">
                {{-- Full Match --}}
                @if($this->mainVideo)
                    <button
                        type="button"
                        wire:click="playFullMatch"
                        class="w-full flex gap-3 p-2 rounded-lg transition-all {{ $activeClipIndex === null ? 'bg-primary-100 dark:bg-primary-900 ring-2 ring-primary-500' : 'bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600' }}"
                    >
                        <div class="relative w-24 h-14 flex-shrink-0 bg-gray-200 dark:bg-gray-600 rounded overflow-hidden">
                            @if($this->mainVideo['preview'])
                                <img src="{{ $this->mainVideo['preview'] }}" alt="" class="w-full h-full object-cover"/>
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @endif
                            @if($activeClipIndex === null)
                                <div class="absolute inset-0 bg-primary-500/20 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white drop-shadow" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 text-left min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {{ __('sports::matches.full_match') }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $this->mainVideo['title'] }}
                            </p>
                        </div>
                    </button>
                @endif

                {{-- Divider --}}
                @if($this->mainVideo && count($this->clips) > 0)
                    <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 px-1">{{ __('sports::matches.clips') }} ({{ count($this->clips) }})</p>
                @endif

                {{-- Clips --}}
                @foreach($this->clips as $index => $clip)
                    <button
                        type="button"
                        wire:click="playClip({{ $index }})"
                        class="w-full flex gap-3 p-2 rounded-lg transition-all {{ $activeClipIndex === $index ? 'bg-primary-100 dark:bg-primary-900 ring-2 ring-primary-500' : 'bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600' }}"
                    >
                        <div class="relative w-24 h-14 flex-shrink-0 bg-gray-200 dark:bg-gray-600 rounded overflow-hidden">
                            @if($clip['preview'])
                                <img src="{{ $clip['preview'] }}" alt="" class="w-full h-full object-cover"/>
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4"/>
                                    </svg>
                                </div>
                            @endif
                            @if($activeClipIndex === $index)
                                <div class="absolute inset-0 bg-primary-500/20 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white drop-shadow" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 text-left min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {{ $clip['title'] }}
                            </p>
                            @if($clip['created_at'])
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($clip['created_at'])->format('H:i') }}
                                </p>
                            @endif
                        </div>
                    </button>
                @endforeach

                @if(count($this->clips) === 0 && !$this->mainVideo)
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm">{{ __('sports::matches.no_clips') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
