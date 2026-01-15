<?php

namespace Packages\Sports\SportClub\Http\Middleware;

use App\Models\Tenant\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSportClubConfigured
{
    public function handle(Request $request, Closure $next): Response
    {
        // Skip if already going to configuration page
        if (str_contains($request->path(), 'configuration')) {
            return $next($request);
        }

        // Check if sport club is configured
        $isConfigured = Setting::get('configured', 'sport-club', false);

        if (!$isConfigured) {
            // Use hardcoded URL because routes aren't available during middleware execution
            return redirect('/mikrowl/sport-club/configuration');
        }

        return $next($request);
    }
}
