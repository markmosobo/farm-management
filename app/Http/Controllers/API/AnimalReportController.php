<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\DomesticFeedingCost;
use App\Models\DomesticVaccineCost;
use App\Models\DomesticDrugCost;
use App\Models\DomesticFeedingOtherCost;
use App\Models\DomesticTreatingOtherCost;
use App\Models\PetFeedingCost;
use App\Models\PetVaccineCost;
use App\Models\PetDrugCost;
use App\Models\PetFeedingOtherCost;
use App\Models\PetTreatingOtherCost;
use App\Models\AnimalSale;
class AnimalReportController extends Controller
{
    public function domesticfeedingcost(Request $request,$id){
        $animal = Animal::findOrFail($id);
        $domesticfeedingcost = DomesticFeedingCost::where('animal_id',$animal->id)->sum('amount_paid');

        $domesticfeedingcosts = $domesticfeedingcost;
        return response()->json($domesticfeedingcosts);                      
    }

    public function domestictreatingcost(Request $request,$id){
        $animal = Animal::findOrFail($id);
        $domesticvaccinecost = DomesticVaccineCost::where('animal_id',$animal->id)->sum('amount_paid');
        $domesticdrugcost = DomesticDrugCost::where('animal_id',$animal->id)->sum('amount_paid');
 
        $domestictreatingcosts = $domesticvaccinecost + $domesticdrugcost;
        return response()->json($domestictreatingcosts);    
    }

    public function domesticcost(Request $request,$id){
        $animal = Animal::findOrFail($id);
        $domesticfeedingcost = DomesticFeedingCost::where('animal_id',$animal->id)->sum('amount_paid');        
        $domesticvaccinecost = DomesticVaccineCost::where('animal_id',$animal->id)->sum('amount_paid');
        $domesticdrugcost = DomesticDrugCost::where('animal_id',$animal->id)->sum('amount_paid');
 
        $domestictotalcosts = $domesticfeedingcost + $domesticvaccinecost + $domesticdrugcost;
        return response()->json($domestictotalcosts);
    }

    public function petfeedingcost(Request $request,$id){
        $animal = Animal::findOrFail($id);
        $petfeedingcost = PetFeedingCost::where('animal_id',$animal->id)->sum('amount_paid');

        $petfeedingcosts = $petfeedingcost;
        return response()->json($petfeedingcosts);                      
    }

    public function pettreatingcost(Request $request,$id){
        $animal = Animal::findOrFail($id);
        $petvaccinecost = PetVaccineCost::where('animal_id',$animal->id)->sum('amount_paid');
        $petdrugcost = PetDrugCost::where('animal_id',$animal->id)->sum('amount_paid');
 
        $pettreatingcosts = $petvaccinecost + $petdrugcost;
        return response()->json($pettreatingcosts);    
    }

    public function petcost(Request $request,$id){
        $animal = Animal::findOrFail($id);
        $petfeedingcost = PetFeedingCost::where('animal_id',$animal->id)->sum('amount_paid');        
        $petvaccinecost = PetVaccineCost::where('animal_id',$animal->id)->sum('amount_paid');
        $petdrugcost = PetDrugCost::where('animal_id',$animal->id)->sum('amount_paid');
 
        $pettotalcosts = $petfeedingcost + $petvaccinecost + $petdrugcost;
        return response()->json($pettotalcosts);
    }    
    
    public function animalcost(Request $request){
        $domesticfeedingcost = DomesticFeedingCost::sum('amount_paid');
        $domesticfeedingothercost = DomesticFeedingOtherCost::sum('amount_paid');
        $domesticvaccinecost = DomesticVaccineCost::sum('amount_paid');
        $domesticdrugcost = DomesticDrugCost::sum('amount_paid');
        $domesticothertreatingcost = DomesticTreatingOtherCost::sum('amount_paid');

        $petfeedingcost = PetFeedingCost::sum('amount_paid');
        $petfeedingothercost = PetFeedingOtherCost::sum('amount_paid');
        $petvaccinecost = PetVaccineCost::sum('amount_paid');
        $petdrugcost = PetDrugCost::sum('amount_paid');
        $petothertreatingcost = PetTreatingOtherCost::sum('amount_paid');
        
        $totalcosts = $domesticfeedingcost + $domesticfeedingothercost + $domesticvaccinecost 
                      + $domesticdrugcost + $domesticothertreatingcost + $petfeedingcost +
                      $petfeedingothercost + $petvaccinecost + $petdrugcost + $petothertreatingcost;
        return response()->json($totalcosts);               
    }

    public function animalsale(Request $request){
        $sales = AnimalSale::sum('amount_got');

        $totalrevenue = $sales;
        return response()->json($totalrevenue);
    }
}
