<?php

namespace App\Http\Controllers;

use App\Moisture;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MoistureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Moisture::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    $edit = '<a href="#" class="edit" id="' . $data->id . '" data-toggle="modal" data-target="#moistureForm"><i class="fa fa-edit"></i></a>';
                    return $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('moisture.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Moisture $moisture)
    {
        $moisture = auth()->user()->moistureCreator()->create($this->validateRequest());
        return redirect('/moisture');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Moisture $moisture)
    {
        $moisture->update($this->validateRequest());

        return redirect('/moisture');
    }

    public function fetchMoisture(Request $request)
    {
        $moisture = Moisture::findOrFail($request->id);
        $output = [
            'name' => $moisture->name,
            'name_en' => $moisture->name_en
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
