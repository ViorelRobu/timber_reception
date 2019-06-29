<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupplierStatus;
use Yajra\DataTables\DataTables;

class SupplierStatusController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SupplierStatus::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    $edit = '<a href="#" class="edit" id=' . $data->id . ' data-toggle="modal" data-target="#supplierStatusForm"><i class="fa fa-edit"></i></a>';
                    return $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('supplier_status.index');
    }

    public function store(SupplierStatus $supplierStatus)
    {
        $supplierStatus = auth()->user()->supplierStatusCreator()->create($this->validateRequest());
        return redirect('supplier_status');
    }

    public function update(SupplierStatus $supplierStatus)
    {
        $supplierStatus->update($this->validateRequest());
        return redirect('/supplier_status');
    }

    public function fetchSupplierStatus(Request $request)
    {
        $supplierStatus = SupplierStatus::findOrFail($request->id);
        $output = [
            'name' => $supplierStatus->name,
            'name_en' => $supplierStatus->name_en
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
