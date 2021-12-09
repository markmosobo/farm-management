<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KienyejiEggSale;

class KienyejiEggSaleController extends Controller
{
    public function index()
    {
        return KienyejiEggSale::latest()->with('poultry')->paginate(5);
    }
    
    public function store(Request $request)
    {
        $this->validate($request,[
            'poultry_id' => 'required|integer',
            'date_of_sale' => 'required|date',
            'no_sold' => 'required|integer',
            'amount_got' => 'required'
        ]);

        return KienyejiEggSale::create([
            'poultry_id' => $request->get('poultry_id'),
            'date_of_sale' => $request->get('date_of_sale'),
            'no_sold' => $request->get('no_sold'),
            'amount_got' => $request->get('amount_got'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $kienyejieggsale = KienyejiEggSale::findOrFail($id);

        $this->validate($request,[
            'poultry_id' => 'required|integer',
            'date_of_sale' => 'required|date',
            'no_sold' => 'required|integer',
            'amount_got' => 'required'
        ]);
        
        $kienyejieggsale->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $kienyejieggsale = KienyejiEggSale::findOrFail($id);

        $kienyejieggsale->delete();
        return (['message' => 'deleted']);
    }    
}
