<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DomesticTreatingOtherCost;

class DomesticTreatingOtherCostController extends Controller
{
    public function index()
    {
        return DomesticTreatingOtherCost::latest()->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'date_of_payment' => 'required|date',
            'amount_paid' => 'required'
        ]);

        return DomesticTreatingOtherCost::create([
            'name' => $request->get('name'),
            'date_of_payment' => $request->get('date_of_payment'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id)
    {
        $domestictreatingothercost =DomesticTreatingOtherCost::findOrFail($id);
        
        $this->validate($request,[
            'name' => 'required|string',
            'date_of_payment' => 'required|date',
            'amount_paid' => 'required'
        ]);

        $domestictreatingothercost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $domestictreatingothercost = DomesticTreatingOtherCost::findOrFail($id);

        $domestictreatingothercost->delete();
        return (['message' => 'deleted']);
    }     
}
