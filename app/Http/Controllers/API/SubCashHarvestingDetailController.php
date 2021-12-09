<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCashHarvestingDetail;

class SubCashHarvestingDetailController extends Controller
{
    public function index()
    {
        return SubCashHarvestingDetail::latest()->with('crop')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'crop_id' => 'required|integer',
            'date_of_harvesting' => 'required|date',
            'tools_used' => 'sometimes',
            'tools_usagerate' => 'sometimes',
            'harvest_quantity' => 'required',
            'acreage_harvested' => 'required'
        ]);

        return SubCashHarvestingDetail::create([
            'crop_id' => $request->get('crop_id'),
            'date_of_harvesting' => $request->get('date_of_harvesting'),
            'tools_used' => $request->get('tools_used'),
            'tools_usagerate' => $request->get('tools_usagerate'),
            'harvest_quantity' => $request->get('harvest_quantity'),
            'acreage_harvested' => $request->get('acreage_harvested'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $subcashharvestingdetail = SubCashHarvestingDetail::findOrFail($id);

        $this->validate($request,[
            'crop_id' => 'required|integer',
            'date_of_harvesting' => 'required|date',
            'tools_used' => 'sometimes',
            'tools_usagerate' => 'sometimes',
            'harvest_quantity' => 'required',
            'acreage_harvested' => 'required'
        ]);
        
        $subcashharvestingdetail->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $subcashharvestingdetail = SubCashHarvestingDetail::findOrFail($id);

        $subcashharvestingdetail->delete();
        return (['message' => 'deleted']);
    }    
}
