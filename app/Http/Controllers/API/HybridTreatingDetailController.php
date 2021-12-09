<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HybridTreatingDetail;

class HybridTreatingDetailController extends Controller
{
    public function index()
    {
        return HybridTreatingDetail::latest()->with('poultry')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'date_of_treating' => 'required|date',
            'poultry_id' => 'required|integer',
            'drug_type' => 'required|string',
            'drug_quantity' => 'required',
            'no_of_poultries' => 'required|integer'
        ]);

        return HybridTreatingDetail::create([
            'poultry_id' => $request->get('poultry_id'),
            'date_of_treating' => $request->get('date_of_treating'),
            'drug_type' => $request->get('drug_type'),
            'drug_quantity' => $request->get('drug_quantity'),
            'no_of_poultries' => $request->get('no_of_poultries'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $hybridtreatingdetail = HybridTreatingDetail::findOrFail($id);

        $this->validate($request,[
            'date_of_treating' => 'required|date',
            'poultry_id' => 'required|integer',
            'drug_type' => 'required|string',
            'drug_quantity' => 'required',
            'no_of_poultries' => 'required|integer'
        ]);
        
        $hybridtreatingdetail->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $hybridtreatingdetail = HybridTreatingDetail::findOrFail($id);

        $hybridtreatingdetail->delete();
        return (['message' => 'deleted']);        
    }    
}
