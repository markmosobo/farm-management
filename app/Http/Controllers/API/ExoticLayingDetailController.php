<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExoticLayingDetail;

class ExoticLayingDetailController extends Controller
{
    public function index()
    {
        return ExoticLayingDetail::latest()->with('poultry')->paginate(5);
    } 

    public function store(Request $request)
    {
        $this->validate($request,[
            'date_of_laying' => 'required|date',
            'poultry_id' => 'required|integer',
            'poultry_code' => 'required|sometimes|string|max:191',
            'no_of_eggs' => 'required|integer'
        ]);

        return ExoticLayingDetail::create([
            'poultry_id' => $request->get('poultry_id'),
            'date_of_laying' => $request->get('date_of_laying'),
            'poultry_code' => $request->get('poultry_code'),
            'no_of_eggs' => $request->get('no_of_eggs'),
        ]);

    }

    public function update(Request $request,$id)
    {
        $exoticlayingdetail = ExoticLayingDetail::findOrFail($id);

        $this->validate($request,[
            'date_of_laying' => 'required|date',
            'poultry_id' => 'required|integer',
            'poultry_code' => 'required|sometimes|string|max:191',
            'no_of_eggs' => 'required|integer'
        ]);

        $exoticlayingdetail->update($request->all());
        return (['message' => 'success']);        
    }

    public function destroy(Request $request,$id)
    {
        $exoticlayingdetail = ExoticLayingDetail::findOrFail($id);

        $exoticlayingdetail->delete();
        return (['message' => 'deleted']);
    }    
}
