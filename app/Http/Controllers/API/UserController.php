<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\FarmerResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list(){
        $userslist = User::all();
        return FarmerResource::collection($userslist);
    }

    public function index(){
        return User::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'role' => 'required|string',
            'bio' => 'sometimes',
            'password' => 'required'
        ]);

        return User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' => $request->get('role'),
            'bio' => $request->get('bio'),
            'password' => Hash::make($request['password'])
        ]);
    }

    public function update(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'role' => 'required|string',
            'bio' => 'sometimes',
            'password' => 'required'
        ]);
        
        $user->update($request->all());
        return (['message' => 'updated']);
    }

    public function destroy(Request $request,$id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        return (['message'=>'deleted']);
    }
}
