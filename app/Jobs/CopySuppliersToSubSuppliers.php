<?php

namespace App\Jobs;

use App\SubSupplier;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Suppliers;

class CopySuppliersToSubSuppliers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $suppliers = Suppliers::all();
        foreach ($suppliers as $supplier) {
            $sub = new SubSupplier();
            $sub->id = $supplier->id;
            $sub->supplier_id = $supplier->id;
            $sub->name = $supplier->name;
            $sub->country_id = $supplier->country_id;
            $sub->user_id = $supplier->user_id;
            $sub->save();
        }
    }
}
