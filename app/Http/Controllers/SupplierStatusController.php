<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupplierStatus;

class SupplierStatusController extends Controller
{
    public function index()
    {
        $supplier_status = SupplierStatus::all();
        return view('supplier_status.index', compact('supplier_status'));
    }
}
