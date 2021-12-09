<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetFeedingOtherCost;

class PetFeedingOtherCostController extends Controller
{
    public function index()
    {
        return PetFeedingOtherCost::latest()->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'string|required',
            'date_of_payment' => 'date|required',
            'amount_paid' => 'required'
        ]);

        return PetFeedingOtherCost::create([
            'name' => $request->get('name'),
            'date_of_payment' => $request->get('date_of_payment'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id)
    {
        $PetFeedingOtherCost = PetFeedingOtherCost::findOrFail($id);

        $this->validate($request,[
            'name' => 'string|required',
            'date_of_payment' => 'date|required',
            'amount_paid' => 'required'
        ]);
        
        $PetFeedingOtherCost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $PetFeedingOtherCost = PetFeedingOtherCost::findOrFail($id);

        $PetFeedingOtherCost->delete();
        return (['message' => 'deleted']);
    }    
}
