<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\CompanyInfo;
use Carbon\Carbon;

class InvoicesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $company = $request->session()->get('company_was_selected');
            $nir = DB::table('invoices')->join('nir', 'invoices.nir_id', '=', 'nir.id')
                ->join('suppliers', 'nir.supplier_id', '=', 'suppliers.id')
                ->join('certifications', 'nir.certification_id', '=', 'certifications.id')
                ->where('company_id', $company)
                ->select([
                    'invoices.id as id',
                    'nir.numar_nir as nir',
                    'nir.data_nir as data_nir',
                    'suppliers.name as supplier',
                    'invoices.numar_factura as numar_factura',
                    'invoices.data_factura as data_factura',
                    'invoices.valoare_factura as valoare_factura',
                    'invoices.valoare_transport as valoare_transport',
                    'nir.created_at as created_at'
                ])->orderBy('created_at', 'DESC')
                ->get();

            return DataTables::of($nir)
                ->editColumn('data_nir', function ($nir) {
                    return $nir->data_nir ? with(new Carbon($nir->data_nir))->format('d.m.Y') : '';
                })
                ->editColumn('data_factura', function ($nir) {
                    return $nir->data_factura ? with(new Carbon($nir->data_factura))->format('d.m.Y') : '';
                })
                ->addColumn('action', function ($nir) {
                    $edit = '<a href="#" class="edit" id="' . $nir->id . '"data-toggle="modal" data-target="#invoiceForm"><i class="fa fa-edit"></i></a>';
                    return $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $company_name = CompanyInfo::where('id', session()->get('company_was_selected'))->value('name');
        return view('invoices.index', ['company_name' => $company_name]);
    }

    public function store(Request $request)
    {
        $invoice = new Invoice();
        $invoice->nir_id = $request->nir_id;
        $invoice->numar_factura = $request->numar_factura;
        $invoice->data_factura = $request->data_factura;
        $invoice->valoare_factura = $request->valoare_factura;
        $invoice->valoare_transport = $request->valoare_transport;
        $invoice->user_id = auth()->user()->id;
        $invoice->save();

        return back();
    }

    public function update(Invoice $invoice, Request $request)
    {
        $invoice->nir_id = $request->nir_id;
        $invoice->numar_factura = $request->numar_factura;
        $invoice->data_factura = $request->data_factura;
        $invoice->valoare_factura = $request->valoare_factura;
        $invoice->valoare_transport = $request->valoare_transport;
        $invoice->user_id = auth()->user()->id;
        $invoice->save();

        return back();
    }

    public function destroy(Request $request)
    {
        $invoice = Invoice::findOrFail($request->delete_id);
        $invoice->delete();

        return back();
    }

    public function fetchInvoice(Request $request)
    {
        $invoice = Invoice::findOrFail($request->id);
        $output = [
            'nir_id' => $invoice->nir_id,
            'numar_factura' => $invoice->numar_factura,
            'data_factura' => $invoice->data_factura,
            'valoare_factura' => $invoice->valoare_factura,
            'valoare_transport' => $invoice->valoare_transport,
        ];

        return json_encode($output);
    }
}
