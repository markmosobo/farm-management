<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashPlantingDetail;

class CashPlantingDetailController extends Controller
{
    public function index(){
        return CashPlantingDetail::latest()->with('crop')->paginate(5);
   } 

   public function list(){

   }

   public function store(Request $request){
        $this->validate($request,[
            'date_of_planting' => 'required|date',
            'crop_id' => 'required|integer',
            'acreage_planted' => 'required',
            'fertilizer_type' => 'required|string',
            'fertilizer_quantity' => 'sometimes|required',
            'seed_quantity' => 'sometimes|required'
        ]);
        
        return CashPlantingDetail::create([
            'date_of_planting' => $request->get('date_of_planting'),
            'crop_id' => $request->get('crop_id'),
            'acreage_planted' => $request->get('acreage_planted'),
            'fertilizer_type' => $request->get('fertilizer_type'),
            'fertilizer_quantity' => $request->get('fertilizer_quantity'),
            'seed_quantity' => $request->get('seed_quantity')
        ]);
   }

   public function update(Request $request,$id){
        $cashplantingdetail = CashPlantingDetail::findOrFail($id);
        $this->validate($request,[
            'date_of_planting' => 'required|date',
            'crop_id' => 'required|integer',
            'acreage_planted' => 'required',
            'fertilizer_type' => 'required|string',
            'fertilizer_quantity' => 'sometimes|required',
            'seed_quantity' => 'sometimes|required'
        ]);

        $cashplantingdetail->update($request->all());

        return (['message' => 'success']);
    }

   public function destroy(Request $request,$id){
    $cashplantingdetail = CashPlantingDetail::findOrFail($id);

    $cashplantingdetail->delete();
    return (['message' => 'deleted']);
   }    
}
