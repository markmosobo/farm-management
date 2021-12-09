<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtherAnimalMilkSale;

class OtherAnimalMilkSaleController extends Controller
{
    public function index()
    {
        return OtherAnimalMilkSale::latest()->with('animal')->paginate(5);
    }
    
    public function store(Request $request)
    {
        $this->validate($request,[
            'date_of_sale' => 'required|date',
            'animal_id' => 'required|integer',
            'quantity_sold' => 'required',
            'amount_got' => 'required'
        ]);

        return OtherAnimalMilkSale::create([
            'date_of_sale' => $request->get('date_of_sale'),
            'animal_id' => $request->get('animal_id'),
            'quantity_sold' => $request->get('quantity_sold'),
            'amount_got' => $request->get('amount_got'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $otheranimalmilksale = OtherAnimalMilkSale::findOrFail($id);

        $this->validate($request,[
            'date_of_sale' => 'required|date',
            'animal_id' => 'required|integer',
            'quantity_sold' => 'required',
            'amount_got' => 'required'
        ]);
        
        $otheranimalmilksale->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $otheranimalmilksale = OtherAnimalMilkSale::findOrFail($id);

        $otheranimalmilksale->delete();
        return (['message' => 'deleted']);
    }    
}
