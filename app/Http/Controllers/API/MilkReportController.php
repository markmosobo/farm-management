<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CowMilkingDetail;
use App\Models\OtherAnimalMilkingDetail;
use App\Models\Animal;
use App\Models\CowMilkSale;
use App\Models\OtherAnimalMilkSale;

class MilkReportController extends Controller
{
    public function litre(Request $request){
        $cowlitre = CowMilkingDetail::sum('milk_quantity');
        $milkanimallitre = OtherAnimalMilkingDetail::sum('milk_quantity');

        $litresproduced = $cowlitre + $milkanimallitre;
        return response()->json($litresproduced);
        
    }

    public function litresold(Request $request){
        $cowsoldlitre = CowMilkSale::sum('quantity_sold');
        $milkanimalsoldlitre = OtherAnimalMilkSale::sum('quantity_sold');

        $totallitressold = $cowsoldlitre + $milkanimalsoldlitre;
        return response()->json($totallitressold);        
    }  
    
    public function milksale(Request $request){
        $cowmilksale = CowMilkSale::sum('amount_got');
        $milkanimalmilksale = OtherAnimalMilkSale::sum('amount_got');

        $totalrevenue = $cowmilksale + $milkanimalmilksale;
        return response()->json($totalrevenue);        
    }    
    
    public function cowlitre(Request $request,$id){
        $cowname = CowMilkingDetail::findOrFail($id);
        $cowlitre = CowMilkingDetail::where('cow_name',$cowname->name)->sum('milk_quantity');

        $cowlitres = $cowlitre; 
        return response()->json($cowlitres);
        
    }

    public function cowsoldlitre(Request $request){
        $cowsoldlitre = CowMilkSale::sum('quantity_sold');

        $cowsoldlitres = $cowsoldlitre;
        return response()->json($cowsoldlitres);
    }

    public function cowmilksale(Request $request){
        $cowmilksale = CowMilkSale::sum('amount_got');

        $cowmilksales = $cowmilksale;
        return response()->json($cowmilksales);
    }
    
    public function milkanimallitre(Request $request,$id){
        $milkanimal = Animal::findOrFail($id);
        $milkanimallitre = OtherAnimalMilkingDetail::where('animal_id',$milkanimal->id)->sum('milk_quantity');

        $milkanimallitres = $milkanimallitre; 
        return response()->json($milkanimallitres);        
    }   
    
    public function milkanimalsoldlitre(Request $request,$id){
        $milkanimal = Animal::findOrFail($id);        
        $milkanimalsoldlitre = OtherAnimalMilkSale::where('animal_id',$milkanimal->id)->sum('quantity_sold');

        $milkanimalsoldlitres = $milkanimalsoldlitre;
        return response()->json($milkanimalsoldlitres);
    }

    public function milkanimalmilksale(Request $request,$id){
        $milkanimal = Animal::findOrFail($id);
        $milkanimalmilksale = OtherAnimalMilkSale::where('animal_id',$milkanimal->id)->sum('amount_got');

        $milkanimalmilksales = $milkanimalmilksale;
        return response()->json($milkanimalmilksales);
    }    
}
