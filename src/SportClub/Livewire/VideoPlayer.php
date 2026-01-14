<?php

namespace Packages\Sports\SportClub\Livewire;

use Livewire\Component;
use Packages\Sports\SportClub\Models\SportMatch;
use Packages\Sports\SportClub\Enums\SponsorPosition;
use Livewire\Attributes\Computed;

class VideoPlayer extends Component
{
    public SportMatch $match;

    public int $activeSourceIndex = 0;

    /** @var array<int, array{id: int, id_tag_type: int, start_time: float, end_time: float, description: ?string}> */
    public array $tags = [];

    /** @var array<int, array{id: int, id_tag: int, streaming_url_hd: string, preview_url: ?string}> */
    public array $clips = [];

    /** Optional main video URL (when provided externally instead of from match) */
    public ?string $mainVideoUrl = null;

    public function mount(SportMatch $match, array $tags = [], array $clips = [], ?string $mainVideoUrl = null): void
    {
        $this->match = $match->load('sponsorPlacements.sponsor');
        $this->tags = $tags;
        $this->clips = $clips;
        $this->mainVideoUrl = $mainVideoUrl;
    }

    /**
     * Get the primary video URL (external or from match)
     */
    #[Computed]
    public function primaryVideoUrl(): ?string
    {
        return $this->mainVideoUrl ?? $this->match->video_url;
    }

    #[Computed]
    public function sponsors(): array
    {
        $sponsors = [];
        foreach (SponsorPosition::cases() as $position) {
            $placement = $this->match->sponsorPlacements
                ->firstWhere('position', $position);
            $sponsors[$position->value] = $placement?->sponsor;
        }
        return $sponsors;
    }

    #[Computed]
    public function videoSources(): array
    {
        // For now, return the same video twice for testing
        // In the future, this could come from match->video_sources relationship
        $baseUrl = $this->primaryVideoUrl;

        return [
            [
                'url' => $baseUrl,
                'label' => __('sports::matches.camera_1'),
                'icon' => 'cam-1',
            ],
            [
                'url' => $baseUrl, // Same video for testing
                'label' => __('sports::matches.camera_2'),
                'icon' => 'cam-2',
            ],
        ];
    }

    public function switchSource(int $index): void
    {
        $this->activeSourceIndex = $index;
        $this->dispatch('source-changed', index: $index);
    }

    public function render()
    {
        return view('sports::livewire.video-player');
    }
}
