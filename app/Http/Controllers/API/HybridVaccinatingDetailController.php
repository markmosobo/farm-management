<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HybridVaccinatingDetail;

class HybridVaccinatingDetailController extends Controller
{
    public function index()
    {
        return HybridVaccinatingDetail::latest()->with('poultry')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'date_of_vaccinating' => 'required|date',
            'poultry_id' => 'required|integer',
            'vaccine_type' => 'required|string',
            'vaccine_quantity' => 'required',
            'no_of_poultries' => 'required|integer'
        ]);

        return HybridVaccinatingDetail::create([
            'poultry_id' => $request->get('poultry_id'),
            'date_of_vaccinating' => $request->get('date_of_vaccinating'),
            'vaccine_type' => $request->get('vaccine_type'),
            'vaccine_quantity' => $request->get('vaccine_quantity'),
            'no_of_poultries' => $request->get('no_of_poultries'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $hybridvaccinatingdetail = HybridVaccinatingDetail::findOrFail($id);

        $this->validate($request,[
            'date_of_vaccinating' => 'required|date',
            'poultry_id' => 'required|integer',
            'vaccine_type' => 'required|string',
            'vaccine_quantity' => 'required',
            'no_of_poultries' => 'required|integer'
        ]);
        
        $hybridvaccinatingdetail->update($request->all());
        return (['message' => 'success']);

    }

    public function destroy(Request $request,$id)
    {
        $hybridvaccinatingdetail = HybridVaccinatingDetail::findOrFail($id);

        $hybridvaccinatingdetail->delete();
        return (['message' => 'deleted']);    
    }    
}
