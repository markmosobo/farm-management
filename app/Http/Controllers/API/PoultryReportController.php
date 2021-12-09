<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poultry;
use App\Models\GradeFeedingDetail;
use App\Models\GradeFeedingCost;
use App\Models\GradeVaccineCost;
use App\Models\GradeVaccinatingDetail;
use App\Models\GradeDrugCost;
use App\Models\GradeTreatingDetail;
use App\Models\KienyejiFeedingCost;
use App\Models\KienyejiFeedingDetail;
use App\Models\KienyejiVaccineCost;
use App\Models\KienyejiVaccinatingDetail;
use App\Models\KienyejiDrugCost;
use App\Models\KienyejiTreatingDetail;
use App\Models\ImprovedKienyejiFeedingCost;
use App\Models\ImprovedKienyejiFeedingDetail;
use App\Models\ImprovedKienyejiVaccineCost;
use App\Models\ImprovedKienyejiVaccinatingDetail;
use App\Models\ImprovedKienyejiDrugCost;
use App\Models\ImprovedKienyejiTreatingDetail;
use App\Models\ExoticFeedingCost;
use App\Models\ExoticFeedingDetail;
use App\Models\ExoticVaccineCost;
use App\Models\ExoticVaccinatingDetail;
use App\Models\ExoticDrugCost;
use App\Models\ExoticTreatingDetail;
use App\Models\HybridFeedingCost;
use App\Models\HybridFeedingDetail;
use App\Models\HybridVaccineCost;
use App\Models\HybridVaccinatingDetail;
use App\Models\HybridDrugCost;
use App\Models\HybridTreatingDetail;
use App\Models\GradeFeedingOtherCost;
use App\Models\GradeTreatingOtherCost;
use App\Models\KienyejiFeedingOtherCost;
use App\Models\KienyejiTreatingOtherCost;
use App\Models\ImprovedKienyejiFeedingOtherCost;
use App\Models\ImprovedKienyejiTreatingOtherCost;
use App\Models\ExoticFeedingOtherCost;
use App\Models\ExoticTreatingOtherCost;
use App\Models\HybridFeedingOtherCost;
use App\Models\HybridTreatingOtherCost;
use App\Models\GradeEggSale;
use App\Models\GradePoultrySale;
use App\Models\KienyejiEggSale;
use App\Models\KienyejiPoultrySale;
use App\Models\ImprovedKienyejiEggSale;
use App\Models\ImprovedKienyejiPoultrySale;
use App\Models\ExoticEggSale;
use App\Models\ExoticPoultrySale;
use App\Models\HybridEggSale;
use App\Models\HybridPoultrySale;

class PoultryReportController extends Controller
{
    public function gradefeedingcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $gradefeedingcost = GradeFeedingCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $gradefeedingcosts = $gradefeedingcost;

        return response()->json($gradefeedingcosts);
    }

    public function gradetreatingcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $gradevaccinecost = GradeVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $gradedrugcost = GradeDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $gradetreatingcosts = $gradevaccinecost + $gradedrugcost;

        return response()->json($gradetreatingcosts);
    }

    public function gradetotalcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $gradevaccinecost = GradeVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $gradedrugcost = GradeDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $gradefeedingcost = GradeFeedingCost::where('poultry_id',$poultry->id)->sum('amount_paid');

        $gradetotalcosts = $gradevaccinecost + $gradedrugcost + $gradefeedingcost;

        return response()->json($gradetotalcosts);
    }

    public function kienyejifeedingcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $kienyejifeedingcost = KienyejiFeedingCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $kienyejifeedingcosts = $kienyejifeedingcost;

        return response()->json($kienyejifeedingcosts);
    }

    public function kienyejitreatingcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $kienyejivaccinecost = KienyejiVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $kienyejidrugcost = KienyejiDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $kienyejitreatingcosts = $kienyejivaccinecost + $kienyejidrugcost;

        return response()->json($kienyejitreatingcosts);
    }

    public function kienyejitotalcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $kienyejivaccinecost = KienyejiVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $kienyejidrugcost = KienyejiDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $kienyejifeedingcost = KienyejiFeedingCost::where('poultry_id',$poultry->id)->sum('amount_paid');

        $kienyejitotalcosts = $kienyejivaccinecost + $kienyejidrugcost + $kienyejifeedingcost;

        return response()->json($kienyejitotalcosts);
    }

    public function ikienyejifeedingcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $ikienyejifeedingcost = ImprovedKienyejiFeedingCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $ikienyejifeedingcosts = $ikienyejifeedingcost;

        return response()->json($ikienyejifeedingcosts);
    }

    public function ikienyejitreatingcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $ikienyejivaccinecost = ImprovedKienyejiVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $ikienyejidrugcost = ImprovedKienyejiDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $ikienyejitreatingcosts = $ikienyejivaccinecost + $ikienyejidrugcost;

        return response()->json($ikienyejitreatingcosts);
    }

    public function ikienyejitotalcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $ikienyejivaccinecost = ImprovedKienyejiVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $ikienyejidrugcost = ImprovedKienyejiDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $ikienyejifeedingcost = ImprovedKienyejiFeedingCost::where('poultry_id',$poultry->id)->sum('amount_paid');

        $ikienyejitotalcosts = $ikienyejivaccinecost + $ikienyejidrugcost + $ikienyejifeedingcost;

        return response()->json($ikienyejitotalcosts);
    }

    public function exoticfeedingcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $exoticfeedingcost = ExoticFeedingCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $exoticfeedingcosts = $exoticfeedingcost;

        return response()->json($exoticfeedingcosts);
    }

    public function exotictreatingcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $exoticvaccinecost = ExoticVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $exoticdrugcost = ExoticDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $exotictreatingcosts = $exoticvaccinecost + $exoticdrugcost;

        return response()->json($exotictreatingcosts);
    }

    public function exotictotalcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $exoticvaccinecost = ExoticVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $exoticdrugcost = ExoticDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $exoticfeedingcost = ExoticFeedingCost::where('poultry_id',$poultry->id)->sum('amount_paid');

        $exotictotalcosts = $exoticvaccinecost + $exoticdrugcost + $exoticfeedingcost;

        return response()->json($exotictotalcosts);
    }

    public function hybridfeedingcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $hybridfeedingcost = HybridFeedingCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $hybridfeedingcosts = $hybridfeedingcost;

        return response()->json($hybridfeedingcosts);
    }

    public function hybridtreatingcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $hybridvaccinecost = HybridVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $hybriddrugcost = HybridDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $hybridtreatingcosts = $hybridvaccinecost + $hybriddrugcost;

        return response()->json($hybridtreatingcosts);
    }

    public function hybridtotalcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
        $hybridvaccinecost = HybridVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $hybriddrugcost = HybridDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
        $hybridfeedingcost = HybridFeedingCost::where('poultry_id',$poultry->id)->sum('amount_paid');

        $hybridtotalcosts = $hybridvaccinecost + $hybriddrugcost + $hybridfeedingcost;

        return response()->json($hybridtotalcosts);
    }

    public function feedingcost(){
        $feedingcosts = GradeFeedingCost::sum('amount_paid') + GradeFeedingOtherCost::sum('amount_paid')
                        + KienyejiFeedingCost::sum('amount_paid') + KienyejiFeedingOtherCost::sum('amount_paid')
                        + ImprovedKienyejiFeedingCost::sum('amount_paid') + ImprovedKienyejiFeedingOtherCost::sum('amount_paid')
                        + ExoticFeedingCost::sum('amount_paid') + ExoticFeedingOtherCost::sum('amount_paid')
                        + HybridFeedingCost::sum('amount_paid') + HybridFeedingOtherCost::sum('amount_paid');

        return response()->json($feedingcosts);
    }

    public function feedcost(){
        $feedcosts = GradeFeedingCost::sum('amount_paid') + KienyejiFeedingCost::sum('amount_paid')
            + ImprovedKienyejiFeedingCost::sum('amount_paid')
            + ExoticFeedingCost::sum('amount_paid') + HybridFeedingCost::sum('amount_paid');

        return response()->json($feedcosts);
    }

    public function feedingmisccost(){
        $feedingmisccosts = GradeFeedingOtherCost::sum('amount_paid') + KienyejiFeedingOtherCost::sum('amount_paid')
            + ImprovedKienyejiFeedingOtherCost::sum('amount_paid')
            + ExoticFeedingOtherCost::sum('amount_paid') + HybridFeedingOtherCost::sum('amount_paid');

        return response()->json($feedingmisccosts);
    }

    public function treatingcost(){
        $treatingcosts = GradeVaccineCost::sum('amount_paid') + GradeDrugCost::sum('amount_paid') + GradeTreatingOtherCost::sum('amount_paid')
            + KienyejiVaccineCost::sum('amount_paid') + KienyejiDrugCost::sum('amount_paid') + KienyejiTreatingOtherCost::sum('amount_paid')
            + ImprovedKienyejiVaccineCost::sum('amount_paid') + ImprovedKienyejiDrugCost::sum('amount_paid') + ImprovedKienyejiTreatingOtherCost::sum('amount_paid')
            + ExoticVaccineCost::sum('amount_paid') + ExoticDrugCost::sum('amount_paid') + ExoticTreatingOtherCost::sum('amount_paid')
            + HybridVaccineCost::sum('amount_paid') + HybridDrugCost::sum('amount_paid') + HybridTreatingOtherCost::sum('amount_paid');

        return response()->json($treatingcosts);
    }

    public function gradevaccinecost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
            $vaccinecosts = GradeVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
    
            return response()->json($vaccinecosts);
        }
    
        public function gradedrugcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
            $drugcosts = GradeDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
    
            return response()->json($drugcosts);
        }
    
        public function kienyejivaccinecost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
            $vaccinecosts = KienyejiVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
    
            return response()->json($vaccinecosts);
        }
    
        public function kienyejidrugcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
            $drugcosts = KienyejiDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
    
            return response()->json($drugcosts);
        }
    
        public function ikienyejivaccinecost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
            $vaccinecosts = ImprovedKienyejiVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
    
            return response()->json($vaccinecosts);
        }
    
        public function ikienyejidrugcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
            $drugcosts = ImprovedKienyejiDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
    
            return response()->json($drugcosts);
        }
    
        public function exoticvaccinecost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
            $vaccinecosts = ExoticVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
    
            return response()->json($vaccinecosts);
        }
    
        public function exoticdrugcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
            $drugcosts = ExoticDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
    
            return response()->json($drugcosts);
        }
    
        public function hybridvaccinecost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
            $vaccinecosts = HybridVaccineCost::where('poultry_id',$poultry->id)->sum('amount_paid');
    
            return response()->json($vaccinecosts);
        }
    
        public function hybriddrugcost(Request $request,$id){
        $poultry = Poultry::findOrFail($id);
            $drugcosts = HybridDrugCost::where('poultry_id',$poultry->id)->sum('amount_paid');
    
            return response()->json($drugcosts);
        }    

    public function vaccinecost(){
        $vaccinecosts = GradeVaccineCost::sum('amount_paid') + KienyejiVaccineCost::sum('amount_paid')
            + ImprovedKienyejiVaccineCost::sum('amount_paid')
            + ExoticVaccineCost::sum('amount_paid') + HybridVaccineCost::sum('amount_paid');

        return response()->json($vaccinecosts);
    }

    public function drugcost(){
        $drugcosts = GradeDrugCost::sum('amount_paid') + KienyejiDrugCost::sum('amount_paid')
            + ImprovedKienyejiDrugCost::sum('amount_paid')
            + ExoticDrugCost::sum('amount_paid') + HybridDrugCost::sum('amount_paid');

        return response()->json($drugcosts);
    }

    public function treatingmisccost(){
        $treatingmisccosts = GradeTreatingOtherCost::sum('amount_paid') + KienyejiTreatingOtherCost::sum('amount_paid')
            + ImprovedKienyejiTreatingOtherCost::sum('amount_paid')
            + ExoticTreatingOtherCost::sum('amount_paid') + HybridTreatingOtherCost::sum('amount_paid');

        return response()->json($treatingmisccosts);
    }

    public function gradepoultrysale(Request $request,$id)
    {
        $poultry = Poultry::findOrFail($id);
        $gradepoultrysales = GradePoultrySale::where('poultry_id',$poultry->id)->sum('amount_got');
        
        return response()->json($gradepoultrysales);
    } 
    
    public function kienyejipoultrysale(Request $request,$id)
    {
        $poultry = Poultry::findOrFail($id);
        $kienyejipoultrysales = KienyejiPoultrySale::where('poultry_id',$poultry->id)->sum('amount_got');
        
        return response()->json($kienyejipoultrysales);
    }

    public function ikienyejipoultrysale(Request $request,$id)
    {
        $poultry = Poultry::findOrFail($id);
        $ikienyejipoultrysales = ImprovedKienyejiPoultrySale::where('poultry_id',$poultry->id)->sum('amount_got');
        
        return response()->json($ikienyejipoultrysales);
    } 

    public function exoticpoultrysale(Request $request,$id)
    {
        $poultry = Poultry::findOrFail($id);
        $exoticpoultrysales = ExoticPoultrySale::where('poultry_id',$poultry->id)->sum('amount_got');
        
        return response()->json($exoticpoultrysales);
    }

    public function hybridpoultrysale(Request $request,$id)
    {
        $poultry = Poultry::findOrFail($id);
        $hybridpoultrysales = HybridPoultrySale::where('poultry_id',$poultry->id)->sum('amount_got');
        
        return response()->json($hybridpoultrysales);
    }    

    public function poultrycost(){
        $gradefeedingcost = GradeFeedingCost::sum('amount_paid');
        $gradefeedingothercost = GradeFeedingOtherCost::sum('amount_paid');
        $gradevaccinecost = GradeVaccineCost::sum('amount_paid');
        $gradedrugcost = GradeDrugCost::sum('amount_paid');
        $gradetreatingothercost = GradeTreatingOtherCost::sum('amount_paid');
        $kienyejifeedingcost = KienyejiFeedingCost::sum('amount_paid');
        $kienyejifeedingothercost = KienyejiFeedingOtherCost::sum('amount_paid');
        $kienyejivaccinecost = KienyejiVaccineCost::sum('amount_paid');
        $kienyejidrugcost = KienyejiDrugCost::sum('amount_paid');
        $kienyejitreatingothercost = KienyejiTreatingOtherCost::sum('amount_paid');
        $ikienyejifeedingcost = ImprovedKienyejiFeedingCost::sum('amount_paid');
        $ikienyejifeedingothercost = ImprovedKienyejiFeedingOtherCost::sum('amount_paid');
        $ikienyejivaccinecost = ImprovedKienyejiVaccineCost::sum('amount_paid');
        $ikienyejidrugcost = ImprovedKienyejiDrugCost::sum('amount_paid');
        $ikienyejitreatingothercost = ImprovedKienyejiTreatingOtherCost::sum('amount_paid');
        $exoticfeedingcost = ExoticFeedingCost::sum('amount_paid');
        $exoticfeedingothercost = ExoticFeedingOtherCost::sum('amount_paid');
        $exoticvaccinecost = ExoticVaccineCost::sum('amount_paid');
        $exoticdrugcost = ExoticDrugCost::sum('amount_paid');
        $exotictreatingothercost = ExoticTreatingOtherCost::sum('amount_paid');
        $hybridfeedingcost = HybridFeedingCost::sum('amount_paid');
        $hybridfeedingothercost = HybridFeedingOtherCost::sum('amount_paid');
        $hybridvaccinecost = HybridVaccineCost::sum('amount_paid');
        $hybriddrugcost = HybridDrugCost::sum('amount_paid');
        $hybridtreatingothercost = HybridTreatingOtherCost::sum('amount_paid');

        $totalcosts = $gradefeedingcost + $gradefeedingothercost + $gradevaccinecost + $gradedrugcost
                      + $gradetreatingothercost +  $kienyejifeedingcost + $kienyejifeedingothercost + $kienyejivaccinecost + $kienyejidrugcost
                      + $kienyejitreatingothercost +  $ikienyejifeedingcost + $ikienyejifeedingothercost + $ikienyejivaccinecost + $ikienyejidrugcost
                      + $ikienyejitreatingothercost +  $exoticfeedingcost + $exoticfeedingothercost + $exoticvaccinecost + $exoticdrugcost
                      + $exotictreatingothercost +  $hybridfeedingcost + $hybridfeedingothercost + $hybridvaccinecost + $hybriddrugcost
                      + $hybridtreatingothercost;
        return response()->json($totalcosts);

    }

    public function poultryfed()
    {
        $poultryfed = GradeFeedingDetail::sum('no_of_poultries') + KienyejiFeedingDetail::sum('no_of_poultries')
                      + ImprovedKienyejiFeedingDetail::sum('no_of_poultries') + ExoticFeedingDetail::sum('no_of_poultries')
                      + HybridFeedingDetail::sum('no_of_poultries');
        return response()->json($poultryfed);                
    }

    public function poultryvaccinated()
    {
        $poultryvaccinated = GradeVaccinatingDetail::sum('no_of_poultries') + KienyejiVaccinatingDetail::sum('no_of_poultries')
                      + ImprovedKienyejiVaccinatingDetail::sum('no_of_poultries') + ExoticVaccinatingDetail::sum('no_of_poultries')
                      + HybridVaccinatingDetail::sum('no_of_poultries');
        return response()->json($poultryvaccinated); 
    }

    public function poultrytreated()
    {
        $poultrytreated = GradeTreatingDetail::sum('no_of_poultries') + KienyejiTreatingDetail::sum('no_of_poultries')
                      + ImprovedKienyejiTreatingDetail::sum('no_of_poultries') + ExoticTreatingDetail::sum('no_of_poultries')
                      + HybridTreatingDetail::sum('no_of_poultries');
        return response()->json($poultrytreated); 
    }

    public function prevvaccine()
    {
        $prevvaccine = GradeVaccinatingDetail::select('vaccine_type')
        ->groupBy('vaccine_type')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(1)
        ->get();

        return response()->json($prevvaccine);
    }

    public function prevdrug()
    {

    }

    public function poultrysale(){
        $gradepoultrysale = GradePoultrySale::sum('amount_got');
        $gradeeggsale = GradeEggSale::sum('amount_got');
        $kienyejipoultrysale = KienyejiPoultrySale::sum('amount_got');
        $kienyejieggsale = KienyejiEggSale::sum('amount_got');
        $ikienyejipoultrysale = ImprovedKienyejiPoultrySale::sum('amount_got');
        $ikienyejieggsale = ImprovedKienyejiEggSale::sum('amount_got');
        $exoticpoultrysale = ExoticPoultrySale::sum('amount_got');
        $exoticeggsale = ExoticEggSale::sum('amount_got');
        $hybridpoultrysale = HybridPoultrySale::sum('amount_got');
        $hybrideggsale = HybridEggSale::sum('amount_got');

        $totalsales = $gradepoultrysale + $gradeeggsale + $kienyejipoultrysale + $kienyejieggsale
                      + $ikienyejipoultrysale + $ikienyejieggsale + $exoticpoultrysale + $exoticeggsale
                      + $hybridpoultrysale + $hybrideggsale;
        return response()->json($totalsales);
    }
}
