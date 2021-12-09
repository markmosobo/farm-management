<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetFeedingDetail;

class PetFeedingDetailController extends Controller
{
    public function index()
    {
        return PetFeedingDetail::latest()->with('animal')->paginate(5);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'animal_id' => 'required|integer',
            'date_of_feeding' => 'required|date',
            'feed_type' => 'required|string|max:191',
            'feed_quantity' => 'required|string|max:255',
            'no_of_animals' => 'required|integer'
        ]);

        return PetFeedingDetail::create([
            'animal_id' => $request->get('animal_id'),
            'date_of_feeding' => $request->get('date_of_feeding'),
            'feed_type' => $request->get('feed_type'),
            'feed_quantity' => $request->get('feed_quantity'),
            'no_of_animals' => $request->get('no_of_animals')            
        ]);
    }

    public function update(Request $request,$id)
    {
        $petfeedingdetail = PetFeedingDetail::findOrFail($id);

        $this->validate($request,[
            'animal_id' => 'required|integer',
            'date_of_feeding' => 'required|date',
            'feed_type' => 'required|string|max:191',
            'feed_quantity' => 'required|string|max:255',
            'no_of_animals' => 'required|integer'
        ]);
        
        $petfeedingdetail->update($request->all());
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $petfeedingdetail = PetFeedingDetail::findOrFail($id);

        $petfeedingdetail->delete();
        return (['messsage' => 'deleted']);
    }    
}
