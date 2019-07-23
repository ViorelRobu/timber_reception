<?php

namespace App\Http\Controllers;

use App\NIR;
use Illuminate\Http\Request;
use App\CompanyInfo;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Suppliers;
use App\Certification;
use App\Vehicle;

class NIRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $nir = DB::table('nir')->join('suppliers', 'nir.supplier_id', '=', 'suppliers.id')
                ->join('vehicles', 'nir.vehicle_id', '=', 'vehicles.id')
                ->join('certifications', 'nir.certification_id', '=', 'certifications.id')
                ->select([
                    'nir.id as id',
                    'nir.company_id as company_id', 
                    'nir.numar_nir as numar_nir',
                    'nir.data_nir as data_nir',
                    'nir.numar_we as numar_we',
                    'suppliers.name as supplier',
                    'nir.dvi as dvi',
                    'nir.data_dvi as data_dvi',
                    'nir.greutate_bruta as greutate_bruta',
                    'nir.greutate_neta as greutate_neta', 
                    'nir.serie_aviz as serie_aviz',
                    'nir.numar_aviz as numar_aviz',
                    'nir.data_aviz as data_aviz',
                    'nir.specificatie as specificatie',
                    'vehicles.name as vehicle',
                    'nir.numar_inmatriculare as numar_inmatriculare',
                    'certifications.name as certificare'
                ])->get();

            return DataTables::of($nir)
                ->addColumn('action', function ($nir) {
                    $view = '<a href="#"><i class="fa fa-eye"></i></a>';
                    $edit = '<a href="#" class="edit" id="' . $nir->id . '"data-toggle="modal" data-target="#nirForm"><i class="fa fa-edit">' . $nir->id . '</i></a>';
                    return $view . ' ' . $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $company_name = CompanyInfo::where('id', session()->get('company_was_selected'))->pluck('name');
        $suppliers = Suppliers::all()->sortBy('name');
        $certifications = Certification::all()->sortBy('name');
        $vehicles = Vehicle::all()->sortBy('name');
        return view('nir.index', ['company_name' => $company_name, 'suppliers' => $suppliers, 'certifications' => $certifications, 'vehicles' => $vehicles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NIR $nir)
    {
        // dd(request());
        $nir = auth()->user()->nirCreator()->create($this->validateRequest());
        return redirect('/nir');
    }

    public function fetchNIR(Request $request)
    {
        $nir = NIR::findOrFail($request->id);
        $output = [
            'numar_nir' => $nir->numar_nir,
            'data_nir' => $nir->data_nir,
            'numar_we' => $nir->numar_we,
            'supplier_id' => $nir->supplier_id,
            'dvi' => $nir->dvi,
            'data_dvi' => $nir->data_dvi,
            'greutate_bruta' => $nir->greutate_bruta,
            'greutate_neta' => $nir->greutate_neta,
            'serie_aviz' => $nir->serie_aviz,
            'numar_aviz' => $nir->numar_aviz,
            'data_aviz' => $nir->data_aviz,
            'specificatie' => $nir->specificatie,
            'vehicle_id' => $nir->vehicle_id,
            'numar_inmatriculare' => $nir->numar_inmatriculare,
            'certification_id' => $nir->certification_id,
        ];

        return json_encode($output);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NIR  $nIR
     * @return \Illuminate\Http\Response
     */
    public function update(NIR $nir)
    {
        $nir->update($this->validateRequest());

        return redirect('/nir');
    }

    public function validateRequest()
    {
        $error_messages = [
            'company_id.required' => 'ID-ul companiei este necesar. Reincarcati pagina si incercati din nou!',
            'numar_nir.required' => 'Completati numarul NIR!',
            'data_nir.required' => 'Completati data NIR!',
            'numar_we.sometimes' => 'Verificati numarul WE!',
            'supplier_id.required' => 'Selectati furnizorul din lista!',
            'dvi.sometimes' => 'Verificati numarul DVI!',
            'data_dvi.sometimes' => 'Verificati data DVI!',
            'greutate_bruta.sometimes' => 'Verificati greutatea bruta!',
            'greutate_neta.sometimes' => 'Verificati greutatea neta!',
            'serie_aviz.required' => 'Completati seria aviz!',
            'numar_aviz.required' => 'Completati numarul avizului!',
            'data_aviz.required' => 'Completati data avizului!',
            'specificatie.sometimes' => 'Verificati specificatia!',
            'vehicle_id.required' => 'Selectati mijlocul de tranport din lista!',
            'numar_inmatriculare.required' => 'Completati numarul numarul de inmatriculare!',
            'certification_id.required' => 'Selectati certificarea marfii livrata!'            
        ];

        return request()->validate([
            'company_id' => 'required',
            'numar_nir' => 'required',
            'data_nir' => 'required',
            'numar_we' => 'sometimes',
            'supplier_id' => 'required',
            'dvi' => 'sometimes',
            'data_dvi' => 'sometimes',
            'greutate_bruta' => 'sometimes',
            'greutate_neta' => 'sometimes',
            'serie_aviz' => 'required',
            'numar_aviz' => 'required',
            'data_aviz' => 'required',
            'specificatie' => 'sometimes',
            'vehicle_id' => 'required',
            'numar_inmatriculare' => 'required',
            'certification_id' => 'required'
        ], $error_messages);
    }
}
