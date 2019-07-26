<?php

namespace App\Http\Middleware;

use Closure;
use App\Invoice;

class CheckNumberOfInvoicesSaved
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
        $invoice = Invoice::where('nir_id', $request->nir_id)->get();
        if(count($invoice) !== 0) {
            return back();
        }
        return $next($request);
    }
}
