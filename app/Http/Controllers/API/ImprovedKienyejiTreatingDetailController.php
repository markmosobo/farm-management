<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImprovedKienyejiTreatingDetail;

class ImprovedKienyejiTreatingDetailController extends Controller
{
    public function index()
    {
        return ImprovedKienyejiTreatingDetail::latest()->with('poultry')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'date_of_treating' => 'required|date',
            'poultry_id' => 'required|integer',
            'no_of_poultries' => 'required|integer',
            'drug_type' => 'required|string',
            'drug_quantity' => 'required|string'
        ]);

        return ImprovedKienyejiTreatingDetail::create([
            'poultry_id' => $request->get('poultry_id'),
            'date_of_treating' => $request->get('date_of_treating'),
            'no_of_poultries' => $request->get('no_of_poultries'),
            'drug_type' => $request->get('drug_type'),
            'drug_quantity' => $request->get('drug_quantity'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $improvedkienyejitreatingdetail = ImprovedKienyejiTreatingDetail::findOrFail($id);

        $this->validate($request,[
            'date_of_treating' => 'required|date',
            'poultry_id' => 'required|integer',
            'no_of_poultries' => 'required|integer',
            'drug_type' => 'required|string',
            'drug_quantity' => 'required|string'
        ]);
        
        $improvedkienyejitreatingdetail->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $improvedkienyejitreatingdetail = ImprovedKienyejiTreatingDetail::findOrFail($id);

        $improvedkienyejitreatingdetail->delete();
        return (['message' => 'deleted']);
    }   
}
