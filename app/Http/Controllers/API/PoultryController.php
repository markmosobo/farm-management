<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poultry;

class PoultryController extends Controller
{
    public function index(){
        return Poultry::latest()->with('owner')->paginate(5);
    }

    public function list(){
        return Poultry::latest()->with('owner')->where('type','=','grade')->paginate(10);
    }

    public function listkienyeji(){
        return Poultry::latest()->with('owner')->where('type','=','kienyeji')->paginate(10);
    }
    
    public function listimprovedkienyeji(){
        return Poultry::latest()->with('owner')->where('type','=','improved kienyeji')->paginate(10);
    }    

    public function listexotic(){
        return Poultry::latest()->with('owner')->where('type','=','exotic')->paginate(10);
    } 

    public function listhybrid(){
        return Poultry::latest()->with('owner')->where('type','=','hybrid')->paginate(10);
    } 

    public function store(Request $request){
        $this->validate($request,[
            'owner_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'no_of_poultries' => 'required|integer',
            'type' => 'required|string|max:191',
        ]);

        return Poultry::create([
            'owner_id' => $request->get('owner_id'),
            'name' => $request->get('name'),
            'no_of_poultries' => $request->get('no_of_poultries'),
            'type' => $request->get('type'),
        ]);
    }

    public function update(Request $request,$id){
        $poultry = Poultry::findOrFail($id);

        $this->validate($request,[
            'owner_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'no_of_poultries' => 'required|integer',            
            'type' => 'required|string|max:191',
        ]);

        $poultry->update($request->all());

        return (['message' => 'update success']);
    }

    public function destroy(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $poultry->delete();
        return (['message' => 'delete success']);
    }
}
