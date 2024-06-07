<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Jabatan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $jabatan): Response
    {
        // return $next($request);
        if(Auth::check()){
            $jabatan = explode('-', $jabatan);
            foreach($jabatan as $group){
                if(Auth::user()->jabatan == $group){
                return $next($request);
                
                }
            }
        }
        return redirect('/');
    }
}
