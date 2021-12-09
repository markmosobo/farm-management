<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashWeedingDetail;

class CashWeedingDetailController extends Controller
{
    public function index(){
        return CashWeedingDetail::latest()->with('crop')->paginate(5);
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
        
        return CashWeedingDetail::create([
            'date_of_weeding' => $request->get('date_of_weeding'),
            'crop_id' => $request->get('crop_id'),
            'acreage_weeded' => $request->get('acreage_weeded'),
            'chemical_type' => $request->get('chemical_type'),
            'chemical_quantity' => $request->get('chemical_quantity'),
            'tools_used' => $request->get('tools_used')
        ]);
   }

   public function update(Request $request,$id){
        $cashweedingdetail = CashWeedingDetail::findOrFail($id);
        $this->validate($request,[
            'date_of_weeding' => 'required|date',
            'crop_id' => 'required|integer',
            'acreage_weeded' => 'required',
            'chemical_type' => 'required|string',
            'chemical_quantity' => 'sometimes|required',
            'tools_used' => 'sometimes|required'
        ]);

        $cashweedingdetail->update($request->all());

        return (['message' => 'success']);
    }

   public function destroy(Request $request,$id){
    $cashweedingdetail = CashWeedingDetail::findOrFail($id);

    $cashweedingdetail->delete();
    return (['message' => 'deleted']);
   }     
}
