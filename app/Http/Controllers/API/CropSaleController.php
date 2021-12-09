<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CropSale;

class CropSaleController extends Controller
{
    public function index()
    {
        return CropSale::latest()->with('crop')->paginate(10);
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

        return CropSale::create([
            'crop_id' => $request->get('crop_id'),
            'date_of_selling' => $request->get('date_of_selling'),
            'name_of_buyer' => $request->get('name_of_buyer'),
            'quantity_sold' => $request->get('quantity_sold'),
            'amount_due' => $request->get('amount_due')
        ]);
    }

    public function update(Request $request,$id)
    {
        $cropsale = CropSale::findOrFail($id);
        $this->validate($request,[
            'crop_id' => 'required|integer',
            'date_of_selling' => 'required|date',
            'name_of_buyer' => 'required|string|max:191',
            'quantity_sold' => 'required',
            'amount_due' => 'sometimes'
        ]);
        
        $cropsale->update($request->all());
        return (['mesage' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $cropsale = CropSale::findOrFail($id);

        $cropsale->delete();
        return (['message' => 'deleted']);
    }

    public function changestatus(Request $request,$id)
    {
        $cropsale = CropSale::findOrFail($id);

        if($cropsale){
            $cropsale->update(array('status' => '1'));
            $cropsale->save;
            return (['message' => 'success']);    
        }        
    }
}
