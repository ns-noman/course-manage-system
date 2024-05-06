<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::guard('admin')->check())
        {
            return redirect('/admin/login')->with('error','Please Login First...');
        }
        // if(Auth::guard('admin')->user()->type != 'superadmin'){

        //     $routes = DB::table('menus')->select('menus.route')->get()->toArray();
        //     $routes = array_column($routes,'route');
        //     $currentRoute = \Route::current()->getName();
        //     $isRouteExist = in_array($currentRoute,$routes);
        //     if($isRouteExist)
        //     {
        //         $privileges = DB::table('privileges')
        //                 ->join('menus', function ($join) {
        //                     $join->on('privileges.menu_id', '=', 'menus.id');
        //                 })
        //                 ->where('privileges.role_id', Auth::guard('admin')->user()->type)
        //             ->select('menus.route')
        //             ->get()->toArray();

        //         $privileges = array_column($privileges,'route');
        //         $in_array = in_array($currentRoute,$privileges);

        //         if(!$in_array){
        //             return redirect()->back()->with('alert',['messageType'=>'danger','message'=>'You do not have permission to access this route!']);
        //         }
        //     }
        // }
        return $next($request);
    }
}
