<?php

namespace App\Http\Controllers;

use App\CompanyInfo;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CompanyInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CompanyInfo::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    $edit = '<a class="edit" href="#" id="' . $data->id . '" data-toggle="modal" data-target="#companyForm"><i class="fa fa-edit"></i></a>';
                    return $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('info.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompanyInfo  $companyInfo
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyInfo $companyInfo)
    {
        // dd($this->validateRequest());
        $companyInfo->update($this->validateRequest());

        return redirect('/companies');
    }

    public function fetchCompanyInfo(Request $request)
    {
        $company = CompanyInfo::findOrFail($request->id);
        $output = [
            'name' => $company->name,
            'cui' => $company->cui,
            'j' => $company->j,
            'address' => $company->address,
            'account_number' => $company->account_number,
            'bank' => $company->bank
        ];

        return json_encode($output);
    }

    public function store(CompanyInfo $companyInfo)
    {
        $companyInfo = auth()->user()->companyCreator()->create($this->validateRequest());
        return redirect('companies');
    }

    public function validateRequest()
    {
        return request()->validate([
            'name' => 'required',
            'cui' => 'required',
            'j' => 'required',
            'address' => 'required',
            'account_number' => 'required',
            'bank' => 'required',
        ]);
    }
}
