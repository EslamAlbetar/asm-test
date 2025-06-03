<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class receptionist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // اذا لم يكن المستخدم بلس وحاول الوصول 
        // لصفحة المستخدم بلس يتحول تلقائيًا الى صفحة الضيف
        if (Auth::user()->usertype != 'receptionist') {
            return redirect('/');
        }

        return $next($request);
    }
}
