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

                    $edit = '<a href="#"><i class="fa fa-edit"></i></a>';
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

    public function validateRequest()
    {
        return request()->validate([
            'name' => 'required',
            'name_en' => 'required',
        ]);
    }
}
