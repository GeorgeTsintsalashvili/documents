<?php

namespace App\Http\Middleware;

use Closure;

class CheckAge
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
        $age = (int) $request -> input('age');

        if($age < 18)
        {
          return redirect() -> route('restricted');
        }

        return $next($request);
    }
}
