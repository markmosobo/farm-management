<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnimalSale;

class AnimalSaleController extends Controller
{
    public function index()
    {
        return AnimalSale::latest()->with('animal')->paginate(5);
    }
    
    public function store(Request $request)
    {
        $this->validate($request,[
            'animal_id' => 'required|integer',
            'date_of_sale' => 'required|date',
            'no_sold' => 'required|integer',
            'amount_got' => 'required'
        ]);

        return AnimalSale::create([
            'animal_id' => $request->get('animal_id'),
            'date_of_sale' => $request->get('date_of_sale'),
            'no_sold' => $request->get('no_sold'),
            'amount_got' => $request->get('amount_got'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $animalsale = AnimalSale::findOrFail($id);

        $this->validate($request,[
            'animal_id' => 'required|integer',
            'date_of_sale' => 'required|date',
            'no_sold' => 'required|integer',
            'amount_got' => 'required'
        ]);
        
        $animalsale->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $animalsale = AnimalSale::findOrFail($id);

        $animalsale->delete();
        return (['message' => 'deleted']);
    }     
}
