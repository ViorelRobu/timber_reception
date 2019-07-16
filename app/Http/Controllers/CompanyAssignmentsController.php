<?php

namespace App\Http\Controllers;

use App\CompanyAssignment;
use Illuminate\Http\Request;
use App\CompanyInfo;
use App\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CompanyAssignmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $table = DB::table('company_assignment')->join('users', 'company_assignment.user_id', '=', 'users.id')
                    ->join('company_info', 'company_assignment.company_id', '=', 'company_info.id')
                    ->select(['company_assignment.id as id', 'users.name as user', 'company_info.name as company'])->get();
            return DataTables::of($table)
                ->addIndexColumn()
                ->addColumn('action', function ($table) {

                    $edit = '<a class="edit" href="#" id="' . $table->id . '" data-toggle="modal" data-target="#userAssginmentForm"><i class="fa fa-edit"></i></a>';
                    return $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $users = User::orderBy('name')->get();
        $companies = CompanyInfo::orderBy('name')->get();
        return view('company_assignment.index', compact(['users', 'companies']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyAssignment $companyAssignment)
    {
        $companyAssignment->create($this->validateRequest());
        return redirect('companies/assign');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompanyAssignment  $companyAssignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyAssignment $companyAssignment)
    {
        //
    }

    public function validateRequest()
    {
        $error_messages = [
            'user_id.required' => 'Va rog selectati utilizatorul!',
            'company_id.required' => 'Va rog selectati compania!'
        ];
        
        return request()->validate([
            'user_id' => 'required',
            'company_id' => 'required'
        ], $error_messages);
    }
}
