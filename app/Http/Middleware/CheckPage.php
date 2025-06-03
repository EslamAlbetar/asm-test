<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPage
{
    public function handle($request, Closure $next, $page)
    {
        $user = Auth::user();

        if ($user->usertype !== 'user') {
            return $next($request);
        }

        if ($user->authedPages && isset($user->authedPages->{$page}) && $user->authedPages->{$page}) {
            return $next($request);
        }


        abort(403);
    }
}
