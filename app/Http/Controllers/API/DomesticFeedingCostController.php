<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DomesticFeedingCost;

class DomesticFeedingCostController extends Controller
{
    public function index()
    {
        return DomesticFeedingCost::latest()->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'animal_id' => 'required|integer',
            'feed_type' => 'required|string',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);

        return DomesticFeedingCost::create([
            'animal_id' => $request->get('animal_id'),
            'feed_type' => $request->get('feed_type'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid'),

        ]);
    }

    public function update(Request $request,$id)
    {
        $domesticfeedingcost = DomesticFeedingCost::findOrFail($id);

        $this->validate($request,[
            'animal_id' => 'required|integer',
            'feed_type' => 'required|string',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);
        
        $domesticfeedingcost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $domesticfeedingcost = DomesticFeedingCost::findOrFail($id);

        $domesticfeedingcost->delete();
        return (['message' => 'deleted']);
    }    
}
