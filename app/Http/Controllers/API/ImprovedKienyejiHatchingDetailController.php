<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImprovedKienyejiHatchingDetail;

class ImprovedKienyejiHatchingDetailController extends Controller
{
    public function index()
    {
        return ImprovedKienyejiHatchingDetail::latest()->with('poultry')->paginate(5);
    } 

    public function store(Request $request)
    {
        $this->validate($request,[
            'date_of_hatching' => 'required|date',
            'poultry_id' => 'required|integer',
            'poultry_code' => 'required|sometimes|string|max:191',
            'no_of_eggs' => 'required|integer'
        ]);

        return ImprovedKienyejiHatchingDetail::create([
            'poultry_id' => $request->get('poultry_id'),
            'date_of_hatching' => $request->get('date_of_hatching'),
            'poultry_code' => $request->get('poultry_code'),
            'no_of_eggs' => $request->get('no_of_eggs'),
        ]);

    }

    public function update(Request $request,$id)
    {
        $improvedkienyejihatchingdetail = ImprovedKienyejiHatchingDetail::findOrFail($id);

        $this->validate($request,[
            'date_of_hatching' => 'required|date',
            'poultry_id' => 'required|integer',
            'poultry_code' => 'required|sometimes|string|max:191',
            'no_of_eggs' => 'required|integer'
        ]);

        $improvedkienyejihatchingdetail->update($request->all());
        return (['message' => 'success']);        
    }

    public function destroy(Request $request,$id)
    {
        $improvedkienyejihatchingdetail = ImprovedKienyejiHatchingDetail::findOrFail($id);

        $improvedkienyejihatchingdetail->delete();
        return (['message' => 'deleted']);
    }    
}
