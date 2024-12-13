<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class GuestIdMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * Create UUID for guet id in session
         * Indentify a visitor
         * Add to cart
         * Perform to checkout order or shopping
         */
        if (!Session::has('guest_id')) {
            // set UUID as guest id in session for tracking cart items
            Session::put('guest_id', Str::uuid());
        }

        return $next($request);
    }
}
