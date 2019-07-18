<?php

namespace App\Http\Controllers;

use App\CompanyInfo;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\CompanyAssignment;
use Illuminate\Support\Facades\Gate;

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

    public function loadUnassignedCompanies(Request $request)
    {
        if($request->user_id) {
            // get all assigned companies
            $assignedCompanies = CompanyAssignment::where('user_id', $request->user_id)->pluck('company_id')->toArray();
            // load the list for the unassigned companies
            $unassignedCompanies = CompanyInfo::whereNotIn('id', $assignedCompanies)->get();
            // send the response to the request
            $response = '';
            foreach ($unassignedCompanies as $company) {
                $response .= '<option value="' . $company->id . '">' . $company->name . '</option>';
            }
            if (!$response) {
                $response = '<option value="">---Nu exista companii la care utilizatorul selectat sa nu aiba drepturi de acces!---</option>';
            }
            return response()->json(['response' => $response]);
        } else {
            return false;
        }
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
        $error_messages = [
            'name.required' => 'Va rog completati denumirea firmei!',
            'cui.required' => 'Va rog completati Codul Unic de Inregistrare!',
            'j.required' => 'Va rog completati Numarul din Registrul Comertului!',
            'address.required' => 'Va rog completati adresa!',
            'account_number.required' => 'Va rog completati numarul contului!',
            'bank.required' => 'Va rog specificati banca la care aveti deschis contul!',
        ];

        return request()->validate([
            'name' => 'required',
            'cui' => 'required',
            'j' => 'required',
            'address' => 'required',
            'account_number' => 'required',
            'bank' => 'required',
        ], $error_messages);
    }
}
