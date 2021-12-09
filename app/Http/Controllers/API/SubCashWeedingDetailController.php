<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCashWeedingDetail;

class SubCashWeedingDetailController extends Controller
{
    public function index(){
        return SubCashWeedingDetail::latest()->with('crop')->paginate(5);
   } 

   public function list(){

   }

   public function store(Request $request){
        $this->validate($request,[
            'date_of_weeding' => 'required|date',
            'crop_id' => 'required|integer',
            'acreage_weeded' => 'required',
            'chemical_type' => 'required|string',
            'chemical_quantity' => 'sometimes|required',
            'tools_used' => 'sometimes|required'
        ]);
        
        return SubCashWeedingDetail::create([
            'date_of_weeding' => $request->get('date_of_weeding'),
            'crop_id' => $request->get('crop_id'),
            'acreage_weeded' => $request->get('acreage_weeded'),
            'chemical_type' => $request->get('chemical_type'),
            'chemical_quantity' => $request->get('chemical_quantity'),
            'tools_used' => $request->get('tools_used')
        ]);
   }

   public function update(Request $request,$id){
        $subcashweedingdetail = SubCashWeedingDetail::findOrFail($id);
        $this->validate($request,[
            'date_of_weeding' => 'required|date',
            'crop_id' => 'required|integer',
            'acreage_weeded' => 'required',
            'chemical_type' => 'required|string',
            'chemical_quantity' => 'sometimes|required',
            'tools_used' => 'sometimes|required'
        ]);

        $subcashweedingdetail->update($request->all());

        return (['message' => 'success']);
    }

   public function destroy(Request $request,$id){
    $subcashweedingdetail = SubCashWeedingDetail::findOrFail($id);

    $subcashweedingdetail->delete();
    return (['message' => 'deleted']);
   }     
}
