<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubPlantingDetail;

class SubPlantingDetailController extends Controller
{
   public function index(){
        return SubPlantingDetail::latest()->with('crop')->paginate(5);
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
        
        return SubPlantingDetail::create([
            'date_of_planting' => $request->get('date_of_planting'),
            'crop_id' => $request->get('crop_id'),
            'acreage_planted' => $request->get('acreage_planted'),
            'fertilizer_type' => $request->get('fertilizer_type'),
            'fertilizer_quantity' => $request->get('fertilizer_quantity'),
            'seed_quantity' => $request->get('seed_quantity')
        ]);
   }

   public function update(Request $request,$id){
        $subplantingdetail = SubPlantingDetail::findOrFail($id);
        $this->validate($request,[
            'date_of_planting' => 'required|date',
            'crop_id' => 'required|integer',
            'acreage_planted' => 'required',
            'fertilizer_type' => 'required|string',
            'fertilizer_quantity' => 'sometimes|required',
            'seed_quantity' => 'sometimes|required'
        ]);

        $subplantingdetail->update($request->all());

        return (['message' => 'success']);
    }

   public function destroy(Request $request,$id){
    $subplantingdetail = SubPlantingDetail::findOrFail($id);

    $subplantingdetail->delete();
    return (['message' => 'deleted']);
   }
}
