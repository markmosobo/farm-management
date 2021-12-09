<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetVaccinatingDetail;

class PetVaccinatingDetailController extends Controller
{
    public function index()
    {
        return PetVaccinatingDetail::latest()->with('animal')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'date_of_vaccinating' => 'required|date',
            'animal_id' => 'required|integer',
            'vaccine_type' => 'required|string',
            'vaccine_quantity' => 'required',
            'no_of_animals' => 'required|integer'
        ]);

        return PetVaccinatingDetail::create([
            'animal_id' => $request->get('animal_id'),
            'date_of_vaccinating' => $request->get('date_of_vaccinating'),
            'vaccine_type' => $request->get('vaccine_type'),
            'vaccine_quantity' => $request->get('vaccine_quantity'),
            'no_of_animals' => $request->get('no_of_animals'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $petvaccinatingdetail = PetVaccinatingDetail::findOrFail($id);

        $this->validate($request,[
            'date_of_vaccinating' => 'required|date',
            'animal_id' => 'required|integer',
            'vaccine_type' => 'required|string',
            'vaccine_quantity' => 'required',
            'no_of_animals' => 'required|integer'
        ]);
        
        $petvaccinatingdetail->update($request->all());
        return (['message' => 'success']);

    }

    public function destroy(Request $request,$id)
    {
        $petvaccinatingdetail = PetVaccinatingDetail::findOrFail($id);

        $petvaccinatingdetail->delete();
        return (['message' => 'deleted']);    
    }     
}
