<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KienyejiTreatingOtherCost;

class KienyejiTreatingOtherCostController extends Controller
{
    public function index()
    {
        return KienyejiTreatingOtherCost::latest()->paginate(5);
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

        return KienyejiTreatingOtherCost::create([
            'name' => $request->get('name'),
            'date_of_payment' => $request->get('date_of_payment'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id)
    {
        $kienyejitreatingothercost =KienyejiTreatingOtherCost::findOrFail($id);
        
        $this->validate($request,[
            'name' => 'required|string',
            'date_of_payment' => 'required|date',
            'amount_paid' => 'required'
        ]);

        $kienyejitreatingothercost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $kienyejitreatingothercost = KienyejiTreatingOtherCost::findOrFail($id);

        $kienyejitreatingothercost->delete();
        return (['message' => 'deleted']);
    }   
}
