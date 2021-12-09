<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resource;

class ResourceController extends Controller
{
    public function index()
    {
        return Resource::latest()->with('owner')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'owner_id' => 'required|integer',
            'name' => 'required|string|max:255'
        ]);

        return Resource::create([
            'owner_id' => $request->get('owner_id'),
            'name' => $request->get('name')
        ]);
    }

    public function update(Request $request,$id)
    {
        $resource = Resource::findOrFail($id);

        $this->validate($request,[
            'owner_id' => 'required|integer',
            'name' => 'required|string|max:255'
        ]);
        
        $resource->update($request->all());
    }

    public function destroy(Request $request,$id)
    {
        $resource = Resource::findOrFail($id);

        $resource->delete();
        return (['message' => 'deleted']);
    }
}
