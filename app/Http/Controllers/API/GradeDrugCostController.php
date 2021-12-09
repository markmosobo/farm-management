<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GradeDrugCost;

class GradeDrugCostController extends Controller
{
    public function index()
    {
        return GradeDrugCost::latest()->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'drug_type' => 'required|string',
            'poultry_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);

        return GradeDrugCost::create([
            'poultry_id' => $request->get('poultry_id'),
            'drug_type' => $request->get('drug_type'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $gradedrugcost = GradeDrugCost::findOrFail($id);

        $this->validate($request,[
            'drug_type' => 'required|string',
            'poultry_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);
        
        $gradedrugcost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $gradedrugcost = GradeDrugCost::findOrFail($id);

        $gradedrugcost->delete();
        return (['message' => 'deleted']);    
    }   
}
