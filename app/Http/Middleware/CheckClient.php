<?php

namespace App\Http\Middleware;

use App\Http\Controllers\FuncController;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckClient{
    public function handle($request, Closure $next){
        $func = new FuncController();
        $user = Auth::user();
        if($user->usertype != "client"){
            Auth::logout();
            return $func->toRouteWithMessage("homeLogin", "Access Denied", "You have been logged out", "error");
        }
        return $next($request);
    }
}
