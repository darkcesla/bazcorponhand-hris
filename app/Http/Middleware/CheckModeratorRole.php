<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckModeratorRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role !== 'moderator') {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
