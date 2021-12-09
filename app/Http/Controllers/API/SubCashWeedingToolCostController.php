<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCashWeedingToolCost;

class SubCashWeedingToolCostController extends Controller
{
    public function index(){
        return SubCashWeedingToolCost::latest()->with('crop')->paginate(5);
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

        return SubCashWeedingToolCost::create([
            'tool_type' => $request->get('tool_type'),
            'crop_id' => $request->get('crop_id'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid')            
        ]);
    }

    public function update(Request $request,$id){
        $subcashweedingtoolcost = SubCashWeedingToolCost::findOrFail($id);

        $this->validate($request,[
            'tool_type' => 'required|string|max:191',
            'crop_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);

        $subcashweedingtoolcost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id){
        $subcashweedingtoolcost = SubCashWeedingToolCost::findOrFail($id);

        $subcashweedingtoolcost->delete();
        return (['message' => 'deleted']);
    }    
}
