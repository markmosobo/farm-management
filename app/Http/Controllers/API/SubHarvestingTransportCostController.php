<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubHarvestingTransportCost;

class SubHarvestingTransportCostController extends Controller
{
    public function index()
    {
        return SubHarvestingTransportCost::latest()->with('crop')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'crop_id' => 'required|integer',
            'transport_type' => 'required|string',
            'date_of_transaction' => 'required|date',
            'harvest_quantity' => 'required',
            'amount_paid' => 'required'
        ]);

        return SubHarvestingTransportCost::create([
            'crop_id' => $request->get('crop_id'),
            'transport_type' => $request->get('transport_type'),
            'date_of_transaction' => $request->get('date_of_transaction'),
            'harvest_quantity' => $request->get('harvest_quantity'),
            'amount_paid' => $request->get('amount_paid'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $subharvestingtransportcost = SubHarvestingTransportCost::findOrFail($id);

        $this->validate($request,[
            'crop_id' => 'required|integer',
            'transport_type' => 'required|string',
            'date_of_transaction' => 'required|date',
            'harvest_quantity' => 'required',
            'amount_paid' => 'required'
        ]);
        
        $subharvestingtransportcost->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $subharvestingtransportcost = SubHarvestingTransportCost::findOrFail($id);

        $subharvestingtransportcost->delete();
        return (['message' => 'deleted']);
    }
}
