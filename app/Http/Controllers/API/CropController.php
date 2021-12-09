<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crop;

class CropController extends Controller
{
    public function index(){
        return Crop::latest()->with('owner')->paginate(5);
    }

    public function list(){
        return Crop::latest()->with('owner')->where('type','=','subsistence')->paginate(10);
    }

    public function listcash(){
        return Crop::latest()->with('owner')->where('type','=','cashcrop')->paginate(10);
    }
    
    public function listsubcash(){
        return Crop::latest()->with('owner')->where('type','=','subcashcrop')->paginate(10);
    }

    public function noofcrops(){
        return Crop::all()->count();
    }    

    public function store(Request $request){
        $this->validate($request,[
            'owner_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:191',
            'description' => 'required|sometimes'
        ]);

        return Crop::create([
            'owner_id' => $request->get('owner_id'),
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'description' => $request->get('description')
        ]);
    }

    public function update(Request $request,$id){
        $crop = Crop::findOrFail($id);
        $crop->update($request->all());
        return (['message' => 'update success']);
    }

    public function destroy(Request $request,$id){
        $crop = Crop::findOrFail($id);

        $crop->delete();
        return (['message'=> 'delete success']);
    }
}
