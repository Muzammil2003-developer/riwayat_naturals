<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visit;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $url = $request->fullUrl();
        $userAgent = $request->userAgent();

        $key = 'visit_' . $ip . '_' . date('Y-m-d');

        if (!session()->has($key)) {
            Visit::create([
                'ip_address' => $ip,
                'url' => $url,
                'user_agent' => $userAgent,
            ]);
            session()->put($key, true);
        }

        return $next($request);
    }
}