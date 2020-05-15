<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Translatable;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Countries;
use Illuminate\Support\Facades\Gate;
use App\SubSupplier;
use App\Suppliers;

class SubSuppliersController extends Controller
{
    use Translatable;

    protected $dictionary = [
        'country_id' => ['tara', 'App\Countries', 'name'],
        'supplier_id' => ['furnizor', 'App\Suppliers', 'name'],
        'user_id' => ['utilizator', 'App\User', 'name']
    ];

    /**
     * Display all the sub-suppliers
     *
     * @return view
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sub_suppliers = DB::table('sub_suppliers')
                ->join('countries', 'sub_suppliers.country_id', '=', 'countries.id')
                ->join('suppliers', 'sub_suppliers.supplier_id', '=', 'suppliers.id')
                ->select([
                    'sub_suppliers.id as id',
                    'suppliers.name as supplier',
                    'sub_suppliers.name as name',
                    'countries.name as country',
                ])->get();

            return DataTables::of($sub_suppliers)
                ->addColumn('action', function ($sub_suppliers) {
                    if (Gate::allows('admin')) {
                        $history = '<a href="#" class="history" id="' . $sub_suppliers->id . '" data-toggle="modal" data-target="#supplierHistory"> <i class="fa fa-history"></i></a>';
                        $edit = '<a href="#" class="edit" id="' . $sub_suppliers->id . '"data-toggle="modal" data-target="#supplierForm"><i class="fa fa-edit"></i></a>';
                        return $edit . ' ' . $history;
                    } else if (Gate::allows('user')) {
                        $edit = '<a href="#" class="edit" id="' . $sub_suppliers->id . '"data-toggle="modal" data-target="#supplierForm"><i class="fa fa-edit"></i></a>';
                        return $edit;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $countries = Countries::orderBy('name')->get();
        $suppliers = Suppliers::orderBy('name')->get();

        return view('sub_suppliers.index', ['countries' => $countries, 'suppliers' => $suppliers]);
    }

    /**
     * Fetch the modification history for the selected sub-supplier
     *
     * @param Request $request
     * @return json
     */
    public function fetchHistory(Request $request)
    {
        $supplier = SubSupplier::findOrFail($request->id);
        $audits = $supplier->audits;

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

    public function store(SubSupplier $subSupplier)
    {
        $subSupplier = auth()->user()->subSupplierCreator()->create($this->validateRequest());
        return redirect('sub_suppliers');
    }

    public function update(SubSupplier $subSupplier)
    {
        $subSupplier->update($this->validateRequest());

        return redirect('/sub_suppliers');
    }

    public function fetchSubSupplier(Request $request)
    {
        $supplier = SubSupplier::findOrFail($request->id);
        $output = [
            'supplier' => $supplier->supplier_id,
            'name' => $supplier->name,
            'country_id' => $supplier->country_id,
        ];

        return json_encode($output);
    }

    public function validateRequest()
    {
        $error_messages = [
            'supplier_id.required' => 'Va rog selectati furnizorul!',
            'name.required' => 'Va rog completati numele subfurnizorului!',
            'country_id.required' => 'Va rog selectati tara subfurnizorului!',
        ];
        return request()->validate([
            'supplier_id' => 'required',
            'name' => 'required',
            'country_id' => 'required',
        ], $error_messages);
    }
}
