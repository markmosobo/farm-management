<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImprovedKienyejiFeedingDetail;

class ImprovedKienyejiFeedingDetailController extends Controller
{
    public function index()
    {
        return ImprovedKienyejiFeedingDetail::latest()->with('poultry')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'poultry_id' => 'required|integer',
            'date_of_feeding' => 'required|date',
            'feed_type' => 'required|string|max:191',
            'feed_quantity' => 'required|string|max:255',
            'no_of_poultries' => 'required|integer'
        ]);

        return ImprovedKienyejiFeedingDetail::create([
            'poultry_id' => $request->get('poultry_id'),
            'date_of_feeding' => $request->get('date_of_feeding'),
            'feed_type' => $request->get('feed_type'),
            'feed_quantity' => $request->get('feed_quantity'),
            'no_of_poultries' => $request->get('no_of_poultries')            
        ]);
    }

    public function update(Request $request,$id)
    {
        $improvedkienyejifeedingdetail = ImprovedKienyejiFeedingDetail::findOrFail($id);

        $this->validate($request,[
            'poultry_id' => 'required|integer',
            'date_of_feeding' => 'required|date',
            'feed_type' => 'required|string|max:191',
            'feed_quantity' => 'required|string|max:255',
            'no_of_poultries' => 'required|integer'
        ]);
        
        $improvedkienyejifeedingdetail->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $improvedkienyejifeedingdetail = ImprovedKienyejiFeedingDetail::findOrFail($id);

        $improvedkienyejifeedingdetail->delete();
        return (['messsage' => 'deleted']);
    }    
}
