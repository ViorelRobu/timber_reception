<?php

namespace App\Http\Controllers;

use App\ClaimStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ClaimStatusController extends Controller
{
    /**
     * Display a listing of all statuses
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $table = DB::table('claim_status')
                ->select(['claim_status.id as id', 'claim_status.status as status'])->get();
            return DataTables::of($table)
                ->addIndexColumn()
                ->addColumn('action', function ($table) {
                    $edit = '<a href="#" class="edit" id="' . $table->id . '"data-toggle="modal" data-target="#claimStatusForm"><i class="fa fa-edit"></i></a>';
                    return $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('claim_status.index');
    }

    /**
     * Persist the data into the table
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClaimStatus $claimStatus)
    {
        $claimStatus->create($this->validateRequest());
        return redirect('claim_status');
    }

    /**
     * Update the database entry
     *
     * @param  \App\ClaimStatus
     * @return \Illuminate\Http\Response
     */
    public function update(ClaimStatus $claimStatus)
    {
        $claimStatus->update($this->validateRequest());
        return back();
    }

    /**
     * Fetch the data for a single record
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function fetch(Request $request)
    {
        $status = ClaimStatus::findOrFail($request->id);
        $output = [
            'status' => $status->status,
        ];

        return json_encode($output);
    }

    /**
     * Validate the request
     */
    public function validateRequest()
    {
        $error_messages = [
            'status.required' => 'Va rog sa introduceti un status!'
        ];

        return request()->validate([
            'status' => 'required'
        ], $error_messages);
    }

}
