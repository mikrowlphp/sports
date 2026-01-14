<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('sports::matches.match') }} - {{ $match->homeTeam?->name ?? $match->homePlayer?->name }} vs {{ $match->awayTeam?->name ?? $match->awayPlayer?->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-900 min-h-screen p-4">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-white text-xl font-bold mb-4 text-center">
            {{ $match->homeTeam?->name ?? $match->homePlayer?->name }}
            <span class="text-gray-400">vs</span>
            {{ $match->awayTeam?->name ?? $match->awayPlayer?->name }}
        </h1>

        <livewire:sports::match-viewer :match="$match" />

        <div class="mt-4 text-center">
            <p class="text-gray-500 text-sm">
                {{ $match->scheduled_at?->format('d/m/Y H:i') }} - {{ $match->court }}
            </p>
        </div>
    </div>

    @livewireScripts
</body>
</html>
