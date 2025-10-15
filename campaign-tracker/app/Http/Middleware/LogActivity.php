<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if (Auth::check()) {
            DB::table('activity_logs')->insert([
                'user_id' => Auth::id(),
                'action' => $request->route()?->getName() ?? 'unknown',
                'ip_address' => $request->ip(),
                'user_agent' => (string) $request->userAgent(),
                'payload' => json_encode([
                    'method' => $request->method(),
                    'path' => $request->path(),
                ]),
                'created_at' => now(),
            ]);
        }
        return $response;
    }
}
