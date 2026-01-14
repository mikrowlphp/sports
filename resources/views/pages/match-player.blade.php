<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('sports::matches.match') }} - {{ $match->homeTeam?->name ?? $match->homePlayer?->name }} vs {{ $match->awayTeam?->name ?? $match->awayPlayer?->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-4xl">
        <h1 class="text-white text-xl font-bold mb-4 text-center">
            {{ $match->homeTeam?->name ?? $match->homePlayer?->name }}
            <span class="text-gray-400">vs</span>
            {{ $match->awayTeam?->name ?? $match->awayPlayer?->name }}
        </h1>

        @if($match->video_url)
            <livewire:sports::video-player :match="$match" />
        @else
            <div class="bg-gray-800 rounded-lg p-8 text-center">
                <p class="text-gray-400">{{ __('sports::matches.no_video_available') }}</p>
            </div>
        @endif

        <div class="mt-4 text-center">
            <p class="text-gray-500 text-sm">
                {{ $match->scheduled_at?->format('d/m/Y H:i') }} - {{ $match->court }}
            </p>
        </div>
    </div>
</body>
</html>
