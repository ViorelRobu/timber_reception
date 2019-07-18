<?php

namespace App\Http\Controllers;

use App\CompanyInfo;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $company_name = CompanyInfo::where('id', session()->get('company_was_selected'))->pluck('name');
        return view('home', ['company_name' => $company_name]);
    }
}
