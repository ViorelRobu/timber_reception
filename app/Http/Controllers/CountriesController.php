<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Countries;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;

class CountriesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Countries::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    $edit = '<a href="#" class="edit" id="' . $data->id . '" data-toggle="modal" data-target="#countriesForm"><i class="fa fa-edit"></i></a>';
                    return $edit;
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
