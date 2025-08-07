<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

final class StoreFinancialYearSessionAfterLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {

            if (! session()->has('financialYear')) {

                Session::put('financialYear', Carbon::today('Europe/Berlin')->yearIso);
            }

        }

        return $next($request);
    }
}
