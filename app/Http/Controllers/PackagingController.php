<?php

namespace App\Http\Controllers;

use App\PackagingMain;
use App\PackagingPerSupplier;
use App\PackagingSub;
use App\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class PackagingController extends Controller
{
    /**
     * Display a listing packaging_main_group.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        // if ($request->ajax()) {
        //     $main = DB::table('packaging_main_group')->get();

        //     return DataTables::of($main)
        //         ->addColumn('action', function ($main) {
        //             if (Gate::allows('admin')) {
        //                 $edit = '<a href="#" class="edit" id="' . $main->id . '"data-toggle="modal" data-target="#addMainForm"><i class="fa fa-edit"></i></a>';
        //                 return $edit;
        //             }
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }

        return view('packaging.index');
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
                        return $edit;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('packaging.main');
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
                        return $edit;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $main_group = PackagingMain::all();
        return view('packaging.sub', compact('main_group'));
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
                ->join('suppliers', 'packaging_per_supplier.supplier_id', '=', 'suppliers.id')
                ->where('company_id', $company)
                ->select([
                    'packaging_per_supplier.id as id',
                    'suppliers.name as supplier',
                    'packaging_subgroup.name as subgroup_name',
                    'packaging_per_supplier.unitate as unitate',
                    'packaging_per_supplier.greutate as greutate',
                ])
                ->get();

            return DataTables::of($main)
                ->addColumn('action', function ($main) {
                    if (Gate::allows('admin')) {
                        $edit = '<a href="#" class="edit" id="' . $main->id . '"data-toggle="modal" data-target="#addSupplierForm"><i class="fa fa-edit"></i></a>';
                        return $edit;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $suppliers = Suppliers::orderBy('name')->get();
        $subgroups = PackagingSub::orderBy('name')->get();
        return view('packaging.supplier', compact('suppliers', 'subgroups'));
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
