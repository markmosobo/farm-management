<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResourceSale;

class ResourceSaleController extends Controller
{
    public function index()
    {
        return ResourceSale::latest()->with('resource')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'resource_id' => 'required|integer',
            'date_of_selling' => 'required|date',
            'source_of_sale' => 'required|sometimes|string|max:191',
            'sale_quantity' => 'required|string',
            'amount_paid' => 'required'
        ]);

        return ResourceSale::create([
            'resource_id' => $request->get('resource_id'),
            'date_of_selling' => $request->get('date_of_selling'),
            'source_of_sale' => $request->get('source_of_sale'),
            'sale_quantity' => $request->get('sale_quantity'),
            'amount_paid' => $request->get('amount_paid')
        ]);
    }

    public function update(Request $request,$id)
    {
        $resourcesale = ResourceSale::findOrFail($id);

        $this->validate($request,[
            'resource_id' => 'required|integer',
            'date_of_selling' => 'required|date',
            'source_of_sale' => 'required|sometimes|string|max:191',
            'sale_quantity' => 'required|string',
            'amount_paid' => 'required'
        ]);

        $resourcesale->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $resourcesale = ResourceSale::findOrFail($id);

        $resourcesale->delete();
        return (['message' => 'deleted']);
    }    
}
