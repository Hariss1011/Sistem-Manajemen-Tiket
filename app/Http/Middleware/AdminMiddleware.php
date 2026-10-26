<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->guest(route('login'));
        }

        abort_unless(auth()->user()->isAdmin(), 403, 'Halaman ini khusus admin.');

        return $next($request);
    }
}
