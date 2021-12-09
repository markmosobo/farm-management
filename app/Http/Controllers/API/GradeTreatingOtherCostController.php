<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GradeTreatingOtherCost;

class GradeTreatingOtherCostController extends Controller
{
    public function index()
    {
        return GradeTreatingOtherCost::latest()->paginate(5);
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

        return GradeTreatingOtherCost::create([
            'name' => $request->get('name'),
            'date_of_payment' => $request->get('date_of_payment'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id)
    {
        $gradetreatingothercost =GradeTreatingOtherCost::findOrFail($id);
        
        $this->validate($request,[
            'name' => 'required|string',
            'date_of_payment' => 'required|date',
            'amount_paid' => 'required'
        ]);

        $gradetreatingothercost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $gradetreatingothercost = GradeTreatingOtherCost::findOrFail($id);

        $gradetreatingothercost->delete();
        return (['message' => 'deleted']);
    }    
}
