<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubPlantingFertilizerCost;
use App\Models\SubPlantingSeedCost;
use App\Models\SubPlantingLabourCost;
use App\Models\SubPlantingOtherCost;
use App\Models\CashPlantingFertilizerCost;
use App\Models\CashPlantingSeedCost;
use App\Models\CashPlantingLabourCost;
use App\Models\CashPlantingOtherCost;
use App\Models\SubCashPlantingFertilizerCost;
use App\Models\SubCashPlantingSeedCost;
use App\Models\SubCashPlantingLabourCost;
use App\Models\SubCashPlantingOtherCost;
use App\Models\SubWeedingChemicalCost;
use App\Models\SubWeedingToolCost;
use App\Models\SubWeedingLabourCost;
use App\Models\SubWeedingOtherCost;
use App\Models\CashWeedingChemicalCost;
use App\Models\CashWeedingToolCost;
use App\Models\CashWeedingLabourCost;
use App\Models\CashWeedingOtherCost;
use App\Models\SubCashWeedingChemicalCost;
use App\Models\SubCashWeedingToolCost;
use App\Models\SubCashWeedingLabourCost;
use App\Models\SubCashWeedingOtherCost;
use App\Models\SubHarvestingTransportCost;
use App\Models\SubHarvestingLabourCost;
use App\Models\SubHarvestingOtherCost;
use App\Models\CashHarvestingTransportCost;
use App\Models\CashHarvestingLabourCost;
use App\Models\CashHarvestingOtherCost;
use App\Models\SubCashHarvestingTransportCost;
use App\Models\SubCashHarvestingLabourCost;
use App\Models\SubCashHarvestingOtherCost;
use App\Models\DomesticFeedingCost;
use App\Models\DomesticFeedingOtherCost;
use App\Models\PetFeedingCost;
use App\Models\PetFeedingOtherCost;
use App\Models\DomesticVaccineCost;
use App\Models\DomesticDrugCost;
use App\Models\DomesticTreatingOtherCost;
use App\Models\PetVaccineCost;
use App\Models\PetDrugCost;
use App\Models\PetTreatingOtherCost;
use App\Models\GradeFeedingCost;
use App\Models\GradeFeedingOtherCost;
use App\Models\KienyejiFeedingCost;
use App\Models\KienyejiFeedingOtherCost;
use App\Models\ImprovedKienyejiFeedingCost;
use App\Models\ImprovedKienyejiFeedingOtherCost;
use App\Models\ExoticFeedingCost;
use App\Models\ExoticFeedingOtherCost;
use App\Models\HybridFeedingCost;
use App\Models\HybridFeedingOtherCost;
use App\Models\GradeVaccineCost;
use App\Models\GradeDrugCost;
use App\Models\GradeTreatingOtherCost;
use App\Models\KienyejiVaccineCost;
use App\Models\KienyejiDrugCost;
use App\Models\KienyejiTreatingOtherCost;
use App\Models\ImprovedKienyejiVaccineCost;
use App\Models\ImprovedKienyejiDrugCost;
use App\Models\ImprovedKienyejiTreatingOtherCost;
use App\Models\ExoticVaccineCost;
use App\Models\ExoticDrugCost;
use App\Models\ExoticTreatingOtherCost;
use App\Models\HybridVaccineCost;
use App\Models\HybridDrugCost;
use App\Models\HybridTreatingOtherCost;
use App\Models\ResourcePurchase;
use App\Models\CowMilkSale;
use App\Models\OtherAnimalMilkSale;
use App\Models\AnimalSale;
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
use App\Models\PoultrySale;
use App\Models\ResourceSale;
use App\Models\CropSale;
use App\Models\SubCashCropSale;

class OverallReportController extends Controller
{
    public function allcost(){
        $allcosts = SubPlantingFertilizerCost::sum('amount_paid') + SubPlantingSeedCost::sum('amount_paid') +
         SubPlantingLabourCost::sum('amount_paid') + SubPlantingOtherCost::sum('amount_paid') +
         CashPlantingFertilizerCost::sum('amount_paid') + CashPlantingSeedCost::sum('amount_paid') +
         CashPlantingLabourCost::sum('amount_paid') + CashPlantingOtherCost::sum('amount_paid') +
         SubCashPlantingFertilizerCost::sum('amount_paid') + SubCashPlantingSeedCost::sum('amount_paid') +
         SubCashPlantingLabourCost::sum('amount_paid') + SubCashPlantingOtherCost::sum('amount_paid') +
         SubWeedingChemicalCost::sum('amount_paid') + SubWeedingToolCost::sum('amount_paid') +
         SubWeedingLabourCost::sum('amount_paid') + SubWeedingOtherCost::sum('amount_paid') +
         CashWeedingChemicalCost::sum('amount_paid') + CashWeedingToolCost::sum('amount_paid') +
         CashWeedingLabourCost::sum('amount_paid') + CashWeedingOtherCost::sum('amount_paid') +
         SubCashWeedingChemicalCost::sum('amount_paid') + SubCashWeedingToolCost::sum('amount_paid') +
         SubCashWeedingLabourCost::sum('amount_paid') + SubCashWeedingOtherCost::sum('amount_paid') +
         SubHarvestingTransportCost::sum('amount_paid') + SubHarvestingLabourCost::sum('amount_paid') +
         SubHarvestingOtherCost::sum('amount_paid') + CashHarvestingTransportCost::sum('amount_paid') + CashHarvestingLabourCost::sum('amount_paid') +
         CashHarvestingOtherCost::sum('amount_paid') + SubCashHarvestingTransportCost::sum('amount_paid') + SubCashHarvestingLabourCost::sum('amount_paid') +
         SubCashHarvestingOtherCost::sum('amount_paid') + DomesticFeedingCost::sum('amount_paid') + DomesticFeedingOtherCost::sum('amount_paid') +
         PetFeedingCost::sum('amount_paid') + PetFeedingOtherCost::sum('amount_paid') + DomesticVaccineCost::sum('amount_paid') + 
         DomesticDrugCost::sum('amount_paid') + DomesticTreatingOtherCost::sum('amount_paid') + PetVaccineCost::sum('amount_paid') + 
         PetDrugCost::sum('amount_paid') + PetTreatingOtherCost::sum('amount_paid') + GradeFeedingCost::sum('amount_paid') +
         GradeFeedingOtherCost::sum('amount_paid') +  KienyejiFeedingCost::sum('amount_paid') + KienyejiFeedingOtherCost::sum('amount_paid') +
         ImprovedKienyejiFeedingCost::sum('amount_paid') + ImprovedKienyejiFeedingOtherCost::sum('amount_paid') +
         ExoticFeedingCost::sum('amount_paid') + ExoticFeedingOtherCost::sum('amount_paid') +
         HybridFeedingCost::sum('amount_paid') + HybridFeedingOtherCost::sum('amount_paid') + GradeVaccineCost::sum('amount_paid') +
         GradeDrugCost::sum('amount_paid') + GradeTreatingOtherCost::sum('amount_paid') + KienyejiVaccineCost::sum('amount_paid') +
         KienyejiDrugCost::sum('amount_paid') + KienyejiTreatingOtherCost::sum('amount_paid') + ImprovedKienyejiVaccineCost::sum('amount_paid') +
         ImprovedKienyejiDrugCost::sum('amount_paid') + ImprovedKienyejiTreatingOtherCost::sum('amount_paid') + ExoticVaccineCost::sum('amount_paid') +
         ExoticDrugCost::sum('amount_paid') + ExoticTreatingOtherCost::sum('amount_paid') + HybridVaccineCost::sum('amount_paid') +
         HybridDrugCost::sum('amount_paid') + HybridTreatingOtherCost::sum('amount_paid') + ResourcePurchase::sum('amount_paid');

         return response()->json($allcosts);         
    }

    public function allsale(){
        $allsales = CowMilkSale::sum('amount_got') + OtherAnimalMilkSale::sum('amount_got') + AnimalSale::sum('amount_got')
                    + GradeEggSale::sum('amount_got') + KienyejiEggSale::sum('amount_got') + ImprovedKienyejiEggSale::sum('amount_got')
                    + ExoticEggSale::sum('amount_got') + HybridEggSale::sum('amount_got') + GradePoultrySale::sum('amount_got')
                    + KienyejiPoultrySale::sum('amount_got') + ImprovedKienyejiPoultrySale::sum('amount_got')
                    + ExoticPoultrySale::sum('amount_got') + HybridPoultrySale::sum('amount_got') + ResourceSale::sum('amount_paid')
                    + CropSale::sum('amount_due') + SubCashCropSale::sum('amount_due');
                
        return response()->json($allsales);            
    }

    public function allproduce()
    {

    }

    public function cropcost (Request $request)
    {
        $subplantingfertilizercost = SubPlantingFertilizerCost::sum('amount_paid');
        $subplantingseedcost = SubPlantingSeedCost::sum('amount_paid');
        $subplantinglabourcost = SubPlantingLabourCost::sum('amount_paid');
        $subweedingchemicalcost = SubWeedingChemicalCost::sum('amount_paid');
        $subweedinglabourcost = SubWeedingLabourCost::sum('amount_paid');
        $subweedingtoolcost = SubWeedingToolCost::sum('amount_paid');
        $subharvestingtransportcost = SubHarvestingTransportCost::sum('amount_paid');
        $subharvestinglabourcost = SubHarvestingLabourCost::sum('amount_paid');

        $cashplantingfertilizercost = CashPlantingFertilizerCost::sum('amount_paid');
        $cashplantingseedcost = CashPlantingSeedCost::sum('amount_paid');
        $cashplantinglabourcost = CashPlantingLabourCost::sum('amount_paid');
        $cashweedingchemicalcost = CashWeedingChemicalCost::sum('amount_paid');
        $cashweedinglabourcost = CashWeedingLabourCost::sum('amount_paid');
        $cashweedingtoolcost = CashWeedingToolCost::sum('amount_paid');
        $cashharvestingtransportcost = CashHarvestingTransportCost::sum('amount_paid');
        $cashharvestinglabourcost = CashHarvestingLabourCost::sum('amount_paid');

        $subcashplantingfertilizercost = SubCashPlantingFertilizerCost::sum('amount_paid');
        $subcashplantingseedcost = SubCashPlantingSeedCost::sum('amount_paid');
        $subcashplantinglabourcost = SubCashPlantingLabourCost::sum('amount_paid');
        $subcashweedingchemicalcost = SubCashWeedingChemicalCost::sum('amount_paid');
        $subcashweedinglabourcost = SubCashWeedingLabourCost::sum('amount_paid');
        $subcashweedingtoolcost = SubCashWeedingToolCost::sum('amount_paid');
        $subcashharvestingtransportcost = SubCashHarvestingTransportCost::sum('amount_paid');
        $subcashharvestinglabourcost = SubCashHarvestingLabourCost::sum('amount_paid');

        $totalcosts = $subplantingfertilizercost + $subplantingseedcost + $subplantinglabourcost +
     $subweedingchemicalcost + $subweedinglabourcost + $subweedingtoolcost + $subharvestingtransportcost
     + $subharvestinglabourcost + $cashplantingfertilizercost + $cashplantingseedcost + $cashplantinglabourcost +
     $cashweedingchemicalcost + $cashweedinglabourcost + $cashweedingtoolcost + $cashharvestingtransportcost
     + $cashharvestinglabourcost + $subcashplantingfertilizercost + $subcashplantingseedcost + $subcashplantinglabourcost +
     $subcashweedingchemicalcost + $subcashweedinglabourcost + $subcashweedingtoolcost + $subcashharvestingtransportcost
     + $subcashharvestinglabourcost;
        return response()->json($totalcosts);
    }    

    public function cropsale()
    {
        $cropsales = CropSale::sum('amount_due') + SubCashCropSale::sum('amount_due');

        return response()->json($cropsales);
    } 
    
    public function animalcost()
    {
        $animalcosts = DomesticFeedingCost::sum('amount_paid') +
        PetFeedingCost::sum('amount_paid') + DomesticVaccineCost::sum('amount_paid') + 
        DomesticDrugCost::sum('amount_paid') +  PetVaccineCost::sum('amount_paid') + 
        PetDrugCost::sum('amount_paid');

        return response()->json($animalcosts);
    } 
    
    public function animalsale()
    {
        $animalrevenue = AnimalSale::sum('amount_got') + CowMilkSale::sum('amount_got')
                         + OtherAnimalMilkSale::sum('amount_got');

        return response()->json($animalrevenue);
    } 
    
    public function poultrycost()
    {
        $poultrycosts = GradeFeedingCost::sum('amount_paid') +
        GradeFeedingOtherCost::sum('amount_paid') +  KienyejiFeedingCost::sum('amount_paid') +
        ImprovedKienyejiFeedingCost::sum('amount_paid') + 
        ExoticFeedingCost::sum('amount_paid') + 
        HybridFeedingCost::sum('amount_paid') + GradeVaccineCost::sum('amount_paid') +
        GradeDrugCost::sum('amount_paid') + KienyejiVaccineCost::sum('amount_paid') +
        KienyejiDrugCost::sum('amount_paid') + ImprovedKienyejiVaccineCost::sum('amount_paid') +
        ImprovedKienyejiDrugCost::sum('amount_paid') + ExoticVaccineCost::sum('amount_paid') +
        ExoticDrugCost::sum('amount_paid') + HybridVaccineCost::sum('amount_paid') +
        HybridDrugCost::sum('amount_paid');

        return response()->json($poultrycosts);
    } 
    
    public function poultrysale()
    {
        $poultryrevenue = GradeEggSale::sum('amount_got') + KienyejiEggSale::sum('amount_got') + ImprovedKienyejiEggSale::sum('amount_got')
        + ExoticEggSale::sum('amount_got') + HybridEggSale::sum('amount_got') + GradePoultrySale::sum('amount_got')
        + KienyejiPoultrySale::sum('amount_got') + ImprovedKienyejiPoultrySale::sum('amount_got')
        + ExoticPoultrySale::sum('amount_got') + HybridPoultrySale::sum('amount_got');

        return response()->json($poultryrevenue);
    }
    
    public function resourcecost()
    {
        $resourcecosts = ResourcePurchase::sum('amount_paid');

        return response()->json($resourcecosts);
    } 
    
    public function resourcesale()
    {
        $resourcerevenue = ResourceSale::sum('amount_paid');

        return response()->json($resourcerevenue);
    }  
    
    public function misccost()
    {
        $misccosts = SubPlantingOtherCost::sum('amount_paid') + CashPlantingOtherCost::sum('amount_paid')
                     + SubCashPlantingOtherCost::sum('amount_paid') + SubWeedingOtherCost::sum('amount_paid')
                     + CashWeedingOtherCost::sum('amount_paid') + SubCashWeedingOtherCost::sum('amount_paid') 
                     + SubHarvestingOtherCost::sum('amount_paid') + CashHarvestingOtherCost::sum('amount_paid')
                     + SubCashHarvestingOtherCost::sum('amount_paid') + DomesticFeedingOtherCost::sum('amount_paid')
                     + PetFeedingOtherCost::sum('amount_paid') + DomesticTreatingOtherCost::sum('amount_paid')
                     + PetTreatingOtherCost::sum('amount_paid') + GradeFeedingOtherCost::sum('amount_paid')
                     + KienyejiFeedingOtherCost::sum('amount_paid') + ImprovedKienyejiFeedingOtherCost::sum('amount_paid')
                     + ExoticFeedingOtherCost::sum('amount_paid') + HybridFeedingOtherCost::sum('amount_paid')
                     + GradeTreatingOtherCost::sum('amount_paid')
                     + KienyejiTreatingOtherCost::sum('amount_paid') + ImprovedKienyejiTreatingOtherCost::sum('amount_paid')
                     + ExoticTreatingOtherCost::sum('amount_paid') + HybridTreatingOtherCost::sum('amount_paid');

        return response()->json($misccosts);
        
    }
}
