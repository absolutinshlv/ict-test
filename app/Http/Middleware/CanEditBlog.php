<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanEditBlog
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->blog?->user_id != auth()->id()) {
            abort(403);
        }
        return $next($request);
    }
}
