<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KienyejiFeedingCost;

class KienyejiFeedingCostController extends Controller
{
    public function index()
    {
        return KienyejiFeedingCost::latest()->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'poultry_id' => 'required|integer',
            'feed_type' => 'required|string',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);

        return KienyejiFeedingCost::create([
            'poultry_id' => $request->get('poultry_id'),
            'feed_type' => $request->get('feed_type'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid'),

        ]);
    }

    public function update(Request $request,$id)
    {
        $kienyejifeedingcost = KienyejiFeedingCost::findOrFail($id);

        $this->validate($request,[
            'poultry_id' => 'required|integer',
            'feed_type' => 'required|string',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);
        
        $kienyejifeedingcost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $kienyejifeedingcost = KienyejiFeedingCost::findOrFail($id);

        $kienyejifeedingcost->delete();
        return (['message' => 'deleted']);
    }    
}
