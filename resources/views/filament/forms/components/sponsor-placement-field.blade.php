<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @if(!$getHasAnySponsors())
        {{-- No sponsors message --}}
        <div class="relative w-full aspect-video bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 rounded-xl overflow-hidden border-2 border-dashed border-gray-400 dark:border-gray-600 flex items-center justify-center">
            <div class="text-center p-6">
                <x-heroicon-o-megaphone class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500 mb-3" />
                <p class="text-gray-600 dark:text-gray-400 font-medium">{{ __('sports::sponsors.no_sponsors_available') }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">{{ __('sports::sponsors.create_sponsor_first') }}</p>
            </div>
        </div>
    @else
    @php
        $initialState = $getState() ?? [];
        $positions = collect($getPositions())->map(fn($p) => $p->value)->toArray();
    @endphp
    <div
        x-data="{
            state: $wire.$entangle('{{ $getStatePath() }}'),
            initialState: @js($initialState),
            sizes: {},
            sponsors: @js($getAllSponsors()->keyBy('id')->toArray()),
            positions: @js($positions),

            init() {
                // Use initial state if entangle returns empty or not an object
                if (!this.state || typeof this.state !== 'object' || Object.keys(this.state).length === 0) {
                    if (this.initialState && typeof this.initialState === 'object' && Object.keys(this.initialState).length > 0) {
                        this.state = {...this.initialState};
                    }
                }

                // Initialize sizes for all positions
                this.positions.forEach(pos => this.sizes[pos] = 80);
            },

            getState(position) {
                return this.state && this.state[position] ? this.state[position] : null;
            },

            removeSponsor(position) {
                if (this.state && this.state[position]) {
                    delete this.state[position];
                    this.state = {...this.state};
                }
            },

            getSponsor(sponsorId) {
                return this.sponsors[sponsorId] || null;
            },

            updateSize(position, delta) {
                this.sizes[position] = Math.max(50, Math.min(120, this.sizes[position] + delta));
            },

            getSelectedCount() {
                if (!this.state) return 0;
                return Object.values(this.state).filter(v => v).length;
            },

            hasAvailableSponsors() {
                const totalSponsors = Object.keys(this.sponsors).length;
                return this.getSelectedCount() < totalSponsors;
            }
        }"
        class="sponsor-placement-field relative"
    >
        {{-- Preview Area --}}
        <div class="relative w-full aspect-video bg-gradient-to-br from-emerald-700 to-emerald-900 rounded-xl shadow-xl border border-emerald-950">
            {{-- Field decoration --}}
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-white"></div>
                <div class="absolute top-0 bottom-0 left-1/2 w-0.5 bg-white"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 border border-white rounded-full"></div>
            </div>

            {{-- 6 Position Hotspots --}}
            @foreach($getPositions() as $position)
                @php
                    $positionValue = $position->value;
                    $cssClasses = $position->cssClasses();
                @endphp

                <div class="absolute p-2 {{ $cssClasses }}" style="z-index: 10;">
                    {{-- Has sponsor assigned --}}
                    <template x-if="getState('{{ $positionValue }}')">
                        <div class="group relative">
                            <div
                                class="bg-white rounded-lg shadow-lg p-1.5 transition-all duration-200 hover:scale-105 cursor-pointer"
                                :style="'width: ' + sizes['{{ $positionValue }}'] + 'px; height: ' + (sizes['{{ $positionValue }}'] * 0.6) + 'px;'"
                            >
                                <template x-if="getSponsor(getState('{{ $positionValue }}'))?.logo_url">
                                    <img
                                        :src="getSponsor(getState('{{ $positionValue }}')).logo_url"
                                        :alt="getSponsor(getState('{{ $positionValue }}'))?.name"
                                        class="w-full h-full object-contain"
                                    />
                                </template>
                                <template x-if="!getSponsor(getState('{{ $positionValue }}'))?.logo_url">
                                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-500 font-medium" x-text="getSponsor(getState('{{ $positionValue }}'))?.name"></div>
                                </template>
                            </div>

                            {{-- Controls --}}
                            <div class="absolute -top-2 -right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button
                                    type="button"
                                    @click="removeSponsor('{{ $positionValue }}')"
                                    class="w-5 h-5 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow text-xs"
                                    title="{{ __('sports::matches.remove_sponsor') }}"
                                >
                                    ✕
                                </button>
                            </div>

                            {{-- Size controls --}}
                            <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button
                                    type="button"
                                    @click="updateSize('{{ $positionValue }}', -10)"
                                    class="w-5 h-5 bg-gray-700 hover:bg-gray-600 text-white rounded text-xs flex items-center justify-center"
                                >−</button>
                                <button
                                    type="button"
                                    @click="updateSize('{{ $positionValue }}', 10)"
                                    class="w-5 h-5 bg-gray-700 hover:bg-gray-600 text-white rounded text-xs flex items-center justify-center"
                                >+</button>
                            </div>
                        </div>
                    </template>

                    {{-- Empty slot --}}
                    <template x-if="!getState('{{ $positionValue }}') && hasAvailableSponsors()">
                        <div class="fi-fo-action">
                            @php
                                $selectAction = $getAction('selectSponsor');
                                $selectAction = $selectAction(['position' => $positionValue]);
                            @endphp
                            {{ $selectAction }}
                        </div>
                    </template>
                </div>
            @endforeach

            {{-- Center label --}}
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <span class="text-white/30 text-sm font-medium">{{ __('sports::matches.video_preview') }}</span>
            </div>

        </div>

        {{-- Position Legend --}}
        <div class="mt-3 flex flex-wrap gap-1.5 justify-center">
            @foreach($getPositions() as $position)
                <span
                    class="px-2 py-0.5 text-xs rounded-full transition-colors"
                    :class="getState('{{ $position->value }}') ? 'bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400'"
                >
                    {{ __($position->value) }}
                </span>
            @endforeach
        </div>
    </div>
    @endif
</x-dynamic-component>
