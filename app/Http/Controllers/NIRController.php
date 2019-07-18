<?php

namespace App\Http\Controllers;

use App\NIR;
use Illuminate\Http\Request;
use App\CompanyInfo;

class NIRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_name = CompanyInfo::where('id', session()->get('company_was_selected'))->pluck('name');
        return view('nir.index', ['company_name' => $company_name]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NIR  $nIR
     * @return \Illuminate\Http\Response
     */
    public function show(NIR $nIR)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NIR  $nIR
     * @return \Illuminate\Http\Response
     */
    public function edit(NIR $nIR)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NIR  $nIR
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NIR $nIR)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NIR  $nIR
     * @return \Illuminate\Http\Response
     */
    public function destroy(NIR $nIR)
    {
        //
    }
}
