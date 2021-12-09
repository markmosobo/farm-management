<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtherAnimalMilkingDetail;

class OtherAnimalMilkingDetailController extends Controller
{
    public function index()
    {
        return OtherAnimalMilkingDetail::latest()->with('animal')->paginate(5);
    } 

    public function store(Request $request)
    {
        $this->validate($request,[
            'date_of_milking' => 'required|date',
            'animal_id' => 'required|integer',
            'animal_code' => 'required|sometimes|string|max:191',
            'milk_quantity' => 'required',
            'milker_name' => 'required|string'
        ]);

        return OtherAnimalMilkingDetail::create([
            'animal_id' => $request->get('animal_id'),
            'date_of_milking' => $request->get('date_of_milking'),
            'otheranimal_name' => $request->get('otheranimal_name'),
            'milk_quantity' => $request->get('milk_quantity'),
        ]);

    }

    public function update(Request $request,$id)
    {
        $otheranimalmilkingdetail = OtherAnimalMilkingDetail::findOrFail($id);

        $this->validate($request,[
            'date_of_milking' => 'required|date',
            'animal_id' => 'required|integer',
            'animal_code' => 'required|sometimes|string|max:191',
            'milk_quantity' => 'required',
            'milker_name' => 'required|string'
        ]);

        $otheranimalmilkingdetail->update($request->all());
        return (['message' => 'success']);        
    }

    public function destroy(Request $request,$id)
    {
        $otheranimalmilkingdetail = OtherAnimalMilkingDetail::findOrFail($id);

        $otheranimalmilkingdetail->delete();
        return (['message' => 'deleted']);
    }    
}
