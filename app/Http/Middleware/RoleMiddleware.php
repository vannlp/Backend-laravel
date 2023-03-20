<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $params)
    {
        if(!auth()->user()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không có quyền truy cập'
            ], 400);
        }
        foreach($params as $param) {
            if($param === auth()->user()->role->code) {
                return $next($request);
            }
        }


        return response()->json([
            'status' => 'error',
            'message' => 'Không có quyền truy cập'
        ], 400);
    }
}
