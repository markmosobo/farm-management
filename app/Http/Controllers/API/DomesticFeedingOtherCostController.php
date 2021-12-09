<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DomesticFeedingOtherCost;

class DomesticFeedingOtherCostController extends Controller
{
    public function index()
    {
        return DomesticFeedingOtherCost::latest()->paginate(5);
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

        return DomesticFeedingOtherCost::create([
            'name' => $request->get('name'),
            'date_of_payment' => $request->get('date_of_payment'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id)
    {
        $domesticfeedingothercost = DomesticFeedingOtherCost::findOrFail($id);

        $this->validate($request,[
            'name' => 'string|required',
            'date_of_payment' => 'date|required',
            'amount_paid' => 'required'
        ]);
        
        $domesticfeedingothercost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $domesticfeedingothercost = DomesticFeedingOtherCost::findOrFail($id);

        $domesticfeedingothercost->delete();
        return (['message' => 'deleted']);
    }
        
}
