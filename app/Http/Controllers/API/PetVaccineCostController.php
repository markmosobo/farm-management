<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetVaccineCost;

class PetVaccineCostController extends Controller
{
    public function index()
    {
        return PetVaccineCost::latest()->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'vaccine_type' => 'required|string',
            'animal_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);

        return PetVaccineCost::create([
            'animal_id' => $request->get('animal_id'),
            'vaccine_type' => $request->get('vaccine_type'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $petvaccinecost = PetVaccineCost::findOrFail($id);

        $this->validate($request,[
            'vaccine_type' => 'required|string',
            'animal_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);
        
        $petvaccinecost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $petvaccinecost = PetVaccineCost::findOrFail($id);

        $petvaccinecost->delete();
        return (['message' => 'deleted']);    
    }    
}
