<?php

namespace App\Http\Controllers;

use App\Number;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class NumbersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('nir_numbers')->join('company_info', 'nir_numbers.company_id', '=', 'company_info.id')
                ->join('users', 'nir_numbers.user_id', '=', 'users.id')
                ->select([
                    'nir_numbers.id as id',
                    'nir_numbers.numar_nir as numar_nir',
                    'company_info.name as name',
                    'users.name as user',
                    'nir_numbers.created_at as created_at'
                ])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('numbers.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Number $number)
    {
        $number = auth()->user()->nirNumberCreator()->create($this->validateRequest());
        return redirect('/numbers');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Number $number)
    {
        //
    }

    public function validateRequest()
    {
        $error_messages = [
            'numar_nir.required' => 'Numarul trebuie completat!',
            'company_id.required' => 'Nu exista firma selectata!',
        ];

        return request()->validate([
            'numar_nir' => 'required',
            'company_id' => 'required'
        ], $error_messages);
    }
}
