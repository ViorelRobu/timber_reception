<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupplierGroup;

class SupplierGroupController extends Controller
{
    public function index()
    {
        $supplier_group = SupplierGroup::all();
        return view('supplier_group.index', compact('supplier_group'));
    }
}
