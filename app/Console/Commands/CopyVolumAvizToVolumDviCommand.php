<?php

namespace App\Console\Commands;

use App\Jobs\CopyVolumAvizToVolumDvi;
use Illuminate\Console\Command;

class CopyVolumAvizToVolumDviCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:volum_aviz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy volum aviz to volum dvi column';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dispatch(new CopyVolumAvizToVolumDvi());
    }
}
