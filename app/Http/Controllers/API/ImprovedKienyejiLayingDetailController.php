<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImprovedKienyejiLayingDetail;

class ImprovedKienyejiLayingDetailController extends Controller
{
    public function index()
    {
        return ImprovedKienyejiLayingDetail::latest()->with('poultry')->paginate(5);
    } 

    public function store(Request $request)
    {
        $this->validate($request,[
            'date_of_laying' => 'required|date',
            'poultry_id' => 'required|integer',
            'poultry_code' => 'required|sometimes|string|max:191',
            'no_of_eggs' => 'required|integer'
        ]);

        return ImprovedKienyejiLayingDetail::create([
            'poultry_id' => $request->get('poultry_id'),
            'date_of_laying' => $request->get('date_of_laying'),
            'poultry_code' => $request->get('poultry_code'),
            'no_of_eggs' => $request->get('no_of_eggs'),
        ]);

    }

    public function update(Request $request,$id)
    {
        $improvedkienyejilayingdetail = ImprovedKienyejiLayingDetail::findOrFail($id);

        $this->validate($request,[
            'date_of_laying' => 'required|date',
            'poultry_id' => 'required|integer',
            'poultry_code' => 'required|sometimes|string|max:191',
            'no_of_eggs' => 'required|integer'
        ]);

        $improvedkienyejilayingdetail->update($request->all());
        return (['message' => 'success']);        
    }

    public function destroy(Request $request,$id)
    {
        $improvedkienyejilayingdetail = ImprovedKienyejiLayingDetail::findOrFail($id);

        $improvedkienyejilayingdetail->delete();
        return (['message' => 'deleted']);
    }    
}
