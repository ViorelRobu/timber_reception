<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Vehicle::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    $edit = '<a href="#" class="edit" id="' . $data->id . '" data-toggle="modal" data-target="#vehiclesForm"><i class="fa fa-edit"></i></a>';
                    return $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('vehicles.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Vehicle $vehicle)
    {
        $vehicle = auth()->user()->vehicleCreator()->create($this->validateRequest());
        return redirect('/vehicles');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Vehicle $vehicle)
    {
        // dd($this->validateRequest());
        $vehicle->update($this->validateRequest());

        return redirect('/vehicles');
    }

    public function fetchVehicle(Request $request)
    {
        $country = Vehicle::findOrFail($request->id);
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
