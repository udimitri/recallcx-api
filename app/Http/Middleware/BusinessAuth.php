<?php

namespace App\Http\Middleware;

use App\Models\Business;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var Business $business */
        $business = $request->route('business');

        if ($business->owner_id !== $user->user_id) {
            abort(404);
        }

        return $next($request);
    }
}
