<?php

namespace App\Http\Middleware;

use Closure;

class TrackAffiliate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $response = $next($request);
        $minutes = 132000; // 3 months

        if ($request->has('affiliate_id')) {
            $response->withCookie(cookie('affiliate_id', $request->get('affiliate_id'), $minutes));
        }

        return $response;
    }
}
