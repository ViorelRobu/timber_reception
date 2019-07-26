<?php

namespace App\Http\Controllers;

use App\NIRDetails;
use Illuminate\Http\Request;

class NIRDetailsController extends Controller
{
    public function store(Request $request, NIRDetails $nirDetails)
    {
        $nir_details = new NIRDetails();
        $nir_id = ['nir_id' => $request->nir_id];
        $user_id = ['user_id' => auth()->user()->id];
        $values = array_merge($nir_id, $this->validateRequest(), $user_id);
        $nirDetails->create($values);

        return back();
       
    }

    public function fetchDetails(Request $request)
    {
        $nir = NIRDetails::findOrFail($request->id);
        $output = [
            'article_id' => $nir->article_id,
            'species_id' => $nir->species_id,
            'volum_aviz' => $nir->volum_aviz,
            'volum_receptionat' => $nir->volum_receptionat,
            'moisture_id' => $nir->moisture_id,
            'pachete' => $nir->pachete,
            'total_ml' => $nir->total_ml,
        ];

        return json_encode($output);
    }

    public function update(NIRDetails $nirDetails)
    {
        $nirDetails->update($this->validateRequest());
        return back();
    }

    public function destroy(Request $request)
    {
        $nir_details = NIRDetails::findOrFail($request->delete_detail_id);

        $nir_details->delete();

        return back();
    }

    public function validateRequest()
    {
        $error_messages = [
            'article_id.required' => 'Selectati un articol!',
            'species_id.required' => 'Selectati o specie!',
            'volum_aviz.required' => 'Completati volumul de pe aviz!',
            'volum_receptionat.required' => 'Completati volumul de pe factura!',
            'moisture_id.required' => 'Selectati o umiditate!',
            'pachete.required' => 'Completati numarul de pachete!',
            'total_ml.required' => 'Completati lungimea totala pachete!',
        ];

        return request()->validate([
            'article_id' => 'required',
            'species_id' => 'required',
            'volum_aviz' => 'required',
            'volum_receptionat' => 'required',
            'moisture_id' => 'required',
            'pachete' => 'required',
            'total_ml' => 'required',
        ], $error_messages);
    }
}
