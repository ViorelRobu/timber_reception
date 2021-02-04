<?php

namespace App\Jobs;

use App\NIRDetails;
use App\OrderDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CopyVolumAvizToVolumDvi implements ShouldQueue
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
        $details = NIRDetails::all();

        foreach ($details as $detail) {
            $detail->volum_dvi = $detail->volum_aviz;
            $detail->save();
        }
    }
}
