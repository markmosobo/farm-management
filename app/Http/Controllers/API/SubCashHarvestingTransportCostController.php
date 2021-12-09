<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCashHarvestingTransportCost;

class SubCashHarvestingTransportCostController extends Controller
{
    public function index()
    {
        return SubCashHarvestingTransportCost::latest()->with('crop')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'crop_id' => 'required|integer',
            'date_of_transaction' => 'required|date',
            'transport_type' => 'sometimes|required',
            'harvest_quantity' => 'required',
            'amount_paid' => 'required'
        ]);

        return SubCashHarvestingTransportCost::create([
            'crop_id' => $request->get('crop_id'),
            'date_of_transaction' => $request->get('date_of_transaction'),
            'transport_type' => $request->get('transport_type'),
            'harvest_quantity' => $request->get('harvest_quantity'),
            'amount_paid' => $request->get('amount_paid'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $subcashharvestingtransportcost = SubCashHarvestingTransportCost::findOrFail($id);

        $this->validate($request,[
            'crop_id' => 'required|integer',
            'date_of_transaction' => 'required|date',
            'transport_type' => 'sometimes|required',
            'harvest_quantity' => 'required',
            'amount_paid' => 'required'
        ]);
        
        $subcashharvestingtransportcost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $subcashharvestingtransportcost = SubCashHarvestingTransportCost::findOrFail($id);

        $subcashharvestingtransportcost->delete();
        return (['message' => 'deleted']);
    }    
}
