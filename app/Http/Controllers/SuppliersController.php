<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suppliers;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Countries;
use App\SupplierGroup;
use App\SupplierStatus;

class SuppliersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $suppliers = DB::table('suppliers')->join('countries', 'suppliers.country_id', '=', 'countries.id')
                ->join('supplier_group', 'suppliers.supplier_group_id', '=', 'supplier_group.id')
                ->join('supplier_status', 'suppliers.supplier_status_id', '=', 'supplier_status.id')
                ->select(['suppliers.id as id', 'suppliers.fibu as fibu', 'suppliers.name as name', 'suppliers.cui as cui', 'suppliers.j as j', 
                'suppliers.address as address', 'countries.name as country', 'supplier_group.name as supplier_group', 
                'supplier_status.name as supplier_status']);

            $data = Suppliers::latest()->get();
            return DataTables::of($suppliers)
                ->addColumn('action', function () {
                    $edit = '<a href="#"><i class="fa fa-edit"></i></a>';
                    return $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $countries = Countries::orderBy('name')->get();
        $supplier_groups = SupplierGroup::orderBy('name')->get();
        $supplier_statuses = SupplierStatus::orderBy('name')->get();

        return view('suppliers.index', ['countries' => $countries, 'supplier_groups' => $supplier_groups, 'supplier_statuses' => $supplier_statuses]);
    }

    public function store(Suppliers $suppliers)
    {
        $suppliers = auth()->user()->supplierCreator()->create($this->validateRequest());
        return redirect('suppliers');
    }

    public function validateRequest()
    {
        return request()->validate([
            'fibu' => 'required',
            'name' => 'required',
            'cui' => 'sometimes',
            'j' => 'sometimes',
            'address' => 'required',
            'country_id' => 'required',
            'supplier_group_id' => 'required',
            'supplier_status_id' => 'required'
        ]);
    }

}
