<?php

namespace App\Http\Middleware;

use Closure;
use App\NIR;
use Illuminate\Support\Facades\Gate;

class CheckRightsToViewAndEditNIR
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
        $nir = $request->nir;
        if (Gate::allows('view_and_edit', $nir->company_id)) {
            return $next($request);
        } else {
            return back();
        }
    }
}
