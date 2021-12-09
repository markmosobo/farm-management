<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DomesticDrugCost;

class DomesticDrugCostController extends Controller
{
    public function index()
    {
        return DomesticDrugCost::latest()->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'drug_type' => 'required|string',
            'animal_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);

        return DomesticDrugCost::create([
            'animal_id' => $request->get('animal_id'),
            'drug_type' => $request->get('drug_type'),
            'date_of_purchase' => $request->get('date_of_purchase'),
            'quantity_bought' => $request->get('quantity_bought'),
            'amount_paid' => $request->get('amount_paid'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $domesticdrugcost = DomesticDrugCost::findOrFail($id);

        $this->validate($request,[
            'drug_type' => 'required|string',
            'animal_id' => 'required|integer',
            'date_of_purchase' => 'required|date',
            'quantity_bought' => 'required|string',
            'amount_paid' => 'required'
        ]);
        
        $domesticdrugcost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $domesticdrugcost = DomesticDrugCost::findOrFail($id);

        $domesticdrugcost->delete();
        return (['message' => 'deleted']);    
    }     
}
