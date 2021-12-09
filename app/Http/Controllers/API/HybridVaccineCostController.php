<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HybridVaccineCost;

class HybridVaccineCostController extends Controller
{
    public function index()
    {
        return HybridVaccineCost::latest()->paginate(5);
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

        return HybridVaccineCost::create([
            'poultry_id' => $request->get('poultry_id'),
            'vaccine_type' => $request->get('vaccine_type'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $hybridvaccinecost = HybridVaccineCost::findOrFail($id);

        $this->validate($request,[
            'vaccine_type' => 'required|string',
            'poultry_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);
        
        $hybridvaccinecost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $hybridvaccinecost = HybridVaccineCost::findOrFail($id);

        $hybridvaccinecost->delete();
        return (['message' => 'deleted']);    
    }     
}
