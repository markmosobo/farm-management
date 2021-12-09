<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExoticVaccineCost;

class ExoticVaccineCostController extends Controller
{
    public function index()
    {
        return ExoticVaccineCost::latest()->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'vaccine_type' => 'required|string',
            'poultry_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);

        return ExoticVaccineCost::create([
            'poultry_id' => $request->get('poultry_id'),
            'vaccine_type' => $request->get('vaccine_type'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $exoticvaccinecost = ExoticVaccineCost::findOrFail($id);

        $this->validate($request,[
            'vaccine_type' => 'required|string',
            'poultry_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);
        
        $exoticvaccinecost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $exoticvaccinecost = ExoticVaccineCost::findOrFail($id);

        $exoticvaccinecost->delete();
        return (['message' => 'deleted']);    
    }     
}
