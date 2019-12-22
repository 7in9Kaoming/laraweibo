<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // 已登录用户访问登录或注册页面时，自动跳转到首页
        if (Auth::guard($guard)->check()) {
            session()->flash('info', '您已登录，无需再操作');
            return redirect('/');
        }

        return $next($request);
    }
}
