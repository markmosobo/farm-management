<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCashWeedingLabourCost;

class SubCashWeedingLabourCostController extends Controller
{
    public function index(){
        return SubCashWeedingLabourCost::latest()->with('crop')->paginate(5);
    }

    public function list(){

    }

    public function store(Request $request){
        $this->validate($request,[
            'date_of_work' => 'required|date',
            'crop_id' => 'required|integer',
            'no_of_persons' => 'required|integer',
            'amount_paid' => 'required'
        ]);

        return SubCashWeedingLabourCost::create([
            'date_of_work' => $request->get('date_of_work'),
            'crop_id' => $request->get('crop_id'),
            'no_of_persons' => $request->get('no_of_persons'),
            'amount_paid' => $request->get('amount_paid')            
        ]);
    }

    public function update(Request $request,$id){
        $subcashweedinglabourcost = SubCashWeedingLabourCost::findOrFail($id);

        $this->validate($request,[
            'date_of_work' => 'required|date',
            'crop_id' => 'required|integer',
            'no_of_persons' => 'required|integer',
            'amount_paid' => 'required'
        ]);
        
        $subcashweedinglabourcost->update($request->all());

        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id){
        $subcashweedinglabourcost = SubCashWeedingLabourCost::findOrFail($id);

        $subcashweedinglabourcost->delete();
        return (['message' => 'deleted']);
    }     
}
