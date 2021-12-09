<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubPlantingFertilizerCost;

class SubPlantingFertilizerCostController extends Controller
{
    public function index(){
        return SubPlantingFertilizerCost::latest()->with('crop')->paginate(5);
    }

    public function list(){
        
    }

    public function store(Request $request){
        $this->validate($request,[
            'fertilizer_type' => 'required|string',
            'crop_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string|max:191',
            'amount_paid' => 'sometimes|required'
        ]);

        return SubPlantingFertilizerCost::create([
            'fertilizer_type' => $request->get('fertilizer_type'),
            'crop_id' => $request->get('crop_id'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id){
        $subplantingfertilizercost = SubPlantingFertilizerCost::findOrFail($id);

        $this->validate($request,[
            'fertilizer_type' => 'required|string',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string|max:191',
            'amount_paid' => 'sometimes|required'
        ]);
        
        $subplantingfertilizercost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id){
        $subplantingfertilizercost = SubPlantingFertilizerCost::findOrFail($id);
        
        $subplantingfertilizercost->delete();
        return (['message' => 'deleted']);
    }    
}
