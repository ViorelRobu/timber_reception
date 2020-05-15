<?php

namespace App\Console\Commands;

use App\Jobs\CopySuppliersToSubSuppliers;
use Illuminate\Console\Command;

class CopySuppliersToSubSuppliersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:suppliers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy the suppliers into the sub-suppliers table';

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
        dispatch(new CopySuppliersToSubSuppliers());
    }
}
