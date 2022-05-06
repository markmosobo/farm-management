<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SubPreparingOtherCost;
class SubPreparingOtherCostController extends Controller
{
    public function index()
    {
        return SubPreparingOtherCost::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'date_of_payment' => 'required|date',
            'amount_paid' => 'required'
        ]);

        return SubPreparingOtherCost::create([
            'name' => $request->get('name'),
            'date_of_payment' => $request->get('date_of_payment'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id)
    {
        $subpreparingOtherCost = SubPreparingOtherCost::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|string',
            'date_of_payment' => 'required|date',
            'amount_paid' => 'required'
        ]);

        $subpreparingOtherCost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $subpreparingOtherCost = SubPreparingOtherCost::findOrFail($id);

        $subpreparingOtherCost->delete();
        return (['message' => 'deleted']);
    }
}
