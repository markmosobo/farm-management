<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farm;
use App\Http\Resources\FarmResource;

class FarmController extends Controller
{
   public function index(){
       return Farm::latest()->with('owner')->paginate(5);
   }   

    public function list(){
        $farmslist = Farm::all();
        return FarmResource::collection($farmslist);
    }

    public function store(Request $request){
        $this->validate($request,[
            'owner_id' => 'required|integer',
            'acreage' => 'required'
        ]);

        return Farm::create([
            'owner_id' =>$request->get('owner_id'),
            'acreage' => $request->get('acreage')
        ]);
    }

    public function update(Request $request,$id){
        $farm = Farm::findOrFail($id);

        $this->validate($request,[
            'owner_id' => 'required|integer',
            'acreage' => 'required'            
        ]);

        $farm->update($request->all());
        return (['message' => 'update success']);
    }

    public function destroy(Request $request,$id){
        $farm = Farm::findOrFail($id);

        $farm->delete();

        return (['message' => 'delete success']);
    }
}
