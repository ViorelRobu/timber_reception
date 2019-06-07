<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Countries as Countries;

class CountriesController extends Controller
{
    public function index()
    {
        $countries = Countries::all();
        return view('countries.index', compact('countries'));
    }
}
