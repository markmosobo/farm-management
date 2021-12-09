<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GradeProductOtherUse;

class GradeProductOtherUseController extends Controller
{
    public function index()
    {
        return GradeProductOtherUse::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'date_of_retrieval' => 'required|date',
            'quantity_used' => 'required'
        ]);

        return GradeProductOtherUse::create([
            'name' => $request->get('name'),
            'date_of_retrieval' => $request->get('date_of_retrieval'),
            'quantity_used' => $request->get('quantity_used')
        ]);
    }

    public function update(Request $request,$id)
    {
        $gradeproductotheruse = GradeProductOtherUse::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string',
            'date_of_retrieval' => 'required|date',
            'quantity_used' => 'required'
        ]);
        
        $gradeproductotheruse->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $gradeproductotheruse = GradeProductOtherUse::findOrFail($id);

        $gradeproductotheruse->delete();
        return (['message' => 'deleted']);
    }
}
