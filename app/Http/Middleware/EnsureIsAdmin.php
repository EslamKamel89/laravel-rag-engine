<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin {
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if (!$request->user()) {
            return redirect()->route('admin.login');
        }
        if (!$request->user()?->is_admin) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
