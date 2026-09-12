<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only track for regular GET webpage requests (skip admin, api, ajax, asset requests)
        if (
            $request->isMethod('GET') &&
            !$request->ajax() &&
            !$request->is('admin*') &&
            !$request->is('api*') &&
            !$request->is('up')
        ) {
            $today = now()->toDateString();
            $sessionKey = 'visited_date_' . $today;

            if ($request->hasSession() && !$request->session()->has($sessionKey)) {
                $ip = $request->ip();

                try {
                    Visitor::firstOrCreate(
                        [
                            'ip_address' => $ip,
                            'visit_date' => $today,
                        ],
                        [
                            'session_id' => $request->session()->getId(),
                            'user_agent' => substr((string) $request->userAgent(), 0, 500),
                        ]
                    );

                    $request->session()->put($sessionKey, true);
                } catch (\Throwable $e) {
                    // Fail silently so visitor tracking never breaks user requests
                }
            }
        }

        return $next($request);
    }
}
