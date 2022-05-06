<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubPreparingDetail;

class SubPreparingDetailController extends Controller
{
    public function index()
    {
        return SubPreparingDetail::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'crop_id' => 'sometimes',
            'date_of_preparing' => 'required|date',
            'activity' => 'required|string|min:9|max:255',
            'tools_used' => 'required|string',
            'acreage_prepared' => 'required'
        ]);

        return SubPreparingDetail::create([
            'crop_id' => $request->get('crop_id'),
            'date_of_preparing' => $request->get('date_of_preparing'),
            'activity' => $request->get('activity'),
            'tools_used' => $request->get('tools_used'),
            'acreage_prepared' => $request->get('acreage_prepared'),
        ]);
    }

    public function update(Request $request,$id)
    {
        $subpreparingdetail = SubPreparingDetail::findOrFail($id);
        $this->validate($request,[
            'crop_id' => 'sometimes|integer',
            'date_of_preparing' => 'required|date',
            'activity' => 'required|string|min:9|max:255',
            'tools_used' => 'required|string',
            'acreage_prepared' => 'required'
        ]);

        $subpreparingdetail->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $subpreparingdetail = SubPreparingDetail::findOrFail($id);

        $subpreparingdetail->delete();
        return (['message' => 'deleted']);
    }
}
