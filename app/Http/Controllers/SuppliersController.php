<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suppliers;

class SuppliersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Suppliers::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $edit = '<a href="#"><i class="fa fa-edit"></i></a>';
                    return $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('suppliers.index');
    }
}
