<?php

namespace App\Http\Controllers;

use App\Claim;
use App\ClaimStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @param Request $request
     * @return Response
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $mill = $request->session()->get('company_was_selected');
            $table = DB::table('claims')
                ->join('suppliers', 'claims.supplier_id', '=', 'suppliers.id')
                ->join('claim_status', 'claims.claim_status_id', '=', 'claim_status.id')
                ->where('company_id', $mill)
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
                    return view('claims.partials.actions', ['data' => $table])->render();
                })
                ->editColumn('nir', function ($table) {
                    $nir_id_array = explode(',', $table->nir);
                    $nir_array = [];
                    foreach ($nir_id_array as $data) {
                        $nir = NIR::findOrFail(intval($data));
                        $nir_array[] = $nir->numar_nir;
                    }
                    return implode(', ',$nir_array);
                })
                ->editColumn('date', function ($table) {
                    return (new Carbon($table->date))->format('d.m.Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $suppliers = Suppliers::all();
        $status = ClaimStatus::all();

        return view('claims.index', ['suppliers' => $suppliers, 'status' => $status]);
    }

    /**
     * Fetch the data about the NIR for the claim
     *
     * @param Request $request
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
     * Fetch the data about a specific claim
     *
     * @param Request $request
     * @return json
     */
    public function fetch(Request $request)
    {
        $claim = Claim::findOrFail($request->id);
        $nir = explode(',', $claim->nir);
        $nir_data = [];
        $nir_id = [];
        foreach ($nir as $data) {
            $sn = NIR::find(intval($data));
            $invoice = Invoice::where('nir_id', intval($data))->get();
            $data_nir = (new Carbon($sn->data_nir))->format('d.m.Y');
            if (count($invoice) > 0) {
                $nir_data[] = 'NIR ' . $sn->numar_nir . ' din ' . $data_nir . ', factura ' . $invoice[0]->numar_factura . '/' . (new Carbon($invoice[0]->data_factura))->format('d.m.Y');
            } else {
                $nir_data[] = 'NIR ' . $sn->numar_nir . ' din ' . $data_nir;
            }
            $nir_id[] = intval($data);
        }
        $output = [
            'supplier_id' => $claim->supplier_id,
            'claim_date' => $claim->claim_date,
            'nir' => $nir_data,
            'nir_id' => $nir_id,
            'defects' => $claim->defects,
            'claim_amount' => $claim->claim_amount,
            'claim_value' => $claim->claim_value,
            'claim_currency' => $claim->claim_currency,
            'observations' => $claim->observations,
        ];
        return json_encode($output);

    }

    /**
     * Persist the data inside the database
     *
     * @return redirect
     */
    public function store(Claim $claim, Request $request)
    {
        $claim->supplier_id = $this->validateRequest()['supplier_id'];
        $claim->company_id = $request->session()->get('company_was_selected');;
        $claim->claim_date = $this->validateRequest()['claim_date'];
        $claim->nir = implode(',', $this->validateRequest()['nir']);
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
     * Update the claim status
     *
     * @param Claim $claim
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateStatus(Claim $claim, Request $request)
    {
        $claim->claim_status_id = $request->claim_status_id;
        $claim->save();

        return back();
    }

    /**
     * Update the data inside the database
     *
     * @return redirect
     */
    public function update(Claim $claim)
    {
        $claim->supplier_id = $this->validateRequest()['supplier_id'];
        $claim->claim_date = $this->validateRequest()['claim_date'];
        $claim->nir = implode(',', $this->validateRequest()['nir']);
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
     * Deletes the entry from the database
     *
     * @return redirect
     */
    public function destroy(Claim $claim)
    {
        $claim->delete();
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
