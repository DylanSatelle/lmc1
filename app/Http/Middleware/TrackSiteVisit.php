<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackSiteVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('get')) {
            DB::table('site_visits')->insert([
                'path' => '/',
                'visited_at' => now()->toDateTimeString(),
            ]);
        }

        return $next($request);
    }
}
