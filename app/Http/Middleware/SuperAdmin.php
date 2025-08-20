<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;

class SuperAdmin
{
    public $failStatus = 401;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!empty(Auth::guard('admin')->User()->role) && Auth::guard('admin')->User()->role != "Super Admin"){
            return redirect()->route('dashboard')->with('error', 'Plese select valid role');
        }  
        
        return $next($request);
    }
}
