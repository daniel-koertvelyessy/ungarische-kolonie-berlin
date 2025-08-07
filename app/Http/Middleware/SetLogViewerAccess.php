<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

final class SetLogViewerAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            Log::alert('Attempt to access log-viewer from non-authed user', ['data' => $request]);

            return redirect()->route('dashboard');
        }

        if (! $request->user()->is_admin) {
            Log::alert('Attempt to access log-viewer without Admin privileges', ['user' => $request->user()]);

            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
