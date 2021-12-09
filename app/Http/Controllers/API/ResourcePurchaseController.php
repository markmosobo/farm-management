<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResourcePurchase;

class ResourcePurchaseController extends Controller
{
    public function index()
    {
        return ResourcePurchase::latest()->with('resource')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'resource_id' => 'required|integer',
            'date_of_purchasing' => 'required|date',
            'source_of_purchase' => 'required|sometimes|string|max:191',
            'purchase_quantity' => 'required|string',
            'amount_paid' => 'required'
        ]);

        return ResourcePurchase::create([
            'resource_id' => $request->get('resource_id'),
            'date_of_purchasing' => $request->get('date_of_purchasing'),
            'source_of_purchase' => $request->get('source_of_purchase'),
            'purchase_quantity' => $request->get('purchase_quantity'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id)
    {
        $resourcepurchase = ResourcePurchase::findOrFail($id);

        $this->validate($request,[
            'resource_id' => 'required|integer',
            'date_of_purchasing' => 'required|date',
            'source_of_purchase' => 'required|sometimes|string|max:191',
            'purchase_quantity' => 'required|string',
            'amount_paid' => 'required'
        ]);

        $resourcepurchase->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $resourcepurchase = ResourcePurchase::findOrFail($id);

        $resourcepurchase->delete();
        return (['message' => 'deleted']);
    }
}
