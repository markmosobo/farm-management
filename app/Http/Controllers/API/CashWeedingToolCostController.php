<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashWeedingToolCost;

class CashWeedingToolCostController extends Controller
{
    public function index(){
        return CashWeedingToolCost::latest()->with('crop')->paginate(5);
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

        return CashWeedingToolCost::create([
            'tool_type' => $request->get('tool_type'),
            'crop_id' => $request->get('crop_id'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid')            
        ]);
    }

    public function update(Request $request,$id){
        $cashweedingtoolcost = CashWeedingToolCost::findOrFail($id);

        $this->validate($request,[
            'tool_type' => 'required|string|max:191',
            'crop_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);

        $cashweedingtoolcost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id){
        $cashweedingtoolcost = CashWeedingToolCost::findOrFail($id);

        $cashweedingtoolcost->delete();
        return (['message' => 'deleted']);
    }    
}
