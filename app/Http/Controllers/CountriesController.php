<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Countries;
use Yajra\DataTables\Facades\DataTables;

class CountriesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Countries::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    $edit = '<a href="#"><i class="fa fa-edit"></i></a>';
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

    public function validateRequest()
    {
        return request()->validate([
            'name' => 'required',
            'name_en' => 'required',
        ]);
    }
}
