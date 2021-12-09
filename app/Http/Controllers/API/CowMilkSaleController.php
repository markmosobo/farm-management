<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CowMilkSale;

class CowMilkSaleController extends Controller
{
    public function index()
    {
        return CowMilkSale::latest()->with('animal')->paginate(5);
    }
    
    public function store(Request $request)
    {
        $this->validate($request,[
            'date_of_sale' => 'required|date',
            'quantity_sold' => 'required',
            'amount_got' => 'required'
        ]);

        return CowMilkSale::create([
            'date_of_sale' => $request->get('date_of_sale'),
            'quantity_sold' => $request->get('quantity_sold'),
            'amount_got' => $request->get('amount_got'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $cowmilksale = CowMilkSale::findOrFail($id);

        $this->validate($request,[
            'date_of_sale' => 'required|date',
            'quantity_sold' => 'required',
            'amount_got' => 'required'
        ]);
        
        $cowmilksale->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $cowmilksale = CowMilkSale::findOrFail($id);

        $cowmilksale->delete();
        return (['message' => 'deleted']);
    }    
}
