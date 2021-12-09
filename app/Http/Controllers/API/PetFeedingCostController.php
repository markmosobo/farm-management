<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetFeedingCost;

class PetFeedingCostController extends Controller
{
    public function index()
    {
        return PetFeedingCost::latest()->paginate(5);
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

        return PetFeedingCost::create([
            'animal_id' => $request->get('animal_id'),
            'feed_type' => $request->get('feed_type'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid'),

        ]);
    }

    public function update(Request $request,$id)
    {
        $petfeedingcost = PetFeedingCost::findOrFail($id);

        $this->validate($request,[
            'animal_id' => 'required|integer',
            'feed_type' => 'required|string',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);
        
        $petfeedingcost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $petfeedingcost = PetFeedingCost::findOrFail($id);

        $petfeedingcost->delete();
        return (['message' => 'deleted']);
    }    
}
