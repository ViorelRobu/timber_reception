<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyAssignment;
use App\CompanyInfo;

class CompanySelectorController extends Controller
{
    /*
    *   Return the main page view
    *   
    */
    public function index()
    {
        if (!session()->get('company_was_selected')) {
            $available_companies = CompanyAssignment::where('user_id', auth()->user()->id)->pluck('company_id')->toArray();
            $get_companies_names = CompanyInfo::whereIn('id', $available_companies)->get();

            return view('company', ['companies' => $get_companies_names]);
        } else {
            return back();
        }
    }

    public function setCompany(Request $request)
    {
        session()->put('company_was_selected', $request->company_id);
        return redirect('/dashboard');
    }
}
