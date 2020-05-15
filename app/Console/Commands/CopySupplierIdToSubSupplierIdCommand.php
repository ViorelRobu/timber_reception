<?php

namespace App\Console\Commands;

use App\Jobs\CopySupplierIdToSubSupplierId;
use App\Jobs\CopySuppliersToSubSuppliers;
use Illuminate\Console\Command;

class CopySupplierIdToSubSupplierIdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy the supplier id to the sub-supplier column of nir table';

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
        dispatch(new CopySupplierIdToSubSupplierId());
    }
}
