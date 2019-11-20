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
use App\Article;
use App\Countries;
use App\Exports\NIRExport;
use App\Species;
use App\Moisture;
use App\NIRDetails;
use App\Invoice;
use App\Number;
use App\ReceptionCommittee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use domPDF;
use Maatwebsite\Excel\Facades\Excel;

class NIRController extends Controller
{
    /**
     * Display a listing of all the NIR's
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $company = $request->session()->get('company_was_selected');
            $nir = DB::table('nir')->join('suppliers', 'nir.supplier_id', '=', 'suppliers.id')
                ->join('vehicles', 'nir.vehicle_id', '=', 'vehicles.id')
                ->join('certifications', 'nir.certification_id', '=', 'certifications.id')
                ->where('company_id', $company)
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
                ->editColumn('data_nir', function ($nir) {
                    return $nir->data_nir ? with(new Carbon($nir->data_nir))->format('d.m.Y') : '';
                })
                ->editColumn('data_dvi', function ($nir) {
                    return $nir->data_dvi ? with(new Carbon($nir->data_dvi))->format('d.m.Y') : '';
                })
                ->editColumn('data_aviz', function ($nir) {
                    return $nir->data_aviz ? with(new Carbon($nir->data_aviz))->format('d.m.Y') : '';
                })
                ->addColumn('action', function ($nir) {
                    if(Gate::allows('user')) {
                        $view = '<a href="/nir/' . $nir->id . '/show"><i class="fa fa-eye"></i></a>';
                        $edit = '<a href="#" class="edit" id="' . $nir->id . '"data-toggle="modal" data-target="#nirForm"><i class="fa fa-edit"></i></a>';
                        return $view . ' ' . $edit;
                    } else {
                        return '<a href="/nir/' . $nir->id . '/show"><i class="fa fa-eye"></i></a>';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $company_name = CompanyInfo::where('id', session()->get('company_was_selected'))->pluck('name');
        $suppliers = Suppliers::all()->sortBy('name');
        $certifications = Certification::all()->sortBy('name');
        $vehicles = Vehicle::all()->sortBy('name');
        $articles = Article::all()->sortBy('name');
        $species = Species::all()->sortBy('name');
        $moistures = Moisture::all()->sortBy('name');
        return view('nir.index', ['company_name' => $company_name, 'suppliers' => $suppliers, 'certifications' => $certifications, 'vehicles' => $vehicles,
        'articles' => $articles, 'species' => $species, 'moistures' => $moistures]);
    }

    /**
     * Store a newly created NIR into the database including the coresponding details and invoice.
     *
     * @param  \App\NIR  $nir
     * @param  \App\NIRDetails  $nirDetails
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function store(NIR $nir, NIRDetails $nirDetails, Request $request, Number $number)
    {
        // // dd($this->validateRequestDetails()['article_id'][0]);
        // Get the company_id with which the user logged in
        $company = $request->session()->get('company_was_selected');
        // Check to see which nir number to use next
        $last_set_number = $number::latest()->where('company_id', $company)->first(['numar_nir', 'created_at']);
        $last_nir_number = $nir::latest()->where('company_id', $company)->first(['numar_nir', 'created_at']);
        if ($last_nir_number === null) {
            $new_nir = $last_set_number->numar_nir;
        }else if ($last_set_number->created_at->gt($last_nir_number->created_at)) {
            $new_nir = $last_set_number->numar_nir;
        } else {
            $new_nir = $last_nir_number->numar_nir + 1;
        }
        // Create the new NIR
        $nir = new NIR();
        $nir->company_id = $company;
        $nir->numar_nir = $new_nir;
        $nir->data_nir = $this->validateRequest()['data_nir'];
        $nir->numar_we = $this->validateRequest()['numar_we'];
        $nir->supplier_id = $this->validateRequest()['supplier_id'];
        $nir->dvi = $this->validateRequest()['dvi'];
        $nir->data_dvi = $this->validateRequest()['data_dvi'];
        $nir->greutate_bruta = $this->validateRequest()['greutate_bruta'];
        $nir->greutate_neta = $this->validateRequest()['greutate_neta'];
        $nir->serie_aviz = $this->validateRequest()['serie_aviz'];
        $nir->numar_aviz = $this->validateRequest()['numar_aviz'];
        $nir->data_aviz = $this->validateRequest()['data_aviz'];
        $nir->specificatie = $this->validateRequest()['specificatie'];
        $nir->vehicle_id = $this->validateRequest()['vehicle_id'];
        $nir->numar_inmatriculare = $this->validateRequest()['numar_inmatriculare'];
        $nir->certification_id = $this->validateRequest()['certification_id'];
        $nir->user_id = auth()->user()->id;
        $nir->save();
        // get the id of the created record
        $nir_id = $nir->id;

        // Add details to the NIR
        if ($request->article_id[0] !== null && $request->species_id[0] !== null && $request->moisture_id[0] !== null) {
            for ($i=0; $i < count($request->article_id); $i++) {
                $nirDetails->create([
                    'nir_id' => $nir_id,
                    'article_id' => $this->validateRequestDetails()['article_id'][$i],
                    'species_id' => $this->validateRequestDetails()['species_id'][$i],
                    'volum_aviz' => $this->validateRequestDetails()['volum_aviz'][$i],
                    'volum_receptionat' => $this->validateRequestDetails()['volum_receptionat'][$i],
                    'moisture_id' => $this->validateRequestDetails()['moisture_id'][$i],
                    'pachete' => $this->validateRequestDetails()['pachete'][$i],
                    'total_ml' => $this->validateRequestDetails()['total_ml'][$i],
                    'user_id' => auth()->user()->id
                ]);
            }
        } else {
            $request->session()->flash('details_error', 'Nu au fost adaugate detalii la NIR deoarece campurile necesare nu au fost completate!');
            return back();
        }

        // Add the invoice to the NIR
        if (!$request->invoice_to_add) {
            // Do nothing, no validation required
        } elseif ($request->filled('numar_factura', 'data_factura', 'valoare_factura', 'valoare_transport')) {
            // Save the invoice data
            $invoice = new Invoice();
            $invoice->nir_id = $nir_id;
            $invoice->numar_factura = $request->numar_factura;
            $invoice->data_factura = $request->data_factura;
            $invoice->valoare_factura = $request->valoare_factura;
            $invoice->valoare_transport = $request->valoare_transport;
            $invoice->user_id = auth()->user()->id;
            $invoice->save();
        } else {
            $request->session()->flash('invoice_error', 'Deoarece nu au fost completate toate campurile factura nu a fost adaugata pe NIR!');
            return back();
        }

        return redirect('/nir');
    }

    /**
     * Display the specified NIR.
     *
     * @param  \App\NIR  $nir
     * @return \Illuminate\Http\Response
     */
    public function show(NIR $nir)
    {
        $nir_details = DB::table('nir_details')->join('articles', 'nir_details.article_id', '=', 'articles.id')
            ->join('species', 'nir_details.species_id', '=', 'species.id')
            ->join('moisture', 'nir_details.moisture_id', '=', 'moisture.id')
            ->where('nir_id', $nir->id)
            ->select([
                'nir_details.id as id',
                'articles.name as article',
                'species.name as species',
                'moisture.name as moisture',
                'nir_details.volum_aviz as volum_aviz',
                'nir_details.volum_receptionat as volum_receptionat',
                'nir_details.pachete as pachete',
                'nir_details.total_ml as total_ml'
            ])->get();

        $total_aviz = 0;
        $total_receptionat = 0;
        $total_pachete = 0;
        $total_ml = 0;

        foreach ($nir_details as $details) {
            $total_aviz += $details->volum_aviz;
        }

        foreach ($nir_details as $details) {
            $total_receptionat += $details->volum_receptionat;
        }

        foreach ($nir_details as $details) {
            $total_pachete += $details->pachete;
        }

        foreach ($nir_details as $details) {
            $total_ml += $details->total_ml;
        }


        $articles = Article::all()->sortBy('name');
        $species = Species::all()->sortBy('name');
        $moistures = Moisture::all()->sortBy('name');
        $company = CompanyInfo::where('id', $nir->company_id)->value('name');
        $invoice = Invoice::where('nir_id', $nir->id)->get();
        $supplier = Suppliers::where('id', $nir->supplier_id)->value('name');
        $vehicle = Vehicle::where('id', $nir->vehicle_id)->value('name');
        $certification = Certification::where('id', $nir->certification_id)->value('name');
        return view('nir.nir',
                    [
                        'nir' => $nir,
                        'company' => $company,
                        'invoice' => $invoice,
                        'supplier' => $supplier,
                        'vehicle' => $vehicle,
                        'certification' => $certification,
                        'nir_details' =>$nir_details,
                        'total_aviz' => $total_aviz,
                        'total_receptionat' => $total_receptionat,
                        'total_pachete' => $total_pachete,
                        'total_ml' => $total_ml,
                        'articles' => $articles,
                        'species' => $species,
                        'moistures' => $moistures
                    ]);
    }

    /**
     * Fetch the NIR data in JSON format.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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
     * @param  \App\NIR  $nir
     * @return \Illuminate\Http\Response
     */
    public function update(NIR $nir)
    {
        $nir->update($this->validateRequest());

        return redirect('/nir');
    }
    /**
     * Print the NIR page
     *
     * @param App\NIR
     * @return mixed
     */
    public function printNIR(NIR $nir)
    {
        $nir_details = DB::table('nir_details')->join('articles', 'nir_details.article_id', '=', 'articles.id')
            ->join('species', 'nir_details.species_id', '=', 'species.id')
            ->join('moisture', 'nir_details.moisture_id', '=', 'moisture.id')
            ->where('nir_id', $nir->id)
            ->select([
                'nir_details.id as id',
                'articles.name as article',
                'species.name as species',
                'moisture.name as moisture',
                'nir_details.volum_aviz as volum_aviz',
                'nir_details.volum_receptionat as volum_receptionat',
                'nir_details.pachete as pachete',
                'nir_details.total_ml as total_ml'
            ])->get();

        $total_aviz = 0;
        $total_receptionat = 0;
        $total_pachete = 0;
        $total_ml = 0;

        foreach ($nir_details as $details) {
            $total_aviz += $details->volum_aviz;
        }

        foreach ($nir_details as $details) {
            $total_receptionat += $details->volum_receptionat;
        }

        foreach ($nir_details as $details) {
            $total_pachete += $details->pachete;
        }

        foreach ($nir_details as $details) {
            $total_ml += $details->total_ml;
        }

        $company = CompanyInfo::where('id', $nir->company_id)->get();
        $supplier = Suppliers::where('id', $nir->supplier_id)->get();
        $country = Countries::where('id', $supplier[0]->country_id)->value('name');
        $vehicle = Vehicle::where('id', $nir->vehicle_id)->value('name');
        $invoice = Invoice::where('nir_id', $nir->id)->get();
        $invoice_count = Invoice::where('nir_id', $nir->id)->count();
        // get the active reception committee for the current mill
        $reception_committee = ReceptionCommittee::where('company_id', session()->get('company_was_selected'))->where('active', 1)->get();

        if($invoice_count === 0) {
            $invoice = null;
        }

        $data = [
            'company' => $company,
            'supplier' => $supplier,
            'country' => $country,
            'nir' => $nir,
            'vehicle' => $vehicle,
            'invoice' => $invoice,
            'nir_details' => $nir_details,
            'total_aviz' => $total_aviz,
            'total_receptionat' => $total_receptionat,
            'total_pachete' => $total_pachete,
            'total_ml' => $total_ml,
            'reception_committee' => $reception_committee
        ];

        $pdf = domPDF::loadView('nir.print', $data);
        return $pdf->stream();
    }

    /**
     * Display page to select nir to print
     *
     * @param  null
     * @return \Illuminate\Http\Response
     */
    public function showPrintNIRPage()
    {
        return view('nir.selection');
    }

    /**
     * Generate PDF's for multiple NIR
     *
     * @param Illuminate\Http\Request
     * @return mixed
     */
    public function printMultipleNIR(Request $request)
    {
        $company_id = session()->get('company_was_selected');
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $nir = DB::table('nir')
            ->join('company_info', 'nir.company_id', '=', 'company_info.id')
            ->join('suppliers', 'nir.supplier_id', '=', 'suppliers.id')
            ->join('countries', 'suppliers.country_id', '=', 'countries.id')
            ->join('vehicles', 'nir.vehicle_id', '=', 'vehicles.id')
            ->leftJoin('invoices', 'invoices.nir_id', '=', 'nir.id')
            ->where('company_id', $company_id)
            ->whereBetween('data_nir', [$from_date, $to_date])
            ->select([
                'nir.id as id',
                'nir.numar_nir as numar_nir',
                'company_info.name',
                'company_info.cui',
                'company_info.j',
                'company_info.address',
                'company_info.account_number',
                'company_info.bank',
                'nir.numar_nir',
                'nir.data_nir',
                'nir.numar_we',
                'suppliers.fibu as fibu',
                'suppliers.name as supplier',
                'suppliers.cui as supplier_cui',
                'suppliers.j as supplier_j',
                'suppliers.address as supplier_address',
                'countries.name as supplier_country',
                'nir.dvi',
                'nir.data_dvi',
                'nir.serie_aviz',
                'nir.numar_aviz',
                'nir.data_aviz',
                'nir.specificatie',
                'vehicles.name as vehicle',
                'nir.numar_inmatriculare',
                'invoices.numar_factura',
                'invoices.data_factura',
            ])->get()->toArray();
 
        $nir_count = count($nir);

        for ($i=0; $i < $nir_count; $i++) {
            $nir_details = DB::table('nir_details')->join('articles', 'nir_details.article_id', '=', 'articles.id')
                ->join('species', 'nir_details.species_id', '=', 'species.id')
                ->join('moisture', 'nir_details.moisture_id', '=', 'moisture.id')
                ->where('nir_id', $nir[$i]->id)
                ->select([
                    'nir_details.id as id',
                    'articles.name as article',
                    'species.name as species',
                    'moisture.name as moisture',
                    'nir_details.volum_aviz as volum_aviz',
                    'nir_details.volum_receptionat as volum_receptionat',
                    'nir_details.pachete as pachete',
                    'nir_details.total_ml as total_ml'
                ])->get();
            $totals = DB::table('nir_details')
                ->where('nir_id', $nir[$i]->id)
                ->select([
                    DB::raw('SUM(volum_aviz) as volum_aviz'),
                    DB::raw('SUM(volum_receptionat) as volum_receptionat'),
                ])->get();
            $nir[$i]->details = $nir_details;
            $nir[$i]->totals = $totals;
        }

        // get the active reception committee for the current mill
        $reception_committee = ReceptionCommittee::where('company_id', session()->get('company_was_selected'))->where('active', 1)->get();

        $data = [
            'nir' => $nir,
            'reception_committee' => $reception_committee
        ];

        $pdf = domPDF::loadView('nir.multiple', $data);
        return $pdf->stream();
    }

    /**
     * Validate NIR data before submission
     *
     * @return array
     */
    public function validateRequest()
    {
        $error_messages = [
            'company_id.required' => 'ID-ul companiei este necesar. Reincarcati pagina si incercati din nou!',
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

    /**
     * Validate NIR details data before submission
     *
     * @return array
     */
    public function validateRequestDetails()
    {
        $error_messages = [
            'article_id.required' => 'Selectati un articol!',
            'species_id.required' => 'Selectati o specie!',
            'volum_aviz.required' => 'Completati volumul de pe aviz!',
            'volum_receptionat.required' => 'Completati volumul de pe factura!',
            'moisture_id.required' => 'Selectati o umiditate!',
            'pachete.required' => 'Completati numarul de pachete!',
            'total_ml.required' => 'Completati lungimea totala pachete!',
        ];

        return request()->validate([
            'article_id' => 'required',
            'species_id' => 'required',
            'volum_aviz' => 'required',
            'volum_receptionat' => 'required',
            'moisture_id' => 'required',
            'pachete' => 'required',
            'total_ml' => 'required',
        ], $error_messages);
    }

    /**
     * Show export
     * 
     * @return redirect;
     */
    public function showExport()
    {
       return view('nir.export');
    }

    /**
     * Export the data in excel format
     *
     * @param Illuminate\Http\Request;
     * @return App\Exports\NIRExport
     */
    public function export(Request $request)
    {
        $from = $request->from;
        $to = $request->to;

        $company = $request->session()->get('company_was_selected');
        $nir = DB::table('nir')->join('suppliers', 'nir.supplier_id', '=', 'suppliers.id')
            ->join('vehicles', 'nir.vehicle_id', '=', 'vehicles.id')
            ->join('certifications', 'nir.certification_id', '=', 'certifications.id')
            ->join('nir_details', 'nir.id', '=', 'nir_details.nir_id')
            ->join('species', 'nir_details.species_id', '=', 'species.id')
            ->join('articles', 'nir_details.article_id', '=', 'articles.id')
            ->join('moisture', 'nir_details.moisture_id', '=', 'moisture.id')
            ->where('company_id', $company)
            ->whereBetween('data_nir', [$from, $to])
            ->select([
                'nir.id as id',
                'nir.company_id as company_id',
                'nir.numar_nir as numar_nir',
                'nir.data_nir as data_nir',
                'nir.numar_we as numar_we',
                'suppliers.name as supplier',
                'nir.dvi as dvi',
                'nir.data_dvi as data_dvi',
                'nir.serie_aviz as serie_aviz',
                'nir.numar_aviz as numar_aviz',
                'nir.data_aviz as data_aviz',
                'nir.specificatie as specificatie',
                'vehicles.name as vehicle',
                'nir.numar_inmatriculare as numar_inmatriculare',
                'certifications.name as certificare',
                'species.name as specie',
                'articles.name as articol',
                'nir_details.volum_aviz as volum_aviz',
                'nir_details.volum_receptionat as volum_receptionat',
                'moisture.name as moisture',
            ])->get();

        $data = [];

        foreach ($nir as $nir) {
            $array = [
                'numar_nir' => $nir->numar_nir,
                'data_nir' => date("d.m.Y", strtotime($nir->data_nir)),
                'furnizor' => $nir->supplier,
                'dvi' => $nir->dvi,
                'data_dvi' => date("d.m.Y", strtotime($nir->data_dvi)),
                'serie_aviz' => $nir->serie_aviz,
                'numar_aviz' => $nir->numar_aviz,
                'data_aviz' => date("d.m.Y", strtotime($nir->data_aviz)),
                'specificatie' => $nir->specificatie,
                'numar_we' => $nir->numar_we,
                'vehicle' => $nir->vehicle,
                'numar_inmatriculare' => $nir->numar_inmatriculare,
                'specie' => $nir->specie,
                'articol' => $nir->articol,
                'volum_aviz' => $nir->volum_aviz,
                'volum_receptionat' => $nir->volum_receptionat,
                'moisture' => $nir->moisture,
                'certificare' => $nir->certificare,
            ];
            array_push($data, $array);
        }

        return Excel::download(new NIRExport($data), 'nir.xlsx');
    }
}
