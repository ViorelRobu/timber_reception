<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupplierStatus;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Gate;

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
        if (Gate::allows('company_was_selected')) {
            return view('supplier_status.index');
        } else {
            return redirect('/');
        }
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
