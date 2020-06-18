<?php

namespace App\Http\Controllers;

use App\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Suppliers;
use App\NIR;
use App\Invoice;
use Carbon\Carbon;

class ClaimsController extends Controller
{
    /**
     * Display a listing of all claims
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $table = DB::table('claims')
                ->join('suppliers', 'claims.supplier_id', '=', 'suppliers.id')
                ->join('claim_status', 'claims.claim_status_id', '=', 'claim_status.id')
                ->select([
                    'claims.id as id',
                    'suppliers.name as name',
                    'claims.claim_date as date',
                    'claims.nir as nir',
                    'claims.defects as defects',
                    'claims.claim_amount as amount',
                    'claims.claim_value as value',
                    'claims.claim_currency as currency',
                    'claim_status.status as status',
                    'claims.observations as observations',
                    'claims.resolution as resolution',

                    ])->get();
            return DataTables::of($table)
                ->addIndexColumn()
                ->addColumn('action', function ($table) {
                    $edit = '<a href="#" class="edit" id="' . $table->id . '"data-toggle="modal" data-target="#claimStatusForm"><i class="fa fa-edit"></i></a>';
                    return $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $suppliers = Suppliers::all();

        return view('claims.index', ['suppliers' => $suppliers]);
    }

    /**
     * Fetch the data about the NIR for the claim
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function fetchNIR(Request $request)
    {
        $company = $request->session()->get('company_was_selected');
        $nir = NIR::where('company_id', $company)->where('supplier_id', $request->supplier_id)->whereBetween('data_nir', [$request->start, $request->end])->get();
        $output = [];
        foreach ($nir as $data) {
            $invoice = Invoice::where('nir_id', $data->id)->get();
            $data_nir = (new Carbon($data->data_nir))->format('d.m.Y');
            if (count($invoice) > 0) {
                $output[$data->id] = 'NIR ' . $data->numar_nir . ' din ' . $data_nir . ', factura ' . $invoice[0]->numar_factura . '/' . (new Carbon($invoice[0]->data_factura))->format('d.m.Y');
            } else {
                $output[$data->id] = 'NIR ' . $data->numar_nir . ' din ' . $data_nir;
            }
        }

        return json_encode($output);

    }

    /**
     * Persist the data inside the database
     *
     * @return redirect
     */
    public function store(Claim $claim)
    {
        $claim->supplier_id = $this->validateRequest()['supplier_id'];
        $claim->claim_date = $this->validateRequest()['claim_date'];
        $claim->nir = implode(', ', $this->validateRequest()['nir']);
        $claim->defects = $this->validateRequest()['defects'];
        $claim->claim_amount = $this->validateRequest()['claim_amount'];
        $claim->claim_value = $this->validateRequest()['claim_value'];
        $claim->claim_currency = $this->validateRequest()['claim_currency'];
        $claim->observations = $this->validateRequest()['observations'];
        $claim->claim_status_id = 1;
        $claim->user_id = auth()->user()->id;
        $claim->save();

        return back();
    }

    /**
     * Validate NIR data before submission
     *
     * @return array
     */
    public function validateRequest()
    {
        $error_messages = [
            'supplier_id.required' => 'Selectati un furnizor.',
            'claim_date.required' => 'Selectati data reclamatiei.',
            'nir.required' => 'Selectati cel putin un NIR.',
            'defects.required' => 'Introduceti defectele reclamate.',
            'claim_amount.required' => 'Introduceti cantitatea reclamata.',
            'claim_value.sometimes' => 'Introduceti valoarea reclamatiei.',
            'claim_currency.required' => 'Selectati o moneda.',
            'observations.sometimes' => 'Adaugati observatiile.'
        ];

        return request()->validate([
            'supplier_id' => 'required',
            'claim_date' => 'required',
            'nir' => 'required',
            'defects' => 'required',
            'claim_amount' => 'required',
            'claim_value' => 'required',
            'claim_currency' => 'required',
            'observations' => 'sometimes',
        ], $error_messages);
    }
}
