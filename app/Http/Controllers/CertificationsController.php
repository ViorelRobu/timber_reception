<?php

namespace App\Http\Controllers;

use App\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\Translatable;

class CertificationsController extends Controller
{
    use Translatable;

    protected $dictionary = [
        'user_id' => ['utilizator', 'App\User', 'name']
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Certification::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if (Gate::allows('admin')) {
                        $edit = '<a href="#" class="edit" id="' . $data->id . '" data-toggle="modal" data-target="#certificationsForm"><i class="fa fa-edit"></i></a>';
                        $history = '<a href="#" class="history" id="' . $data->id . '" data-toggle="modal" data-target="#certificationHistory"> <i class="fa fa-history"></i></a>';
                        return $history . ' ' . $edit;
                    } else if (Gate::allows('user')) {
                        $edit = '<a href="#" class="edit" id="' . $data->id . '" data-toggle="modal" data-target="#certificationsForm"><i class="fa fa-edit"></i></a>';
                        return $edit;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('certifications.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Certification $certification)
    {
        $certification = auth()->user()->certificationCreator()->create($this->validateRequest());
        return redirect('/certifications');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Certification  $certification
     * @return \Illuminate\Http\Response
     */
    public function update(Certification $certification)
    {
        $certification->update($this->validateRequest());

        return redirect('/certifications');
    }

    public function fetchCertifications(Request $request)
    {
        $certification = Certification::findOrFail($request->id);
        $output = [
            'name' => $certification->name,
            'name_en' => $certification->name_en
        ];

        return json_encode($output);
    }

    /**
     * Fetch the modification history
     *
     * @param Request $request
     * @return json
     */
    public function fetchHistory(Request $request)
    {
        $company = Certification::findOrFail($request->id);
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

    public function validateRequest()
    {
        $error_messages = [
            'name.required' => 'Denumirea este necesara!',
            'name_en.required' => 'Va rog completati denumirea in limba engleza'
        ];

        return request()->validate([
            'name' => 'required',
            'name_en' => 'required',
        ], $error_messages);
    }

}
