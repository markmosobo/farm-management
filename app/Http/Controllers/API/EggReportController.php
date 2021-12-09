<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poultry;
use App\Models\GradeLayingDetail;
use App\Models\KienyejiLayingDetail;
use App\Models\ImprovedKienyejiLayingDetail;
use App\Models\ExoticLayingDetail;
use App\Models\HybridLayingDetail;
use App\Models\GradeHatchingDetail;
use App\Models\KienyejiHatchingDetail;
use App\Models\ImprovedKienyejiHatchingDetail;
use App\Models\ExoticHatchingDetail;
use App\Models\HybridHatchingDetail;
use App\Models\GradeEggSale;
use App\Models\KienyejiEggSale;
use App\Models\ImprovedKienyejiEggSale;
use App\Models\ExoticEggSale;
use App\Models\HybridEggSale;

class EggReportController extends Controller
{
    public function numberlaid(Request $request){
        $gradeegg = GradeLayingDetail::sum('no_of_eggs');
        $kienyejiegg = KienyejiLayingDetail::sum('no_of_eggs');
        $improvedkienyejiegg = ImprovedKienyejiLayingDetail::sum('no_of_eggs');
        $exoticegg = ExoticLayingDetail::sum('no_of_eggs');
        $hybridegg = HybridLayingDetail::sum('no_of_eggs');

        $number = $gradeegg + $kienyejiegg + $improvedkienyejiegg + $exoticegg
                    + $hybridegg;
        $numberlaid = $number;
        return response()->json($numberlaid);            
    }

    public function numberhatched(Request $request){
        $gradeegg = GradeHatchingDetail::sum('no_of_eggs');
        $kienyejiegg = KienyejiHatchingDetail::sum('no_of_eggs');
        $improvedkienyejiegg = ImprovedKienyejiHatchingDetail::sum('no_of_eggs');
        $exoticegg = ExoticHatchingDetail::sum('no_of_eggs');
        $hybridegg = HybridHatchingDetail::sum('no_of_eggs');

        $number = $gradeegg + $kienyejiegg + $improvedkienyejiegg + $exoticegg
                    + $hybridegg;
        $numberhatched = $number;
        return response()->json($numberhatched );        
    } 
    
    public function numbersold(Request $request){
        $gradeeggsale = GradeEggSale::sum('no_sold');
        $kienyejieggsale = KienyejiEggSale::sum('no_sold');
        $improvedkienyejieggsale = ImprovedKienyejiEggSale::sum('no_sold');
        $exoticeggsale = ExoticEggSale::sum('no_sold');
        $hybrideggsale = HybridEggSale::sum('no_sold');

        $number = $gradeeggsale + $kienyejieggsale + $improvedkienyejieggsale + $exoticeggsale
                    + $hybrideggsale;
        $numbersold = $number;
        return response()->json($numbersold);        
    }

    public function eggsale(Request $request){
        $gradeeggsale = GradeEggSale::sum('amount_got');
        $kienyejieggsale = KienyejiEggSale::sum('amount_got');
        $improvedkienyejieggsale = ImprovedKienyejiEggSale::sum('amount_got');
        $exoticeggsale = ExoticEggSale::sum('amount_got');
        $hybrideggsale = HybridEggSale::sum('amount_got');

        $number = $gradeeggsale + $kienyejieggsale + $improvedkienyejieggsale + $exoticeggsale
                    + $hybrideggsale;
        $totalrevenue = $number;
        return response()->json($totalrevenue);
    }

    public function gradenumberlaid(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $gradeegg = GradeLayingDetail::where('poultry_id',$poultry->id)->sum('no_of_eggs');

        $number = $gradeegg;
        $numberlaid = $number;
        return response()->json($numberlaid);            
    }

    public function gradenumberhatched(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $gradeegg = GradeHatchingDetail::where('poultry_id',$poultry->id)->sum('no_of_eggs');

        $number = $gradeegg;
        $numberhatched = $number;
        return response()->json($numberhatched );        
    }

    public function kienyejinumberlaid(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $kienyejiegg = KienyejiLayingDetail::where('poultry_id',$poultry->id)->sum('no_of_eggs');

        $number = $kienyejiegg;
        $numberlaid = $number;
        return response()->json($numberlaid);            
    }

    public function kienyejinumberhatched(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $kienyejiegg = KienyejiHatchingDetail::where('poultry_id',$poultry->id)->sum('no_of_eggs');

        $number = $kienyejiegg;
        $numberhatched = $number;
        return response()->json($numberhatched );        
    }
    
    public function ikienyejinumberlaid(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $improvedkienyejiegg = ImprovedKienyejiLayingDetail::where('poultry_id',$poultry->id)->sum('no_of_eggs');

        $number = $improvedkienyejiegg;
        $numberlaid = $number;
        return response()->json($numberlaid);            
    }

    public function ikienyejinumberhatched(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $improvedkienyejiegg = ImprovedKienyejiHatchingDetail::where('poultry_id',$poultry->id)->sum('no_of_eggs');

        $number = $improvedkienyejiegg;
        $numberhatched = $number;
        return response()->json($numberhatched );        
    }
    
    public function exoticnumberlaid(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $exoticegg = ExoticLayingDetail::where('poultry_id',$poultry->id)->sum('no_of_eggs');

        $number = $exoticegg;
        $numberlaid = $number;
        return response()->json($numberlaid);            
    }

    public function exoticnumberhatched(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $exoticegg = ExoticHatchingDetail::where('poultry_id',$poultry->id)->sum('no_of_eggs');

        $number = $exoticegg;
        $numberhatched = $number;
        return response()->json($numberhatched );        
    }
    
    public function hybridnumberlaid(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $hybridegg = HybridLayingDetail::where('poultry_id',$poultry->id)->sum('no_of_eggs');

        $number = $hybridegg;
        $numberlaid = $number;
        return response()->json($numberlaid);            
    }

    public function hybridnumberhatched(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $hybridegg = HybridHatchingDetail::where('poultry_id',$poultry->id)->sum('no_of_eggs');

        $number = $hybridegg;
        $numberhatched = $number;
        return response()->json($numberhatched );        
    }    
}
