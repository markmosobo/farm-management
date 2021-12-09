<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashWeedingChemicalCost;

class CashWeedingChemicalCostController extends Controller
{
    public function index(){
        return CashWeedingChemicalCost::latest()->with('crop')->paginate(5);
    }

    public function list(){
        
    }

    public function store(Request $request){
        $this->validate($request,[
            'chemical_type' => 'required|string',
            'crop_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string|max:191',
            'amount_paid' => 'sometimes|required|regex:/^\d{1,13}(\.\d{1,4})?$/'
        ]);

        return CashWeedingChemicalCost::create([
            'chemical_type' => $request->get('chemical_type'),
            'crop_id' => $request->get('crop_id'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id){
        $cashweedingchemicalcost = CashWeedingChemicalCost::findOrFail($id);

        $this->validate($request,[
            'chemical_type' => 'required|string',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string|max:191',
            'amount_paid' => 'sometimes|required'
        ]);
        
        $cashweedingchemicalcost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id){
        $cashweedingchemicalcost = CashWeedingChemicalCost::findOrFail($id);
        
        $cashweedingchemicalcost->delete();
        return (['message' => 'deleted']);
    }    
}
