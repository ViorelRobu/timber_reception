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
                ->select([
                    'reception_committee.id as id',
                    'company_info.name as company',
                    'reception_committee.member as member',
                    'reception_committee.active as active',
                ])->get();
            return DataTables::of($data)
                ->addColumn('action', function($data) {
                    $edit = '<a href="#" class="edit" id="' . $data->id . '"data-toggle="modal" data-target="#receptionCommitteeForm"><i class="fa fa-edit"></i></a>';
                    $upload = '<a href="#" class="upload" id="' . $data->id . '"data-toggle="modal" data-target="#uploadSignatureForm"><i class="fa fa-plus"></i></a>';
                return $edit . " " . $upload;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('reception_committee.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReceptionCommittee $receptionCommittee)
    {
        $receptionCommittee = auth()->user()->receptionCommitteeCreator()->create($this->validateRequest());
        return redirect('/reception');
    }

    /**
     * Fetch the data for the requested resource for populating the edit form
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReceptionCommittee  $receptionCommittee
     * @return json
     */
    public function fetchCommitteeMemberDetails(Request $request)
    {
        $receptionCommittee = ReceptionCommittee::findOrFail($request->id);
        $output = [
            'member' => $receptionCommittee->member,
            'active' => $receptionCommittee->active
        ];

        return json_encode($output);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReceptionCommittee  $receptionCommittee
     * @return \Illuminate\Http\Response
     */
    public function update(ReceptionCommittee $receptionCommittee)
    {
        // dd($this->validateRequest());
        $receptionCommittee->update($this->validateRequest());
        return back();
    }

    /**
     * Upload a signature for the specific reception committee member
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReceptionCommittee  $receptionCommittee
     * @return \Illuminate\Http\Response
     */
    public function uploadSignature(ReceptionCommittee $receptionCommittee, Request $request)
    {
        $request->validate([
            'id' => 'required',
            'signature'  => 'required|mimes:jpeg,png',
        ]);
        $extension = "." . $request->signature->getClientOriginalExtension();
        $filename = $request->id . $extension;
        $request->signature->storeAs('signatures', $filename, ['disk' => 'public']);
        $receptionCommittee->img_url = $filename;
        $receptionCommittee->update();
        return back();
    }

    /**
     * Validate request and output custom error messages
     *
     * @return array
     */
    public function validateRequest()
    {
        $error_messages = [
            'member.required' => 'Nici un utilizator selectat!'
        ];

        return request()->validate([
            'member' => 'required',
            'company_id' => 'required',
            'active' => 'required',
        ], $error_messages);
    }
}
