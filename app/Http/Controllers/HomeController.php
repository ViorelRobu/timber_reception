<?php

namespace App\Http\Controllers;

use App\Charts\DeliveriesCurrentYear;
use App\CompanyInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $company_id = session()->get('company_was_selected');
        // create a instance of the chart class
        $deliveries = new DeliveriesCurrentYear();
        // get the current date and set the beggining and end of year
        $now = Carbon::now();
        $startOfYear = $now->copy()->startOfYear()->format('Y-m-d');
        $endOfYear = $now->copy()->endOfYear()->format('Y-m-d');
        // get the nir data for the logged in company and the current year
        $nir_data = DB::table('nir')
            ->join('suppliers', 'nir.supplier_id', '=', 'suppliers.id')
            ->join('nir_details', 'nir_details.nir_id', '=', 'nir.id')
            ->where('company_id', $company_id)
            ->whereBetween('data_nir', [$startOfYear, $endOfYear])
            ->select([
                DB::raw('MONTH(nir.data_nir) as month'),
                'suppliers.name as supplier',
                DB::raw('SUM(nir_details.volum_receptionat) as volum')
            ])
            ->groupBy('suppliers.name')
            ->groupBy('month')
            ->get();
        // prepare the datasets
        $dataset = [];
        foreach ($nir_data as $nir) {
            $supplier = $nir->supplier;
            $dataset[$supplier] = [0,0,0,0,0,0,0,0,0,0,0,0];
        }
        foreach ($nir_data as $nir) {
            $supplier = $nir->supplier;
            $array_key_month = $nir->month - 1;
            $dataset[$supplier][$array_key_month] += $nir->volum; 
        }
        // set the chart labels
        // dd($dataset);
        $deliveries->labels(['ianuarie', 'februarie', 'martie', 'aprilie', 'mai', 'iunie', 'iulie', 'august', 'septembrie', 'octombrie', 'noiembrie', 'decembrie']);
        // pass the dataset to the chart
        foreach ($dataset as $key => $value) {
            $deliveries->dataset($key, 'bar', $value);
        }

        // Calculate average price current month
        $first_current_month = $now->copy()->firstOfMonth()->format('Y-m-d');
        $last_current_month = $now->copy()->lastOfMonth()->format('Y-m-d');
        $data_current_month = $this->calculateAveragePrice($first_current_month, $last_current_month);
        $current_month = ['volum' => 0, 'valoare' => 0];
        foreach ($data_current_month as $data) {
            $current_month['volum'] += $data->volum;
            $current_month['valoare'] += $data->valoare_factura + $data->transport;
        }

        // Calculate average price last month
        $last_month_first = new Carbon('first day of last month');
        $last_month_first->startOfMonth()->format('Y-m-d');
        $last_month_last = new Carbon('last day of last month');
        $last_month_last->endOfMonth()->format('Y-m-d');
        $data_last_month = $this->calculateAveragePrice($last_month_first, $last_month_last);
        $last_month = ['volum' => 0, 'valoare' => 0];
        foreach ($data_last_month as $data) {
            $last_month['volum'] += $data->volum;
            $last_month['valoare'] += $data->valoare_factura + $data->transport;
        }

        // get the company name
        $company_name = CompanyInfo::where('id', session()->get('company_was_selected'))->pluck('name');
        // return the view
        // dd($data_last_month);
        return view('home', [
                        'company_name' => $company_name, 
                        'deliveries' => $deliveries, 
                        'current_month' => $current_month, 
                        'data_current_month' => $data_current_month,
                        'last_month' => $last_month, 
                        'data_last_month' => $data_last_month,
                    ]);
    }

    /**
     * Calculate the average for timber for the external suppliers for a given time period
     * 
     * @param $from - beginning date
     * @param $to - end date
     * @return collection
     */
    public function calculateAveragePrice($from, $to)
    {
        $company_id = session()->get('company_was_selected');

        $nir_data = DB::table('nir')
            ->join('suppliers', 'nir.supplier_id', '=', 'suppliers.id')
            ->join('nir_details', 'nir_details.nir_id', '=', 'nir.id')
            ->leftJoin('invoices', 'invoices.nir_id', '=', 'nir.id')
            ->where('company_id', $company_id)
            ->where('suppliers.supplier_group_id', 2)
            ->whereBetween('data_nir', [$from, $to])
            ->select([
                'suppliers.name as supplier',
                DB::raw('SUM(nir_details.volum_receptionat) as volum'),
                DB::raw('SUM(invoices.valoare_factura) as valoare_factura'),
                DB::raw('SUM(invoices.valoare_transport) as transport')
            ])
            ->groupBy('suppliers.name')
            ->get();

        return $nir_data;
    }

}
