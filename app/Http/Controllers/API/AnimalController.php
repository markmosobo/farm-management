<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;

class AnimalController extends Controller
{
    public function index(){
        return Animal::latest()->with('owner')->paginate(5);
    }

    public function noofanimals(){
        return Animal::all()->count();
    } 

    public function list(){
        return Animal::latest()->where('type','=','domestic')->paginate(10);
    }

    public function listpet(){
        return Animal::latest()->where('type','=','pet')->paginate(10);
    }

    public function listanimal(){
        return Animal::latest()->paginate(10);
    }    

    public function listmilkanimal(){
        return Animal::latest()->where([
            [function ($query){
                $query->orWhere('name','LIKE','%'.'goat'.'%')->get();
                $query->orWhere('name','LIKE','%'.'sheep'.'%')->get();
                $query->orWhere('name','LIKE','%'.'camels'.'%')->get();
            }]
        ])->paginate(10);
    }
    
    public function store(Request $request){
        $this->validate($request,[
            'owner_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:191',
            'no_of_animals' => 'required|integer',
            'description' => 'sometimes'
        ]);

        return Animal::create([
            'owner_id' => $request->get('owner_id'),
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'no_of_animals' => $request->get('no_of_animals'),
            'description' => $request->get('description'),
        ]);
    }

    public function update(Request $request,$id){
        
        $animal = Animal::findOrFail($id);
        $this->validate($request,[
            'owner_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:191',
            'no_of_animals' => 'required|integer',            
            'description' => 'required|sometimes'
        ]);

        $animal->update($request->all());
    }

    public function destroy(Request $request,$id){
        $animal = Animal::findOrFail($id);

        $animal->delete();
        return (['message' => 'delete success']);
    }
}
