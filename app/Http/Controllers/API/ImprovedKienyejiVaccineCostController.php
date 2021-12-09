<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImprovedKienyejiVaccineCost;

class ImprovedKienyejiVaccineCostController extends Controller
{
    public function index()
    {
        return ImprovedKienyejiVaccineCost::latest()->paginate(5);
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

        return ImprovedKienyejiVaccineCost::create([
            'poultry_id' => $request->get('poultry_id'),
            'vaccine_type' => $request->get('vaccine_type'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $improvedkienyejivaccinecost = ImprovedKienyejiVaccineCost::findOrFail($id);

        $this->validate($request,[
            'vaccine_type' => 'required|string',
            'poultry_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);
        
        $improvedkienyejivaccinecost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $improvedkienyejivaccinecost = ImprovedKienyejiVaccineCost::findOrFail($id);

        $improvedkienyejivaccinecost->delete();
        return (['message' => 'deleted']);    
    }    
}
