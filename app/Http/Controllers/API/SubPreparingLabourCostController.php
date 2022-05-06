<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubPreparingLabourCost;

class SubPreparingLabourCostController extends Controller
{
    public function index()
    {
        return SubPreparingLabourCost::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'crop_id' => 'sometimes',
            'date_of_work' => 'required|date',
            'no_of_persons' => 'required|integer',
            'amount_paid' => 'required'
        ]);

        return SubPreparingLabourCost::create([
            'crop_id' => $request->get('crop_id'),
            'date_of_work' => $request->get('date_of_work'),
            'no_of_persons' => $request->get('no_of_persons'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id)
    {
        $subpreparingLabourCost = SubPreparingLabourCost::findOrFail($id);
        $this->validate($request,[
            'crop_id' => 'sometimes',
            'date_of_work' => 'required|date',
            'no_of_persons' => 'required|integer',
            'amount_paid' => 'required'
        ]);

        $subpreparingLabourCost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $subpreparingLabourCost = SubPreparingLabourCost::findOrFail($id);

        $subpreparingLabourCost->delete();
        return (['message' => 'deleted']);
    }
}
