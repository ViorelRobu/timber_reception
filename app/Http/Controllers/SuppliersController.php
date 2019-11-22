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
                'supplier_status.name as supplier_status', 'suppliers.packaging_calculation as packaging_calculation'])->get();

            return DataTables::of($suppliers)
                ->addColumn('action', function ($suppliers) {
                    $edit = '<a href="#" class="edit" id="' . $suppliers->id . '"data-toggle="modal" data-target="#supplierForm"><i class="fa fa-edit"></i></a>';
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

    public function update(Suppliers $suppliers)
    {
        $suppliers->update($this->validateRequest());

        return redirect('/suppliers');
    }

    public function fetchSuppliers(Request $request)
    {
        $supplier = Suppliers::findOrFail($request->id);
        $output = [
            'fibu' => $supplier->fibu,
            'packaging_calculation' => $supplier->packaging_calculation,
            'name' => $supplier->name,
            'cui' => $supplier->cui,
            'j' => $supplier->j,
            'address' => $supplier->address,
            'country_id' => $supplier->country_id,
            'supplier_group_id' => $supplier->supplier_group_id,
            'supplier_status_id' => $supplier->supplier_status_id
        ];

        return json_encode($output);
    }

    public function validateRequest()
    {
        $error_messages = [
            'fibu.required' => 'Campul FIBU trebuie sa fie completat!',
            'packaging_calculation.required' => 'Selectati calculatia ambalaj!',
            'name.required' => 'Va rog completati numele furnizorului!',
            'cui.sometimes' => 'Codul unic de inregistrare este incorect!',
            'j.sometimes' => 'Numarul de inregistrare in registrul comertului este incorect!',
            'address.required' => 'Va rog completati adresa furnizorului!',
            'country_id.required' => 'Va rog selectati tara furnizorului!',
            'supplier_group_id.required' => 'Va rog selectati grupul furnizorului!',
            'supplier_status_id.required' => 'Va rog selectati statusul furnizorului!'
        ];
        return request()->validate([
            'fibu' => 'required',
            'packaging_calculation' => 'required',
            'name' => 'required',
            'cui' => 'sometimes',
            'j' => 'sometimes',
            'address' => 'required',
            'country_id' => 'required',
            'supplier_group_id' => 'required',
            'supplier_status_id' => 'required'
        ], $error_messages);
    }

}
