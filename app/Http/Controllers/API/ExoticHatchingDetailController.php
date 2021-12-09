<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExoticHatchingDetail;

class ExoticHatchingDetailController extends Controller
{
    public function index()
    {
        return ExoticHatchingDetail::latest()->with('poultry')->paginate(5);
    } 

    public function store(Request $request)
    {
        $this->validate($request,[
            'date_of_hatching' => 'required|date',
            'poultry_id' => 'required|integer',
            'poultry_code' => 'required|sometimes|string|max:191',
            'no_of_eggs' => 'required|integer'
        ]);

        return ExoticHatchingDetail::create([
            'poultry_id' => $request->get('poultry_id'),
            'date_of_hatching' => $request->get('date_of_hatching'),
            'poultry_code' => $request->get('poultry_code'),
            'no_of_eggs' => $request->get('no_of_eggs'),
        ]);

    }

    public function update(Request $request,$id)
    {
        $exotichatchingdetail = ExoticHatchingDetail::findOrFail($id);

        $this->validate($request,[
            'date_of_hatching' => 'required|date',
            'poultry_id' => 'required|integer',
            'poultry_code' => 'required|sometimes|string|max:191',
            'no_of_eggs' => 'required|integer'
        ]);

        $exotichatchingdetail->update($request->all());
        return (['message' => 'success']);        
    }

    public function destroy(Request $request,$id)
    {
        $exotichatchingdetail = ExoticHatchingDetail::findOrFail($id);

        $exotichatchingdetail->delete();
        return (['message' => 'deleted']);
    }    
}
