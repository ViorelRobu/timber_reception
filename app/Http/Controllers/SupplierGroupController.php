<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupplierGroup;
use Yajra\DataTables\DataTables;

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
        return request()->validate([
            'name' => 'required',
            'name_en' => 'required',
        ]);
    }
}
