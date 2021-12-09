<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubWeedingToolCost;

class SubWeedingToolCostController extends Controller
{
    public function index(){
        return SubWeedingToolCost::latest()->with('crop')->paginate(5);
    }

    public function list(){

    }

    public function store(Request $request){
        $this->validate($request,[
            'tool_type' => 'required|string|max:191',
            'crop_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);

        return SubWeedingToolCost::create([
            'tool_type' => $request->get('tool_type'),
            'crop_id' => $request->get('crop_id'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid')            
        ]);
    }

    public function update(Request $request,$id){
        $subweedingtoolcost = SubWeedingToolCost::findOrFail($id);

        $this->validate($request,[
            'tool_type' => 'required|string|max:191',
            'crop_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);

        $subweedingtoolcost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id){
        $subweedingtoolcost = SubWeedingToolCost::findOrFail($id);

        $subweedingtoolcost->delete();
        return (['message' => 'deleted']);
    }  
}
