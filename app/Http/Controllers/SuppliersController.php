<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suppliers as Suppliers;

class SuppliersController extends Controller
{
    public function index()
    {
        $suppliers = Suppliers::all();
        return view('suppliers.index', compact('suppliers'));
    }
}
