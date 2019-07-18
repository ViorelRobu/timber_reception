<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupplierGroup;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Gate;

class SupplierGroupController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SupplierGroup::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    $edit = '<a href="#" class="edit" id="' . $data->id . '" data-toggle="modal" data-target="#supplierGroupForm"><i class="fa fa-edit"></i></a>';
                    return $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('supplier_group.index');
    }

    public function store(SupplierGroup $supplierGroup)
    {
        $supplierGroup = auth()->user()->supplierGroupCreator()->create($this->validateRequest());
        return redirect('supplier_group');
    }

    public function update(SupplierGroup $supplierGroup)
    {
        $supplierGroup->update($this->validateRequest());

        return redirect('/supplier_group');
    }

    public function fetchSupplierGroup(Request $request)
    {
        $supplierGroup = SupplierGroup::findOrFail($request->id);
        $output = [
            'name' => $supplierGroup->name,
            'name_en' => $supplierGroup->name_en
        ];

        return json_encode($output);
    }

    public function validateRequest()
    {
        $error_messages = [
            'name.required' => 'Denumirea este necesara!',
            'name_en.required' => 'Va rog completati denumirea in limba engleza'
        ];

        return request()->validate([
            'name' => 'required',
            'name_en' => 'required',
        ], $error_messages);
    }
}
