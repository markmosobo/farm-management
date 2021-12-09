<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCashPlantingOtherCost;

class SubCashPlantingOtherCostController extends Controller
{
    public function index(){
        return SubCashPlantingOtherCost::latest()->paginate(5);
    }

    public function list(){

    }

    public function store(Request $request){
        $this->validate($request,[
            'date_of_payment' => 'required|date',
            'name' => 'required|string|max:191',
            'amount_paid' => 'required'
        ]);

        return SubCashPlantingOtherCost::create([
            'date_of_payment' => $request->get('date_of_payment'),
            'name' => $request->get('name'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id){
        $subcashplantingothercost = SubCashPlantingOtherCost::findOrFail($id);

        $this->validate($request,[
            'date_of_payment' => 'required|date',
            'name' => 'required|string|max:191',
            'amount_paid' => 'required'
        ]);
        
        $subcashplantingothercost->update($request->all());
        return (['message' => 'success']);
        
    }

    public function destroy(Request $request,$id){
        $subcashplantingothercost = SubCashPlantingOtherCost::findOrFail($id);
        
        $subcashplantingothercost->delete();
        return (['message' => 'deleted']);
    }    
}
