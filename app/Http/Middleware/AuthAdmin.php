<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Session};
use Closure;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check())
        {
            if(Auth::user()->utype==='ADM')
            {
                return $next($request);
            }
            else
            {
                Session::flush();
                return redirect()->route('login');
            }

        }
        else{
            return redirect()->route('login');
        }

    }
}
