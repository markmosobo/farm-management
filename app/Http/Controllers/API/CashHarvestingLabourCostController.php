<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashHarvestingLabourCost;

class CashHarvestingLabourCostController extends Controller
{
    public function index()
    {
        return CashHarvestingLabourCost::latest()->with('crop')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'date_of_work' => 'required|date',
            'no_of_persons' => 'required|integer',
            'crop_id' => 'required|integer',
            'amount_paid' => 'required'
        ]);

        return CashHarvestingLabourCost::create([
            'crop_id' => $request->get('crop_id'),
            'date_of_work' => $request->get('date_of_work'),
            'no_of_persons' => $request->get('no_of_persons'),
            'amount_paid' => $request->get('amount_paid'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $cashharvestinglabourcost = CashHarvestingLabourCost::findOrFail($id);
        $this->validate($request,[
            'date_of_work' => 'required|date',
            'no_of_persons' => 'required|integer',
            'crop_id' => 'required|integer',
            'amount_paid' => 'required'
        ]);

        $cashharvestinglabourcost->update($request->all());
        return (['message' => 'success']);

    }

    public function destroy(Request $request,$id)
    {
        $cashharvestinglabourcost = CashHarvestingLabourCost::findOrFail($id);

        $cashharvestinglabourcost->delete();
        return (['message' => 'deleted']);
    }
}
