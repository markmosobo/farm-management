<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubHarvestingLabourCost;

class SubHarvestingLabourCostController extends Controller
{
    public function index()
    {
        return SubHarvestingLabourCost::latest()->with('crop')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'crop_id' => 'required|integer',
            'date_of_work' => 'required|date',
            'no_of_persons' =>  'required|integer',
            'amount_paid' => 'required'
        ]);

        return SubHarvestingLabourCost::create([
            'crop_id' => $request->get('crop_id'),
            'date_of_work' => $request->get('date_of_work'),
            'no_of_persons' => $request->get('no_of_persons'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id)
    {
        $subharvestinglabourcost = SubHarvestingLabourCost::findOrFail($id);

        $this->validate($request,[
            'crop_id' => 'required|integer',
            'date_of_work' => 'required|date',
            'no_of_persons' =>  'required|integer',
            'amount_paid' => 'required'
        ]);
        
        $subharvestinglabourcost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $subharvestinglabourcost->delete();
        return (['message' => 'deleted']);
    }
}
