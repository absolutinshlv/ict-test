<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanDeleteComment
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->comment?->user_id != auth()->id()) {
            abort(403);
        }
        return $next($request);
    }
}
