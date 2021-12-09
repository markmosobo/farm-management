<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashPlantingSeedCost;

class CashPlantingSeedCostController extends Controller
{
    public function index(){
        return CashPlantingSeedCost::latest()->with('crop')->paginate(5);
    }

    public function list(){

    }

    public function store(Request $request){
        $this->validate($request,[
            'seed_type' => 'required|string|max:191',
            'crop_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);

        return CashPlantingSeedCost::create([
            'seed_type' => $request->get('seed_type'),
            'crop_id' => $request->get('crop_id'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid')            
        ]);
    }

    public function update(Request $request,$id){
        $cashplantingseedcost = CashPlantingSeedCost::findOrFail($id);

        $this->validate($request,[
            'seed_type' => 'required|string|max:191',
            'crop_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);

        $cashplantingseedcost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id){
        $cashplantingseedcost = CashPlantingSeedCost::findOrFail($id);

        $cashplantingseedcost->delete();
        return (['message' => 'deleted']);
    }    
}
