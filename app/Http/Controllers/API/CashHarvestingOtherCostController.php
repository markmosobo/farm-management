<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashHarvestingOtherCost;

class CashHarvestingOtherCostController extends Controller
{
    public function index()
    {
        return CashHarvestingOtherCost::latest()->paginate(5);
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

        return CashHarvestingOtherCost::create([
            'name' => $request->get('name'),
            'date_of_payment' => $request->get('date_of_payment'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id)
    {
        $cashharvestingothercost = CashHarvestingOtherCost::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|string',
            'date_of_payment' => 'required|date',
            'amount_paid' => 'required'
        ]);
        
        $cashharvestingothercost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $cashharvestingothercost = CashHarvestingOtherCost::findOrFail($id);
        $cashharvestingothercost->delete();
        return (['message' => 'deleted']);
    }
}
