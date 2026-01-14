<?php

namespace Packages\Sports\SportClub\Livewire;

use Livewire\Component;
use Packages\Sports\SportClub\Models\SportMatch;
use Livewire\Attributes\Computed;

class MatchViewer extends Component
{
    public SportMatch $match;

    public ?int $activeClipIndex = null;

    // Test data - in production this would come from the match model or API
    public array $testData = [];

    public function mount(SportMatch $match): void
    {
        $this->match = $match->load('sponsorPlacements.sponsor');

        // Load test data from JSON file for development
        $jsonPath = storage_path('app/test_evento_hipadel_legacy.json');
        if (file_exists($jsonPath)) {
            $this->testData = json_decode(file_get_contents($jsonPath), true) ?? [];
        }
    }

    #[Computed]
    public function mainVideo(): ?array
    {
        if (!empty($this->testData['video'])) {
            return [
                'url' => $this->testData['video']['streaming_url_hd'],
                'preview' => $this->testData['video']['preview_url'] ?? null,
                'title' => $this->testData['title'] ?? __('sports::matches.full_match'),
            ];
        }

        // Fallback to match video_url
        if ($this->match->video_url) {
            return [
                'url' => $this->match->video_url,
                'preview' => null,
                'title' => __('sports::matches.full_match'),
            ];
        }

        return null;
    }

    /**
     * Tags for the timeline - passed to VideoPlayer component
     */
    #[Computed]
    public function tags(): array
    {
        return $this->testData['tags'] ?? [];
    }

    /**
     * Clips for the VideoPlayer component (raw format for timeline markers)
     */
    #[Computed]
    public function clipsRaw(): array
    {
        return $this->testData['clips'] ?? [];
    }

    /**
     * Clips formatted for the playlist sidebar
     */
    #[Computed]
    public function clips(): array
    {
        if (empty($this->testData['clips'])) {
            return [];
        }

        return collect($this->testData['clips'])
            ->map(function ($clip, $index) {
                return [
                    'id' => $clip['id'],
                    'id_tag' => $clip['id_tag'] ?? null,
                    'url' => $clip['streaming_url_hd'],
                    'preview' => $clip['preview_url'] ?? null,
                    'title' => $clip['title'] ?? __('sports::matches.clip') . ' ' . ($index + 1),
                    'created_at' => $clip['created_at'] ?? null,
                ];
            })
            ->toArray();
    }

    public function playClip(int $index): void
    {
        $this->activeClipIndex = $index;
        $clip = $this->clips[$index] ?? null;

        if ($clip) {
            $this->dispatch('play-clip', url: $clip['url'], index: $index);
        }
    }

    public function playFullMatch(): void
    {
        $this->activeClipIndex = null;
        $this->dispatch('play-main-video', url: $this->mainVideo['url'] ?? null);
    }

    public function render()
    {
        return view('sports::livewire.match-viewer');
    }
}
