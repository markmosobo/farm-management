<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GradeFeedingOtherCost;

class GradeFeedingOtherCostController extends Controller
{
    public function index()
    {
        return GradeFeedingOtherCost::latest()->paginate(5);
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

        return GradeFeedingOtherCost::create([
            'name' => $request->get('name'),
            'date_of_payment' => $request->get('date_of_payment'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id)
    {
        $gradefeedingothercost = GradeFeedingOtherCost::findOrFail($id);

        $this->validate($request,[
            'name' => 'string|required',
            'date_of_payment' => 'date|required',
            'amount_paid' => 'required'
        ]);
        
        $gradefeedingothercost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $gradefeedingothercost = GradeFeedingOtherCost::findOrFail($id);

        $gradefeedingothercost->delete();
        return (['message' => 'deleted']);
    }
    
}
