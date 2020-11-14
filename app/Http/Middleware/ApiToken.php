<?php

namespace App\Http\Middleware;

use Closure;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header("x-api-key") != env('API_TOKEN')) {
            return response()->json(['type' => 'error', 'message' => 'Unauthorized access dddddd'], 401);
        }
        
        return $next($request);
    }
}
