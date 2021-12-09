<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCashCropSale;

class SubCashCropSaleController extends Controller
{
    public function index()
    {
        return SubCashCropSale::latest()->with('crop')->paginate(10);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'crop_id' => 'required|integer',
            'date_of_selling' => 'required|date',
            'name_of_buyer' => 'required|string|max:191',
            'quantity_sold' => 'required',
            'amount_due' => 'sometimes'
        ]);

        return SubCashCropSale::create([
            'crop_id' => $request->get('crop_id'),
            'date_of_selling' => $request->get('date_of_selling'),
            'name_of_buyer' => $request->get('name_of_buyer'),
            'quantity_sold' => $request->get('quantity_sold'),
            'amount_due' => $request->get('amount_due')
        ]);
    }

    public function update(Request $request,$id)
    {
        $SubCashCropSale = SubCashCropSale::findOrFail($id);
        $this->validate($request,[
            'crop_id' => 'required|integer',
            'date_of_selling' => 'required|date',
            'name_of_buyer' => 'required|string|max:191',
            'quantity_sold' => 'required',
            'amount_due' => 'sometimes'
        ]);
        
        $SubCashCropSale->update($request->all());
        return (['mesage' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $SubCashCropSale = SubCashCropSale::findOrFail($id);

        $SubCashCropSale->delete();
        return (['message' => 'deleted']);
    }    
}
