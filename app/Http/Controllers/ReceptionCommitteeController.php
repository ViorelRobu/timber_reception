<?php

namespace App\Http\Controllers;

use App\Committee;
use App\CompanyAssignment;
use App\ReceptionCommittee;
use App\Traits\Translatable;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ReceptionCommitteeController extends Controller
{
    use Translatable;

    protected $dictionary = [
        'user_id' => ['utilizator', 'App\User', 'name'],
        'company_id' => ['firma', 'App\CompanyInfo', 'name'],
        'committee_id' => ['comisie', 'App\Committee', 'name'],
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $company = session()->get('company_was_selected');

        if ($request->ajax()) {
            $data = DB::table('reception_committee')
                ->where('committee.company_id', $company)
                ->join('committee', 'reception_committee.committee_id', '=', 'committee.id')
                ->join('company_info', 'committee.company_id', '=', 'company_info.id')
                ->select([
                    'reception_committee.id as id',
                    'company_info.name as company',
                    'committee.name as committee',
                    'reception_committee.member as member',
                    'reception_committee.active as active',
                    'reception_committee.img_url as img_url'
                ])->get();
            return DataTables::of($data)
                ->addColumn('action', function($data) {
                    $edit = '<a href="#" class="edit" id="' . $data->id . '"data-toggle="modal" data-target="#receptionCommitteeForm"><i class="fa fa-edit"></i></a>';
                    $upload = '<a href="#" class="upload" id="' . $data->id . '"data-toggle="modal" data-target="#uploadSignatureForm"><i class="fa fa-plus"></i></a>';
                    $image = '<a href="#" class="show_signature" data-link="/storage/signatures/' . $data->img_url . '"data-toggle="modal" data-target="#showSignature"><i class="fa fa-eye"></i></a>';
                    $delete = '<a href="#" class="delete_signature" data-delete="' . $data->id . '" data-link="signatures/' . $data->img_url . '"data-toggle="modal" data-target="#deleteSignature"><i class="fa fa-trash"></i></a>';
                    $history = '<a href="#" class="history" id="' . $data->id . '" data-toggle="modal" data-target="#receptionCommitteeHistory"> <i class="fa fa-history"></i></a>';
                return $edit . " " . $upload . " " . $image . " " . $delete . " " . $history;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $committee_list = Committee::where('company_id', $company)->get();

        return view('reception_committee.index', \compact('committee_list'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCommittee(Request $request)
    {
        $company = session()->get('company_was_selected');

        if ($request->ajax()) {
            $data = DB::table('committee')
                ->where('committee.company_id', $company)
                ->join('company_info', 'committee.company_id', '=', 'company_info.id')
                ->select([
                    'committee.id as id',
                    'company_info.name as company',
                    'committee.name as name',
                ])->get();
            return DataTables::of($data)
                ->addColumn('action', function($data) {
                    if (Gate::allows('admin')) {
                        $edit = '<a href="#" class="edit" id="' . $data->id . '" data-toggle="modal" data-target="#receptionCommitteeForm"><i class="fa fa-edit"></i></a>';
                        $history = '<a href="#" class="history" id="' . $data->id . '" data-toggle="modal" data-target="#receptionCommitteeHistory"> <i class="fa fa-history"></i></a>';
                        return $history . ' ' . $edit;
                    } else if (Gate::allows('user')) {
                        $edit = '<a href="#" class="edit" id="' . $data->id . '" data-toggle="modal" data-target="#receptionCommitteeForm"><i class="fa fa-edit"></i></a>';
                        return $edit;
                    }
                    $edit = '<a href="#" class="edit" id="' . $data->id . '"data-toggle="modal" data-target="#receptionCommitteeForm"><i class="fa fa-edit"></i></a>';
                return $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('reception_committee.committee');
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
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCommittee(Committee $committee)
    {
        $committee = auth()->user()->committeeCreator()->create($this->validateRequestCommittee());
        return back();
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
     * Fetch the data for the requested resource for populating the edit form
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReceptionCommittee  $receptionCommittee
     * @return json
     */
    public function fetchCommitteeDetails(Request $request)
    {
        $committee = Committee::findOrFail($request->id);
        $output = [
            'name' => $committee->name,
            'company_id' => $committee->company_id
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
        $receptionCommittee->update($this->validateRequest());
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function updateCommittee(Committee $committee)
    {
        // dd($this->validateRequestCommittee());
        $committee->update($this->validateRequestCommittee());
        return back();
    }

    /**
     * Upload a signature for the specific reception committee member
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReceptionCommittee  $receptionCommittee
     * @return redirect
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
     * Delete the signature for the specific reception committee member
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReceptionCommittee  $receptionCommittee
     * @return redirect
     */
    public function deleteSignature(ReceptionCommittee $receptionCommittee, Request $request)
    {
        Storage::disk('public')->delete($request->path);
        $receptionCommittee->img_url = null;
        $receptionCommittee->update();
        return back();

    }

    /**
     * Fetch the modification history
     *
     * @param Request $request
     * @return json
     */
    public function fetchHistory(Request $request)
    {
        $company = Committee::findOrFail($request->id);
        $audits = $company->audits;

        $data = [];

        foreach ($audits as $audit) {

            $old = [];
            foreach ($audit->old_values as $key => $value) {
                $translated = $this->translate($key);
                if ($translated == null) {
                    $old[$key] = $value;
                } else {
                    $valoare = $translated[1]::where('id', $value)->get()->pluck($translated[2]);
                    $old[$translated[0]] = $valoare[0];
                }
            }

            $new = [];
            foreach ($audit->new_values as $key => $value) {
                $translated = $this->translate($key);
                if ($translated == null) {
                    $new[$key] = $value;
                } else {
                    $valoare = $translated[1]::where('id', $value)->get()->pluck($translated[2]);
                    $new[$translated[0]] = $valoare[0];
                }
            }

            $array = [
                'user' => $audit->user->name,
                'event' => $audit->event,
                'old_values' => $old,
                'new_values' => $new,
                'created_at' => $audit->created_at->toDateTimeString()
            ];
            array_push($data, $array);
        }

        return json_encode($data);
    }

    /**
     * Fetch the modification history
     *
     * @param Request $request
     * @return json
     */
    public function fetchReceptionCommitteeHistory(Request $request)
    {
        $company = ReceptionCommittee::findOrFail($request->id);
        $audits = $company->audits;

        $data = [];

        foreach ($audits as $audit) {

            $old = [];
            foreach ($audit->old_values as $key => $value) {
                $translated = $this->translate($key);
                if ($translated == null) {
                    $old[$key] = $value;
                } else {
                    $valoare = $translated[1]::where('id', $value)->get()->pluck($translated[2]);
                    $old[$translated[0]] = $valoare[0];
                }
            }

            $new = [];
            foreach ($audit->new_values as $key => $value) {
                $translated = $this->translate($key);
                if ($translated == null) {
                    $new[$key] = $value;
                } else {
                    $valoare = $translated[1]::where('id', $value)->get()->pluck($translated[2]);
                    $new[$translated[0]] = $valoare[0];
                }
            }

            $array = [
                'user' => $audit->user->name,
                'event' => $audit->event,
                'old_values' => $old,
                'new_values' => $new,
                'created_at' => $audit->created_at->toDateTimeString()
            ];
            array_push($data, $array);
        }

        return json_encode($data);
    }

    /**
     * Validate request and output custom error messages
     *
     * @return array
     */
    public function validateRequest()
    {
        $error_messages = [
            'member.required' => 'Introduceti nume membru!'
        ];

        return request()->validate([
            'member' => 'required',
            'committee_id' => 'required',
            'active' => 'required',
        ], $error_messages);
    }

    /**
     * Validate request and output custom error messages
     *
     * @return array
     */
    public function validateRequestCommittee()
    {
        $error_messages = [
            'name.required' => 'Trebuie completat numele comisiei de receptie!'
        ];

        return request()->validate([
            'name' => 'required',
            'company_id' => 'required',
        ], $error_messages);
    }
}
