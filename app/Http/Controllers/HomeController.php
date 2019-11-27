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
        // get the company name
        $company_name = CompanyInfo::where('id', session()->get('company_was_selected'))->pluck('name');
        // return the view
        // dd($this->calculateAveragePriceLastMonth());
        return view('home', ['company_name' => $company_name, 'deliveries' => $deliveries]);
    }

    /**
     * Calculate the average for timber for the current month for external suppliers
     * 
     * @param
     * @return
     */
    public function calculateAveragePriceCurrentMonth()
    {
        $company_id = session()->get('company_was_selected');

        $now = Carbon::now();
        $first = $now->copy()->firstOfMonth()->format('Y-m-d');
        $last = $now->copy()->lastOfMonth()->format('Y-m-d');
        $nir_data = DB::table('nir')
            ->join('suppliers', 'nir.supplier_id', '=', 'suppliers.id')
            ->join('nir_details', 'nir_details.nir_id', '=', 'nir.id')
            ->leftJoin('invoices', 'invoices.nir_id', '=', 'nir.id')
            ->where('company_id', $company_id)
            ->where('suppliers.supplier_group_id', 2)
            ->whereBetween('data_nir', [$first, $last])
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

    /**
     * Calculate the average for timber for the current month for external suppliers
     * 
     * @param
     * @return
     */
    public function calculateAveragePriceLastMonth()
    {
        $company_id = session()->get('company_was_selected');

        $first = new Carbon('first day of last month');
        $first->startOfMonth()->format('Y-m-d');
        $last = new Carbon('last day of last month');
        $last->endOfMonth()->format('Y-m-d');
        $nir_data = DB::table('nir')
            ->join('suppliers', 'nir.supplier_id', '=', 'suppliers.id')
            ->join('nir_details', 'nir_details.nir_id', '=', 'nir.id')
            ->leftJoin('invoices', 'invoices.nir_id', '=', 'nir.id')
            ->where('company_id', $company_id)
            ->where('suppliers.supplier_group_id', 2)
            ->whereBetween('data_nir', [$first, $last])
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
