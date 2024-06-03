<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BlockCaptchaRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $blacklist = [
            'captcha',
            'captcha/api',

        ];
        $uri = $request->path();
        
        if(\in_array($uri, $blacklist)) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
