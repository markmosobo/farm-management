<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DomesticTreatingDetail;

class DomesticTreatingDetailController extends Controller
{
    public function index()
    {
        return DomesticTreatingDetail::latest()->with('animal')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'date_of_treating' => 'required|date',
            'animal_id' => 'required|integer',
            'drug_type' => 'required|string',
            'drug_quantity' => 'required',
            'no_of_animals' => 'required|integer'
        ]);

        return DomesticTreatingDetail::create([
            'animal_id' => $request->get('animal_id'),
            'date_of_treating' => $request->get('date_of_treating'),
            'drug_type' => $request->get('drug_type'),
            'drug_quantity' => $request->get('drug_quantity'),
            'no_of_animals' => $request->get('no_of_animals'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $domestictreatingdetail = DomesticTreatingDetail::findOrFail($id);

        $this->validate($request,[
            'date_of_treating' => 'required|date',
            'animal_id' => 'required|integer',
            'drug_type' => 'required|string',
            'drug_quantity' => 'required',
            'no_of_animals' => 'required|integer'
        ]);
        
        $domestictreatingdetail->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $domestictreatingdetail = DomesticTreatingDetail::findOrFail($id);

        $domestictreatingdetail->delete();
        return (['message' => 'deleted']);        
    }    
}
