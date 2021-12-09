<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CowMilkingDetail;

class CowMilkingDetailController extends Controller
{
    public function index()
    {
        return CowMilkingDetail::latest()->paginate(5);
    }

    public function list(){
        return CowMilkingDetail::latest()->paginate(10);
    }
    

    public function store(Request $request)
    {
        $this->validate($request,[
            'date_of_milking' => 'required|date',
            'cow_name' => 'required|sometimes|string|max:191',
            'milk_quantity' => 'required',
            'milker_name' => 'required|string'
        ]);

        return CowMilkingDetail::create([
            'date_of_milking' => $request->get('date_of_milking'),
            'cow_name' => $request->get('cow_name'),
            'milk_quantity' => $request->get('milk_quantity'),
            'milker_name' => $request->get('milker_name')
        ]);

    }

    public function update(Request $request,$id)
    {
        $cowmilkingdetail = CowMilkingDetail::findOrFail($id);

        $this->validate($request,[
            'date_of_milking' => 'required|date',
            'cow_name' => 'required|sometimes|string|max:191',
            'milk_quantity' => 'required',
            'milker_name' => 'required|string'
        ]);

        $cowmilkingdetail->update($request->all());
        return (['message' => 'success']);        
    }

    public function destroy(Request $request,$id)
    {
        $cowmilkingdetail = CowMilkingDetail::findOrFail($id);

        $cowmilkingdetail->delete();
        return (['message' => 'deleted']);
    }    
}
