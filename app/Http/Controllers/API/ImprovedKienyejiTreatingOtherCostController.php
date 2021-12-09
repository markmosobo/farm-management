<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImprovedKienyejiTreatingOtherCost;

class ImprovedKienyejiTreatingOtherCostController extends Controller
{
    public function index()
    {
        return ImprovedKienyejiTreatingOtherCost::latest()->paginate(5);
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

        return ImprovedKienyejiTreatingOtherCost::create([
            'name' => $request->get('name'),
            'date_of_payment' => $request->get('date_of_payment'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id)
    {
        $improvedkienyejitreatingothercost =ImprovedKienyejiTreatingOtherCost::findOrFail($id);
        
        $this->validate($request,[
            'name' => 'required|string',
            'date_of_payment' => 'required|date',
            'amount_paid' => 'required'
        ]);

        $improvedkienyejitreatingothercost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $improvedkienyejitreatingothercost = ImprovedKienyejiTreatingOtherCost::findOrFail($id);

        $improvedkienyejitreatingothercost->delete();
        return (['message' => 'deleted']);
    }    
}
