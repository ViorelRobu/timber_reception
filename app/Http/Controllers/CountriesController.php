<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Countries;
use App\Traits\Translatable;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class CountriesController extends Controller
{
    use Translatable;

    protected $dictionary = [
        'user_id' => ['utilizator', 'App\User', 'name']
    ];

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Countries::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if (Gate::allows('admin')) {
                    $edit = '<a href="#" class="edit" id="' . $data->id . '" data-toggle="modal" data-target="#countriesForm"><i class="fa fa-edit"></i></a>';
                        $history = '<a href="#" class="history" id="' . $data->id . '" data-toggle="modal" data-target="#countryHistory"> <i class="fa fa-history"></i></a>';
                        return $history . ' ' . $edit;
                    } else if (Gate::allows('user')) {
                        $edit = '<a href="#" class="edit" id="' . $data->id . '" data-toggle="modal" data-target="#countriesForm"><i class="fa fa-edit"></i></a>';
                        return $edit;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('countries.index');
    }

    public function store(Countries $countries)
    {
        $countries = auth()->user()->countriesCreator()->create($this->validateRequest());
        return redirect('countries');
    }

    public function update(Countries $countries)
    {
        $countries->update($this->validateRequest());

        return redirect('/countries');
    }

    public function fetchCountry(Request $request)
    {
        $country = Countries::findOrFail($request->id);
        $output = [
            'name' => $country->name,
            'name_en' => $country->name_en
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
        $company = Countries::findOrFail($request->id);
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
