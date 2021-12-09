<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnimalProductOtherUse;

class AnimalProductOtherUseController extends Controller
{
    public function index()
    {
        return AnimalProductOtherUse::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'date_of_retrieval' => 'required|date',
            'quantity_used' => 'required'
        ]);

        return AnimalProductOtherUse::create([
            'name' => $request->get('name'),
            'date_of_retrieval' => $request->get('date_of_retrieval'),
            'quantity_used' => $request->get('quantity_used')
        ]);
    }

    public function update(Request $request,$id)
    {
        $animalproductotheruse = AnimalProductOtherUse::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string',
            'date_of_retrieval' => 'required|date',
            'quantity_used' => 'required'
        ]);
        
        $animalproductotheruse->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $animalproductotheruse = AnimalProductOtherUse::findOrFail($id);

        $animalproductotheruse->delete();
        return (['message' => 'deleted']);
    }    
}
