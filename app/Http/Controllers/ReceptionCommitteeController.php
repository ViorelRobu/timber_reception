<?php

namespace App\Http\Controllers;

use App\CompanyAssignment;
use App\ReceptionCommittee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ReceptionCommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('reception_committee')->join('company_info', 'reception_committee.company_id', '=', 'company_info.id')
                ->join('users', 'reception_committee.user_id', '=', 'users.id')
                ->select([
                    'reception_committee.id as id',
                    'company_info.name as company',
                    'users.name as user',
                    'reception_committee.active_until as active_until'
                ])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        $company_id = $request->session()->get('company_was_selected');
        // get the user id's for all the users in the reception_committee table
        $reception_members = ReceptionCommittee::all()->pluck('user_id')->toArray();
        // get all the users assigned to the mill for which you are logged in
        $assigned_users = CompanyAssignment::where('company_id', $company_id)->pluck('user_id')->toArray();
        // get all the users with rights to the current mill that are not yet assigned
        $users = User::orderBy('name')->whereIn('id', $assigned_users)->whereNotIn('id', $reception_members)->get();
        return view('reception_committee.index', compact(['users']));
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
     * @param  \App\ReceptionCommittee  $receptionCommittee
     * @return \Illuminate\Http\Response
     */
    public function show(ReceptionCommittee $receptionCommittee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReceptionCommittee  $receptionCommittee
     * @return \Illuminate\Http\Response
     */
    public function edit(ReceptionCommittee $receptionCommittee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReceptionCommittee  $receptionCommittee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReceptionCommittee $receptionCommittee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReceptionCommittee  $receptionCommittee
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReceptionCommittee $receptionCommittee)
    {
        //
    }
}
