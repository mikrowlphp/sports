<div
    id="player-container-{{ $match->id }}"
    class="video-player-container relative w-full bg-black rounded-lg overflow-hidden"
    x-data="{
        isFullscreen: false,
        videoRect: { top: 0, left: 0, width: '100%', height: '100%' },
        logoSize: '48px',
        sources: @js($this->videoSources),
        activeIndex: @entangle('activeSourceIndex'),
        hls: null,
        isPlaying: false,
        currentTime: 0,
        duration: 0,
        tags: @js($tags),
        clips: @js($clips),
        showCameraMenu: false,
        activeClip: null,
        mainVideoUrl: @js($this->primaryVideoUrl),
        showControls: true,
        controlsTimeout: null,
        isMobile: window.matchMedia('(max-width: 768px)').matches,

        toggleControls() {
            this.showControls = !this.showControls;
            if (this.showControls) {
                this.startControlsTimer();
            }
        },

        showControlsTemporarily() {
            this.showControls = true;
            this.startControlsTimer();
        },

        startControlsTimer() {
            if (this.controlsTimeout) {
                clearTimeout(this.controlsTimeout);
            }
            if (this.isPlaying) {
                this.controlsTimeout = setTimeout(() => {
                    this.showControls = false;
                }, 3000);
            }
        },

        cancelControlsTimer() {
            if (this.controlsTimeout) {
                clearTimeout(this.controlsTimeout);
                this.controlsTimeout = null;
            }
        },

        formatTime(seconds) {
            if (isNaN(seconds) || seconds < 0) return '0:00';
            const h = Math.floor(seconds / 3600);
            const m = Math.floor((seconds % 3600) / 60);
            const s = Math.floor(seconds % 60);
            if (h > 0) {
                return `${h}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
            }
            return `${m}:${s.toString().padStart(2, '0')}`;
        },

        getTagPosition(tag) {
            if (!this.duration || this.duration <= 0) return 0;
            return (tag.start_time / this.duration) * 100;
        },

        getClipByTagId(tagId) {
            return this.clips.find(clip => clip.id_tag === tagId);
        },

        switchToClip(clip) {
            if (!clip || !clip.streaming_url_hd) return;

            const video = this.$refs.video;
            const wasPlaying = !video.paused;

            this.activeClip = clip;
            this.loadSource(clip.streaming_url_hd);

            video.addEventListener('loadedmetadata', () => {
                if (wasPlaying) {
                    video.play();
                }
                this.updateVideoRect();
            }, { once: true });
        },

        switchToMainVideo() {
            const video = this.$refs.video;
            const wasPlaying = !video.paused;

            this.activeClip = null;
            this.loadSource(this.mainVideoUrl);

            video.addEventListener('loadedmetadata', () => {
                if (wasPlaying) {
                    video.play();
                }
                this.updateVideoRect();
            }, { once: true });
        },

        playFromUrl(url) {
            if (!url) return;

            const video = this.$refs.video;
            const wasPlaying = !video.paused;

            this.loadSource(url);

            video.addEventListener('loadedmetadata', () => {
                video.play();
                this.updateVideoRect();
            }, { once: true });
        },

        onTagClick(tag) {
            const clip = this.getClipByTagId(tag.id);
            if (clip) {
                this.switchToClip(clip);
            }
        },

        seekTo(event) {
            const timeline = event.currentTarget;
            const rect = timeline.getBoundingClientRect();
            const percent = (event.clientX - rect.left) / rect.width;
            const newTime = percent * this.duration;
            this.$refs.video.currentTime = newTime;
        },

        updateVideoRect() {
            const video = this.$refs.video;
            const container = this.$refs.container;
            if (!video || !video.videoWidth || !video.videoHeight) return;

            const containerRect = container.getBoundingClientRect();
            const videoAspect = video.videoWidth / video.videoHeight;
            const containerAspect = containerRect.width / containerRect.height;

            let renderWidth, renderHeight, offsetX, offsetY;

            if (containerAspect > videoAspect) {
                renderHeight = containerRect.height;
                renderWidth = renderHeight * videoAspect;
                offsetX = (containerRect.width - renderWidth) / 2;
                offsetY = 0;
            } else {
                renderWidth = containerRect.width;
                renderHeight = renderWidth / videoAspect;
                offsetX = 0;
                offsetY = (containerRect.height - renderHeight) / 2;
            }

            this.videoRect = {
                top: offsetY + 'px',
                left: offsetX + 'px',
                width: renderWidth + 'px',
                height: renderHeight + 'px'
            };

            this.logoSize = (renderHeight * 0.08) + 'px';
        },

        toggleFullscreen() {
            const container = this.$refs.container;
            if (!document.fullscreenElement) {
                container.requestFullscreen().then(() => {
                    this.isFullscreen = true;
                    this.$nextTick(() => this.updateVideoRect());
                });
            } else {
                document.exitFullscreen().then(() => {
                    this.isFullscreen = false;
                    this.$nextTick(() => this.updateVideoRect());
                });
            }
        },

        loadSource(url) {
            const video = this.$refs.video;
            if (!url) return;

            if (this.hls) {
                this.hls.destroy();
                this.hls = null;
            }

            if (Hls.isSupported()) {
                this.hls = new Hls();
                this.hls.loadSource(url);
                this.hls.attachMedia(video);
            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                video.src = url;
            }
        },

        switchCamera(index) {
            if (index === this.activeIndex) return;

            const video = this.$refs.video;
            const currentTime = video.currentTime;
            const wasPlaying = !video.paused;

            this.activeIndex = index;
            this.activeClip = null;
            this.loadSource(this.sources[index].url);

            video.addEventListener('loadedmetadata', () => {
                video.currentTime = currentTime;
                if (wasPlaying) {
                    video.play();
                }
                this.updateVideoRect();
            }, { once: true });

            $wire.switchSource(index);
            this.showCameraMenu = false;
        },

        init() {
            const video = this.$refs.video;

            // Load initial source
            if (this.sources.length > 0) {
                this.loadSource(this.sources[this.activeIndex].url);
            }

            // Track play state and manage controls visibility
            video.addEventListener('play', () => {
                this.isPlaying = true;
                this.startControlsTimer();
            });
            video.addEventListener('pause', () => {
                this.isPlaying = false;
                this.cancelControlsTimer();
                this.showControls = true;
            });

            // Track time updates
            video.addEventListener('timeupdate', () => {
                this.currentTime = video.currentTime;
            });

            // Track duration
            video.addEventListener('loadedmetadata', () => {
                this.duration = video.duration;
                this.updateVideoRect();
            });
            video.addEventListener('durationchange', () => {
                this.duration = video.duration;
            });

            // Update video rect on resize
            video.addEventListener('resize', () => this.updateVideoRect());
            window.addEventListener('resize', () => this.updateVideoRect());

            // Handle fullscreen changes
            document.addEventListener('fullscreenchange', () => {
                this.isFullscreen = !!document.fullscreenElement;
                this.$nextTick(() => this.updateVideoRect());
            });

            // Show controls on mouse move (desktop)
            this.$refs.container.addEventListener('mousemove', () => {
                if (!this.isMobile) {
                    this.showControlsTemporarily();
                }
            });

            // Update isMobile on resize
            window.matchMedia('(max-width: 768px)').addEventListener('change', (e) => {
                this.isMobile = e.matches;
            });

            // Close camera menu on click outside
            document.addEventListener('click', (e) => {
                if (!this.$refs.cameraMenuContainer?.contains(e.target)) {
                    this.showCameraMenu = false;
                }
            });

            // Listen for external clip/video change events (from playlist)
            Livewire.on('play-clip', (data) => {
                if (data.url) {
                    this.activeClip = { streaming_url_hd: data.url };
                    this.playFromUrl(data.url);
                }
            });

            Livewire.on('play-main-video', (data) => {
                this.activeClip = null;
                this.playFromUrl(data.url || this.mainVideoUrl);
            });
        }
    }"
    x-ref="container"
    x-init="init()"
    :class="isFullscreen ? 'fixed inset-0 z-50' : 'aspect-video'"
>
    <video
        x-ref="video"
        id="video-{{ $match->id }}"
        class="w-full h-full cursor-pointer"
        playsinline
        @click="toggleControls()"
    ></video>

    {{-- Back to main video button (when viewing a clip) --}}
    <div
        x-show="activeClip"
        x-transition
        class="absolute z-20 top-4 left-4"
    >
        <button
            type="button"
            @click="switchToMainVideo()"
            class="flex items-center gap-2 px-3 py-2 bg-black/70 hover:bg-black/90 text-white text-sm rounded-lg transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            {{ __('sports::matches.back_to_match') }}
        </button>
    </div>

    {{-- Custom controls overlay --}}
    <div
        class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2 transition-opacity duration-300"
        :class="showControls ? 'opacity-100' : 'opacity-0 pointer-events-none'"
        :style="{ left: videoRect.left, width: videoRect.width, bottom: videoRect.top }"
        @mouseenter="cancelControlsTimer()"
        @mouseleave="isPlaying && startControlsTimer()"
    >

        {{-- Timeline with tag markers --}}
        <div class="relative w-full h-8 sm:h-6 mb-2 cursor-pointer group" @click.stop="seekTo($event)">
            {{-- Tag markers (above progress bar) --}}
            <template x-for="(tag, index) in tags" :key="tag.id">
                <div
                    class="absolute top-0 transform -translate-x-1/2 cursor-pointer z-10"
                    :style="{ left: getTagPosition(tag) + '%' }"
                    @click.stop="onTagClick(tag)"
                >
                    {{-- Marker dot --}}
                    <div class="w-4 h-4 sm:w-3 sm:h-3 bg-amber-500 rounded-full hover:bg-amber-400 hover:scale-125 transition-all shadow-lg"
                         :title="tag.description || ('Tag ' + (index + 1))">
                    </div>
                    {{-- Tooltip on hover --}}
                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-black/90 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity">
                        <span x-text="tag.description || ('Tag ' + (index + 1))"></span>
                        <span class="text-gray-400 ml-1" x-text="'(' + formatTime(tag.start_time) + ')'"></span>
                    </div>
                </div>
            </template>

            {{-- Progress bar background --}}
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-white/30 rounded-full group-hover:h-2 transition-all">
                {{-- Progress bar fill --}}
                <div
                    class="h-full bg-white rounded-full"
                    :style="{ width: (duration > 0 ? (currentTime / duration * 100) : 0) + '%' }"
                ></div>
            </div>
        </div>

        {{-- Controls row --}}
        <div class="flex items-center gap-3 sm:gap-2">
            {{-- Play/Pause --}}
            <button @click.stop="$refs.video.paused ? $refs.video.play() : $refs.video.pause()" class="text-white p-2 sm:p-1 hover:bg-white/20 rounded transition-colors">
                <svg x-show="!isPlaying" class="w-7 h-7 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                <svg x-show="isPlaying" class="w-7 h-7 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
            </button>

            {{-- Time display --}}
            <div class="text-white text-xs sm:text-sm font-mono">
                <span x-text="formatTime(currentTime)"></span>
                <span class="text-white/60">/</span>
                <span x-text="formatTime(duration)"></span>
            </div>

            {{-- Spacer --}}
            <div class="flex-1"></div>

            {{-- Mute --}}
            <button @click.stop="$refs.video.muted = !$refs.video.muted" class="text-white p-2 sm:p-1 hover:bg-white/20 rounded transition-colors">
                <svg class="w-6 h-6 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
            </button>

            {{-- Camera selector (moved here) --}}
            @if(count($this->videoSources) > 1)
                <div class="relative" x-ref="cameraMenuContainer">
                    <button
                        @click.stop="showCameraMenu = !showCameraMenu"
                        class="text-white p-2 sm:p-1 hover:bg-white/20 rounded transition-colors flex items-center gap-1"
                        :class="showCameraMenu ? 'bg-white/20' : ''"
                    >
                        <svg class="w-6 h-6 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs" x-text="activeIndex + 1"></span>
                    </button>

                    {{-- Camera dropdown menu --}}
                    <div
                        x-show="showCameraMenu"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute bottom-full right-0 mb-2 py-1 bg-black/90 rounded-lg shadow-lg min-w-[120px]"
                        @click.outside="showCameraMenu = false"
                    >
                        @foreach($this->videoSources as $index => $source)
                            <button
                                type="button"
                                @click="switchCamera({{ $index }})"
                                class="w-full px-2 py-1.5 text-left text-xs text-white hover:bg-white/20 flex items-center gap-1.5 transition-colors whitespace-nowrap"
                                :class="activeIndex === {{ $index }} ? 'bg-white/10' : ''"
                            >
                                <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                {{ $source['label'] }}
                                <svg x-show="activeIndex === {{ $index }}" class="w-3 h-3 ml-auto text-amber-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Fullscreen --}}
            <button @click.stop="toggleFullscreen()" class="text-white p-2 sm:p-1 hover:bg-white/20 rounded transition-colors">
                <svg x-show="!isFullscreen" class="w-6 h-6 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg>
                <svg x-show="isFullscreen" class="w-6 h-6 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z"/></svg>
            </button>
        </div>
    </div>

    {{-- Sponsor overlays - positioned on actual video area --}}
    <div
        class="sponsor-overlays absolute pointer-events-none"
        :style="{ top: videoRect.top, left: videoRect.left, width: videoRect.width, height: videoRect.height }"
    >
        @foreach($this->sponsors as $position => $sponsor)
            @if($sponsor?->active && $sponsor?->logo)
                <div class="sponsor-overlay absolute {{ match($position) {
                    'top_left' => 'top-[2%] left-[2%]',
                    'top_center' => 'top-[2%] left-1/2 -translate-x-1/2',
                    'top_right' => 'top-[2%] right-[2%]',
                    'bottom_left' => 'bottom-[10%] left-[2%]',
                    'bottom_center' => 'bottom-[10%] left-1/2 -translate-x-1/2',
                    'bottom_right' => 'bottom-[10%] right-[2%]',
                    default => ''
                } }}">
                    @if($sponsor->url)
                        <a href="{{ $sponsor->url }}" target="_blank" class="pointer-events-auto">
                            <img src="{{ Storage::disk('s3')->temporaryUrl($sponsor->logo, now()->addHour()) }}"
                                 alt="{{ $sponsor->name }}"
                                 class="object-contain opacity-80 hover:opacity-100 transition-opacity"
                                 :style="{ height: logoSize, width: 'auto' }"/>
                        </a>
                    @else
                        <img src="{{ Storage::disk('s3')->temporaryUrl($sponsor->logo, now()->addHour()) }}"
                             alt="{{ $sponsor->name }}"
                             class="object-contain opacity-80"
                             :style="{ height: logoSize, width: 'auto' }"/>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
