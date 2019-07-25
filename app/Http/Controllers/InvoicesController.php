<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;

class InvoicesController extends Controller
{

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
            'numar_factura' => $invoice->numar_factura,
            'data_factura' => $invoice->data_factura,
            'valoare_factura' => $invoice->valoare_factura,
            'valoare_transport' => $invoice->valoare_transport,
        ];

        return json_encode($output);
    }
}
