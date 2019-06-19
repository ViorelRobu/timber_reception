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

                    $edit = '<a href="#"><i class="fa fa-edit"></i></a>';
                    return $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('supplier_status.index');
    }
}
