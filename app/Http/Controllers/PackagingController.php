<?php

namespace App\Http\Controllers;

use App\Article;
use App\Exports\PackagingExport;
use App\NIR;
use App\NIRDetails;
use App\PackagingData;
use App\PackagingMain;
use App\PackagingPerSupplier;
use App\PackagingSub;
use App\Suppliers;
use App\Traits\Translatable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class PackagingController extends Controller
{
    use Translatable;

    protected $dictionary = [
        'user_id' => ['utilizator', 'App\User', 'name'],
        'main_id' => ['grupa parinte', 'App\PackagingMain', 'name'],
        'company_id' => ['firma', 'App\CompanyInfo', 'name'],
        'supplier_id' => ['furnizor', 'App\Suppliers', 'name'],
        'subgroup_id' => ['subgrupa ambalaj', 'App\PackagingSub', 'name'],
    ];

    /**
     * Display a listing packaging_main_group.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $company = request()->session()->get('company_was_selected');
            $main = DB::table('packaging_data')
                ->where('company_id', $company)
                ->join('nir', 'packaging_data.nir_id', '=', 'nir.id')
                ->join('sub_suppliers', 'nir.supplier_id', '=', 'sub_suppliers.id')
                ->select([
                    'packaging_data.id as id',
                    'packaging_data.nir_id as nir_id',
                    'nir.numar_nir as nir',
                    'nir.data_nir as data_nir',
                    'sub_suppliers.name as supplier',
                    'packaging_data.packaging_data as data',
                    'nir.created_at as created_at'
                ])->orderBy('created_at', 'DESC')
                ->get();

            return DataTables::of($main)
                ->editColumn('data_nir', function ($main) {
                    return $main->data_nir ? with(new Carbon($main->data_nir))->format('d.m.Y') : '';
                })
                ->editColumn('data', function ($main) {
                    return $this->decodePackagingDataJson($main->data);
                })
                ->addColumn('action', function ($main) {
                    if (Gate::allows('admin')) {
                        $edit = '<a href="#" class="update" id="' . $main->id . '" data-toggle="modal" data-target="#recalculateForm"><i class="fa fa-play"></i></a>';
                        $history = '<a href="#" class="history" id="' . $main->id . '" data-toggle="modal" data-target="#packagingHistory"> <i class="fa fa-history"></i></a>';
                        return $history . ' ' . $edit;
                    } else if (Gate::allows('user')) {
                        $edit = '<a href="#" class="update" id="' . $main->id . '" data-toggle="modal" data-target="#recalculateForm"><i class="fa fa-play"></i></a>';
                        return $edit;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('packaging.index');
    }

    /**
     * Fetch the history data via ajax for the selected packaging data
     *
     * @param Request $request
     * @return json
     */
    public function fetchHistory(Request $request)
    {
        $packagingData = PackagingData::findOrFail($request->id);
        $audits = $packagingData->audits;

        $data = [];

        foreach ($audits as $audit) {

            if ($audit->old_values == null) {
                $old = null;
            } else {
                $old = $this->decodePackagingDataJson($audit->old_values['packaging_data']);
            }

            $array = [
                'user' => $audit->user->name,
                'event' => $audit->event,
                'old_values' => $old,
                'new_values' => $this->decodePackagingDataJson($audit->new_values['packaging_data']),
                'created_at' => $audit->created_at->toDateTimeString()
            ];

            array_push($data, $array);
        }

        return json_encode($data);

    }

    /**
     * Decode the data in JSON format for the packaging
     *
     * @param
     * @return mixed
     */
    public function decodePackagingDataJson($data)
    {
        $decoded = \json_decode($data, true);
        $array = [];
        foreach ($decoded as $data) {
            $nume = $data['subgroup_name'];
            $greutate = $data['greutate'];
            $concat_data = $nume . ' = '  . $greutate . ' kg';
            array_push($array, $concat_data);
        }

        return \implode(', ', $array);
    }

    /**
     * Export the packaging data in excel format for a given timeframe
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\PackagingMain $packagingMain
     * @return download Excel
     */
    public function exportPackagingData(Request $request, PackagingMain $packagingMain)
    {
        // select the logged in users company
        $company = session()->get('company_was_selected');

        // get the start and end period for report
        $from = $request->from;
        $to = $request->to;
        // get the NIR numbers for the set time period
        $nirInit = DB::table('nir')->whereBetween('data_nir', [$from, $to])->where('company_id', $company)->pluck('id')->toArray();
        // get the data for the headings
        $packagingMain = $packagingMain::all();
        $headings = ['Nr crt', 'Data', 'DVI', 'Furnizor', 'Articol'];

        foreach ($packagingMain as $data) {
            array_push($headings, $data->name);
        }
        // set the initial values for the packaging main groups
        $initial_values= [];
        foreach ($packagingMain as $data) {
            $initial_values[$data->id] = 0;
        }
        // calculate the values for each NIR
        $packaging = PackagingData::whereIn('nir_id', $nirInit)->get();
        $packaging_array = [];
        foreach ($packaging as $data) {
            // reinitialize weight data for each nir
            $weight = $initial_values;
            // sum the data
            $values = \json_decode($data->packaging_data, true);
            foreach ($values as $packaging) {
                $weight[$packaging['group']] += $packaging['greutate'];
            }
            // push the data to the packaging array
            array_push($packaging_array, ['nir' => $data->nir_id, 'weight' => $weight]);
        }

        // prepare data for export
        $export = [];
        $index = 1;
        foreach ($packaging_array as $array_data) {
            $nir = NIR::find($array_data['nir']);
            $supplier = Suppliers::find($nir->supplier_id);
            $nirDetails = NIRDetails::where('nir_id', $array_data['nir'])->get();
            $article = Article::find($nirDetails[0]->article_id);
            $dataset = [
                'index' => $index++,
                'data_nir' => date("d.m.Y", strtotime($nir->data_nir)),
                'dvi' => $nir->dvi,
                'supplier' => $supplier->name,
                'articol' => $article->name,
            ];
            foreach ($array_data['weight'] as $key => $value) {
                $dataset[$key] = $value;
            }
            array_push($export, $dataset);
        }

        // export data to excel
        return Excel::download(new PackagingExport($headings, $export), 'ambalaj.xlsx');
    }

    /**
     * Display a listing packaging_main_group.
     *
     * @return mixed
     */
    public function indexMain(Request $request)
    {
        if ($request->ajax()) {
            $main = DB::table('packaging_main_group')->get();

            return DataTables::of($main)
                ->addColumn('action', function ($main) {
                    if (Gate::allows('admin')) {
                        $edit = '<a href="#" class="edit" id="' . $main->id . '"data-toggle="modal" data-target="#addMainForm"><i class="fa fa-edit"></i></a>';
                        $history = '<a href="#" class="history" id="' . $main->id . '" data-toggle="modal" data-target="#packagingHistory"> <i class="fa fa-history"></i></a>';
                        return $history . " " . $edit;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('packaging.main');
    }

    /**
     * Fetch the modification history
     *
     * @param Request $request
     * @return json
     */
    public function fetchHistoryMain(Request $request)
    {
        $company = PackagingMain::findOrFail($request->id);
        $audits = $company->audits;

        $data = [];

        foreach ($audits as $audit) {

            $old = [];
            foreach ($audit->old_values as $key => $value) {
                $translated = $this->translate($key);
                if ($translated == null) {
                    $old[$key] = $value;
                } else {
                    $valoare = $translated[1]::where('id', $value)->get()->pluck($translated[2]);
                    $old[$translated[0]] = $valoare[0];
                }
            }

            $new = [];
            foreach ($audit->new_values as $key => $value) {
                $translated = $this->translate($key);
                if ($translated == null) {
                    $new[$key] = $value;
                } else {
                    $valoare = $translated[1]::where('id', $value)->get()->pluck($translated[2]);
                    $new[$translated[0]] = $valoare[0];
                }
            }

            $array = [
                'user' => $audit->user->name,
                'event' => $audit->event,
                'old_values' => $old,
                'new_values' => $new,
                'created_at' => $audit->created_at->toDateTimeString()
            ];
            array_push($data, $array);
        }

        return json_encode($data);
    }

    /**
     * Display a listing packaging_subgroup.
     *
     * @return mixed
     */
    public function indexSub(Request $request)
    {
        if ($request->ajax()) {
            $main = DB::table('packaging_subgroup')
                ->join('packaging_main_group', 'packaging_subgroup.main_id', '=', 'packaging_main_group.id')
                ->select([
                    'packaging_subgroup.id as id',
                    'packaging_subgroup.name as name',
                    'packaging_main_group.name as main_name'
                ])
                ->get();

            return DataTables::of($main)
                ->addColumn('action', function ($main) {
                    if (Gate::allows('admin')) {
                        $edit = '<a href="#" class="edit" id="' . $main->id . '"data-toggle="modal" data-target="#addSubForm"><i class="fa fa-edit"></i></a>';
                        $history = '<a href="#" class="history" id="' . $main->id . '" data-toggle="modal" data-target="#packagingHistory"> <i class="fa fa-history"></i></a>';
                        return $history . " " . $edit;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $main_group = PackagingMain::all();
        return view('packaging.sub', compact('main_group'));
    }

    /**
     * Fetch the modification history
     *
     * @param Request $request
     * @return json
     */
    public function fetchHistorySub(Request $request)
    {
        $company = PackagingSub::findOrFail($request->id);
        $audits = $company->audits;

        $data = [];

        foreach ($audits as $audit) {

            $old = [];
            foreach ($audit->old_values as $key => $value) {
                $translated = $this->translate($key);
                if ($translated == null) {
                    $old[$key] = $value;
                } else {
                    $valoare = $translated[1]::where('id', $value)->get()->pluck($translated[2]);
                    $old[$translated[0]] = $valoare[0];
                }
            }

            $new = [];
            foreach ($audit->new_values as $key => $value) {
                $translated = $this->translate($key);
                if ($translated == null) {
                    $new[$key] = $value;
                } else {
                    $valoare = $translated[1]::where('id', $value)->get()->pluck($translated[2]);
                    $new[$translated[0]] = $valoare[0];
                }
            }

            $array = [
                'user' => $audit->user->name,
                'event' => $audit->event,
                'old_values' => $old,
                'new_values' => $new,
                'created_at' => $audit->created_at->toDateTimeString()
            ];
            array_push($data, $array);
        }

        return json_encode($data);
    }


    /**
     * Display a listing packaging_per_supplier.
     *
     * @return mixed
     */
    public function indexSupplier(Request $request)
    {
        if ($request->ajax()) {
            $company = session()->get('company_was_selected');
            $main = DB::table('packaging_per_supplier')
                ->join('packaging_subgroup', 'packaging_per_supplier.subgroup_id', '=', 'packaging_subgroup.id')
                ->join('sub_suppliers', 'packaging_per_supplier.subsupplier_id', '=', 'sub_suppliers.id')
                ->where('company_id', $company)
                ->select([
                    'packaging_per_supplier.id as id',
                    'sub_suppliers.name as supplier',
                    'packaging_subgroup.name as subgroup_name',
                    'packaging_per_supplier.unitate as unitate',
                    'packaging_per_supplier.greutate as greutate',
                ])
                ->get();

            return DataTables::of($main)
                ->addColumn('action', function ($main) {
                    if (Gate::allows('admin')) {
                        $edit = '<a href="#" class="edit" id="' . $main->id . '"data-toggle="modal" data-target="#addSupplierForm"><i class="fa fa-edit"></i></a>';
                        $history = '<a href="#" class="history" id="' . $main->id . '" data-toggle="modal" data-target="#packagingHistory"> <i class="fa fa-history"></i></a>';
                        return $history . " " . $edit;
                    }
                    $edit = '<a href="#" class="edit" id="' . $main->id . '"data-toggle="modal" data-target="#addSupplierForm"><i class="fa fa-edit"></i></a>';
                    return  $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $suppliers = Suppliers::orderBy('name')->get();
        $subgroups = PackagingSub::orderBy('name')->get();
        return view('packaging.supplier', compact('suppliers', 'subgroups'));
    }

    /**
     * Fetch the modification history
     *
     * @param Request $request
     * @return json
     */
    public function fetchHistoryPackagingPerSupplier(Request $request)
    {
        $company = PackagingPerSupplier::findOrFail($request->id);
        $audits = $company->audits;

        $data = [];

        foreach ($audits as $audit) {

            $old = [];
            foreach ($audit->old_values as $key => $value) {
                $translated = $this->translate($key);
                if ($translated == null) {
                    $old[$key] = $value;
                } else {
                    $valoare = $translated[1]::where('id', $value)->get()->pluck($translated[2]);
                    $old[$translated[0]] = $valoare[0];
                }
            }

            $new = [];
            foreach ($audit->new_values as $key => $value) {
                $translated = $this->translate($key);
                if ($translated == null) {
                    $new[$key] = $value;
                } else {
                    $valoare = $translated[1]::where('id', $value)->get()->pluck($translated[2]);
                    $new[$translated[0]] = $valoare[0];
                }
            }

            $array = [
                'user' => $audit->user->name,
                'event' => $audit->event,
                'old_values' => $old,
                'new_values' => $new,
                'created_at' => $audit->created_at->toDateTimeString()
            ];
            array_push($data, $array);
        }

        return json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMain(PackagingMain $packagingMain)
    {

        $packagingMain = auth()->user()->packagingMainCreator()->create($this->validateRequestMain());

        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSub(PackagingSub $packagingSub)
    {
        $packagingSub = auth()->user()->packagingSubCreator()->create($this->validateRequestSub());

        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSupplier(PackagingPerSupplier $packagingPerSupplier)
    {
        $packagingPerSupplier = auth()->user()->packagingPerSupplierCreator()->create($this->validateRequestSupplier());

        return back();
    }

    /**
     * Fetch the packaging_main_group data and returns it in JSON format.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function fetchMain(Request $request)
    {
        $packaging = PackagingMain::findOrFail($request->id);
        $output = [
            'name' => $packaging->name,
        ];

        return json_encode($output);
    }

    /**
     * Fetch the packaging_main_group data and returns it in JSON format.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function fetchSub(Request $request)
    {
        $packaging = PackagingSub::findOrFail($request->id);
        $output = [
            'name' => $packaging->name,
            'main_id' => $packaging->main_id
        ];

        return json_encode($output);
    }

    /**
     * Fetch the packaging_main_group data and returns it in JSON format.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function fetchSupplier(Request $request)
    {
        $packaging = PackagingPerSupplier::findOrFail($request->id);
        $output = [
            'supplier_id' => $packaging->supplier_id,
            'subgroup_id' => $packaging->subgroup_id,
            'unitate' => $packaging->unitate,
            'greutate' => $packaging->greutate,
        ];

        return json_encode($output);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function updateMain(Request $request)
    {
        $packaging=PackagingMain::findOrFail($request->id);
        $packaging->update($this->validateRequestMain());

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function updateSub(Request $request)
    {
        $packaging=PackagingSub::findOrFail($request->id);
        $packaging->update($this->validateRequestSub());

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function updateSupplier(Request $request)
    {
        $packaging=PackagingPerSupplier::findOrFail($request->id);
        $packaging->update($this->validateRequestSupplier());

        return back();
    }

    /**
     * Validate the data for packaging_main_group before submission
     *
     * @return array
     */
    public function validateRequestMain()
    {
        $error_messages = [
            'name.required' => 'Nu ati introdus un nume pentru grupa!',
        ];

        return request()->validate([
            'name' => 'required',
        ], $error_messages);
    }

    /**
     * Validate the data for packaging_subgroup before submission
     *
     * @return array
     */
    public function validateRequestSub()
    {
        $error_messages = [
            'main_id.required' => 'Nu ati selectat grupa!',
            'name.required' => 'Nu ati introdus un nume pentru grupa!',
        ];

        return request()->validate([
            'main_id' => 'required',
            'name' => 'required',
        ], $error_messages);
    }

    /**
     * Validate the data for packaging_subgroup before submission
     *
     * @return array
     */
    public function validateRequestSupplier()
    {
        $error_messages = [
            'company_id.required' => 'Nu exista compania!',
            'supplier_id.required' => 'Nu ati selectat nici un furnizor!',
            'subgroup_id.required' => 'Nu ati selectat nici o subgrupa',
            'unitate.required' => 'Nu ati selectat nici o unitate de referinta!',
            'greutate.required' => 'Nu ati introdus greutatea ambalajului!',
        ];

        return request()->validate([
            'company_id' => 'required',
            'supplier_id' => 'required',
            'subgroup_id' => 'required',
            'unitate' => 'required',
            'greutate' => 'required',
        ], $error_messages);
    }
}
