<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crop;
use App\Models\SubPlantingFertilizerCost;
use App\Models\SubPlantingSeedCost;
use App\Models\SubPlantingLabourCost;
use App\Models\SubPlantingOtherCost;
use App\Models\SubWeedingChemicalCost;
use App\Models\SubWeedingToolCost;
use App\Models\SubWeedingLabourCost;
use App\Models\SubWeedingOtherCost;
use App\Models\SubHarvestingTransportCost;
use App\Models\SubHarvestingLabourCost;
use App\Models\SubHarvestingOtherCost;
use App\Models\SubPlantingDetail;
use App\Models\SubWeedingDetail;
use App\Models\SubHarvestingDetail;
use App\Models\CashPlantingFertilizerCost;
use App\Models\CashPlantingSeedCost;
use App\Models\CashPlantingLabourCost;
use App\Models\CashPlantingOtherCost;
use App\Models\CashWeedingChemicalCost;
use App\Models\CashWeedingToolCost;
use App\Models\CashWeedingLabourCost;
use App\Models\CashWeedingOtherCost;
use App\Models\CashHarvestingTransportCost;
use App\Models\CashHarvestingLabourCost;
use App\Models\CashHarvestingOtherCost;
use App\Models\CashPlantingDetail;
use App\Models\CashWeedingDetail;
use App\Models\CashHarvestingDetail;
use App\Models\SubCashPlantingFertilizerCost;
use App\Models\SubCashPlantingSeedCost;
use App\Models\SubCashPlantingLabourCost;
use App\Models\SubCashPlantingOtherCost;
use App\Models\SubCashWeedingChemicalCost;
use App\Models\SubCashWeedingToolCost;
use App\Models\SubCashWeedingLabourCost;
use App\Models\SubCashWeedingOtherCost;
use App\Models\SubCashHarvestingTransportCost;
use App\Models\SubCashHarvestingLabourCost;
use App\Models\SubCashHarvestingOtherCost;
use App\Models\SubCashHarvestingDetail;
use App\Models\SubCashWeedingDetail;
use App\Models\SubCashPlantingDetail;
use App\Models\CropSale;
use App\Models\SubCashCropSale;

class CropReportController extends Controller
{
    public function subplantingcost (Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subplantingfertilizercost = SubPlantingFertilizerCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subplantingseedcost = SubPlantingSeedCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subplantinglabourcost = SubPlantingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        $subplantingcosts = $subplantingfertilizercost + $subplantingseedcost + $subplantinglabourcost;
        return response()->json($subplantingcosts);
    }

    public function subfertilizercost(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subfertilizercosts = SubPlantingFertilizerCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subfertilizercosts);
    }

    public function subseedcost(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subseedcosts = SubPlantingSeedCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subseedcosts);
    }

    public function subplantinglabour(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subplantinglabourcosts = SubPlantingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subplantinglabourcosts);
    }  
    
    public function subplantinglabourused(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subplantinglabourused = SubPlantingLabourCost::where('crop_id',$crop->id)->sum('no_of_persons');

        return response()->json($subplantinglabourused);
    }     

    public function subweedingcost (Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subweedingchemicalcost = SubWeedingChemicalCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subweedinglabourcost = SubWeedingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subweedingtoolcost = SubWeedingToolCost::where('crop_id',$crop->id)->sum('amount_paid');

        $subweedingcosts = $subweedingchemicalcost + $subweedinglabourcost + $subweedingtoolcost;
        return response()->json($subweedingcosts);
    }

    public function subchemicalcost(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subchemicalcosts = SubWeedingChemicalCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subchemicalcosts);
    }

    public function subtoolcost(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subtoolcosts = SubWeedingToolCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subtoolcosts);
    }

    public function subweedinglabour(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subweedinglabourcosts = SubWeedingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subweedinglabourcosts);
    }  
    
    public function subweedinglabourused(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subweedinglabourused = SubWeedingLabourCost::where('crop_id',$crop->id)->sum('no_of_persons');

        return response()->json($subweedinglabourused);
    }     

    public function subharvestcost (Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subharvestingtransportcost = SubHarvestingTransportCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subharvestinglabourcost = SubHarvestingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        $subharvestcosts = $subharvestingtransportcost + $subharvestinglabourcost;
        return response()->json($subharvestcosts);
    }

    public function subcost (Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subplantingfertilizercost = SubPlantingFertilizerCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subplantingseedcost = SubPlantingSeedCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subplantinglabourcost = SubPlantingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');
        // $subplantingothercost = SubPlantingOtherCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subweedingchemicalcost = SubWeedingChemicalCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subweedinglabourcost = SubWeedingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subweedingtoolcost = SubWeedingToolCost::where('crop_id',$crop->id)->sum('amount_paid');
        // $subweedingothercost = SubWeedingOtherCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subharvestingtransportcost = SubHarvestingTransportCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subharvestinglabourcost = SubHarvestingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');
        // $subharvestingothercost = SubHarvestingOtherCost::where('crop_id',$crop->id)->sum('amount_paid');

        $subtotalcosts = $subplantingfertilizercost + $subplantingseedcost + $subplantinglabourcost + $subweedingchemicalcost + $subweedinglabourcost + $subweedingtoolcost + $subharvestingtransportcost + $subharvestinglabourcost;
        return response()->json($subtotalcosts);
    }

    public function subplanted(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subacreageplanted = SubPlantingDetail::where('crop_id',$crop->id)->sum('acreage_planted');
        return response()->json($subacreageplanted);

    }

    public function subweeded(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subacreageweeded = SubWeedingDetail::where('crop_id',$crop->id)->sum('acreage_weeded');
        return response()->json($subacreageweeded);        
    }

    public function subharvested(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subacreageharvested = SubHarvestingDetail::where('crop_id',$crop->id)->sum('acreage_harvested');
        return response()->json($subacreageharvested);        
    } 
    
    public function subtransportcost(Request $request, $id)
    {
        $crop= Crop::findOrFail($id);
        $subtransportcosts = SubHarvestingTransportCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subtransportcosts);                  
    }

    public function subharvestinglabour(Request $request, $id)
    {
        $crop= Crop::findOrFail($id);        
        $subharvestinglabourcosts = SubHarvestingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subharvestinglabourcosts);                  
    }

    public function subharvestinglabourused(Request $request, $id)
    {
        $crop= Crop::findOrFail($id);        
        $subharvestinglabourused = SubHarvestingLabourCost::where('crop_id',$crop->id)->sum('no_of_persons');

        return response()->json($subharvestinglabourused);
    }    

    public function cashcost (Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashplantingfertilizercost = CashPlantingFertilizerCost::where('crop_id',$crop->id)->sum('amount_paid');
        $cashplantingseedcost = CashPlantingSeedCost::where('crop_id',$crop->id)->sum('amount_paid');
        $cashplantinglabourcost = CashPlantingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');
        // $cashplantingothercost = CashPlantingOtherCost::where('crop_id',$crop->id)->sum('amount_paid');
        $cashweedingchemicalcost = CashWeedingChemicalCost::where('crop_id',$crop->id)->sum('amount_paid');
        $cashweedinglabourcost = CashWeedingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');
        $cashweedingtoolcost = CashWeedingToolCost::where('crop_id',$crop->id)->sum('amount_paid');
        // $cashweedingothercost = CashWeedingOtherCost::where('crop_id',$crop->id)->sum('amount_paid');
        $cashharvestingtransportcost = CashHarvestingTransportCost::where('crop_id',$crop->id)->sum('amount_paid');
        $cashharvestinglabourcost = CashHarvestingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');
        // $cashharvestingothercost = CashHarvestingOtherCost::where('crop_id',$crop->id)->sum('amount_paid');

        $cashtotalcosts = $cashplantingfertilizercost + $cashplantingseedcost + $cashplantinglabourcost + $cashweedingchemicalcost + $cashweedinglabourcost + $cashweedingtoolcost + $cashharvestingtransportcost + $cashharvestinglabourcost;
        return response()->json($cashtotalcosts);
    }

    public function cashplantingcost (Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashplantingfertilizercost = CashPlantingFertilizerCost::where('crop_id',$crop->id)->sum('amount_paid');
        $cashplantingseedcost = CashPlantingSeedCost::where('crop_id',$crop->id)->sum('amount_paid');
        $cashplantinglabourcost = CashPlantingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        $cashplantingcosts = $cashplantingfertilizercost + $cashplantingseedcost + $cashplantinglabourcost;
        return response()->json($cashplantingcosts);
    }

    public function cashfertilizercost(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashfertilizercosts = CashPlantingFertilizerCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($cashfertilizercosts);
    }

    public function cashseedcost(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashseedcosts = CashPlantingSeedCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($cashseedcosts);
    }

    public function cashplantinglabour(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashplantinglabourcosts = CashPlantingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($cashplantinglabourcosts);
    }  
    
    public function cashplantinglabourused(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashplantinglabourused = CashPlantingLabourCost::where('crop_id',$crop->id)->sum('no_of_persons');

        return response()->json($cashplantinglabourused);
    }     

    public function cashweedingcost (Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashweedingchemicalcost  = CashWeedingChemicalCost::where('crop_id',$crop->id)->sum('amount_paid');
        $cashweedinglabourcost  = CashWeedingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');
        $cashweedingtoolcost  = CashWeedingToolCost::where('crop_id',$crop->id)->sum('amount_paid');

        $cashweedingcosts = $cashweedingchemicalcost + $cashweedinglabourcost + $cashweedingtoolcost;
        return response()->json($cashweedingcosts);
    }

    public function cashchemicalcost(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashchemicalcosts = CashWeedingChemicalCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($cashchemicalcosts);
    }

    public function cashtoolcost(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashtoolcosts = CashWeedingToolCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($cashtoolcosts);
    }

    public function cashweedinglabour(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashweedinglabourcosts = CashWeedingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($cashweedinglabourcosts);
    }  
    
    public function cashweedinglabourused(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashweedinglabourused = CashWeedingLabourCost::where('crop_id',$crop->id)->sum('no_of_persons');

        return response()->json($cashweedinglabourused);
    }     

    public function cashharvestcost (Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashharvestingtransportcost = CashHarvestingTransportCost::where('crop_id',$crop->id)->sum('amount_paid');
        $cashharvestinglabourcost = CashHarvestingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        $cashharvestcosts = $cashharvestingtransportcost + $cashharvestinglabourcost;
        return response()->json($cashharvestcosts);
    }

    public function cashtransportcost(Request $request, $id)
    {
        $crop= Crop::findOrFail($id);
        $cashtransportcosts = CashHarvestingTransportCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($cashtransportcosts);                  
    }

    public function cashharvestinglabour(Request $request, $id)
    {
        $crop= Crop::findOrFail($id);        
        $cashharvestinglabourcosts = CashHarvestingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($cashharvestinglabourcosts);                  
    }

    public function cashharvestinglabourused(Request $request, $id)
    {
        $crop= Crop::findOrFail($id);        
        $cashharvestinglabourused = CashHarvestingLabourCost::where('crop_id',$crop->id)->sum('no_of_persons');

        return response()->json($cashharvestinglabourused);
    }     
    
    public function cashsale(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashrevenue = CropSale::where('crop_id',$crop->id)->sum('amount_due');

        return response()->json($cashrevenue);
    }

    public function subcashsale(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashrevenue = SubCashCropSale::where('crop_id',$crop->id)->sum('amount_due');

        return response()->json($subcashrevenue);
    }
    
    public function cashplanted(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashacreageplanted = CashPlantingDetail::where('crop_id',$crop->id)->sum('acreage_planted');
        return response()->json($cashacreageplanted);

    }

    public function cashweeded(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashacreageweeded = CashWeedingDetail::where('crop_id',$crop->id)->sum('acreage_weeded');
        return response()->json($cashacreageweeded);        
    }

    public function cashharvested(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $cashacreageharvested = CashHarvestingDetail::where('crop_id',$crop->id)->sum('acreage_harvested');
        return response()->json($cashacreageharvested);        
    }       

    public function subcashplanted(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashacreageplanted = SubCashPlantingDetail::where('crop_id',$crop->id)->sum('acreage_planted');
        return response()->json($subcashacreageplanted);

    }

    public function subcashweeded(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashacreageweeded = SubCashWeedingDetail::where('crop_id',$crop->id)->sum('acreage_weeded');
        return response()->json($subcashacreageweeded);        
    }

    public function subcashharvested(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashacreageharvested = SubCashHarvestingDetail::where('crop_id',$crop->id)->sum('acreage_harvested');
        return response()->json($subcashacreageharvested);        
    }    

    public function subcashplantingcost(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashplantingfertilizercost = SubCashPlantingFertilizerCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subcashplantingseedcost = SubCashPlantingSeedCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subcashplantinglabourcost = SubCashPlantingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        $subcashplantingcosts = $subcashplantingfertilizercost + $subcashplantingseedcost + $subcashplantinglabourcost;
        return response()->json($subcashplantingcosts);
    }    

    public function subcashfertilizercost(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashfertilizercosts = SubCashPlantingFertilizerCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subcashfertilizercosts);
    }

    public function subcashseedcost(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashseedcosts = SubCashPlantingSeedCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subcashseedcosts);
    }

    public function subcashplantinglabour(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashplantinglabourcosts = SubCashPlantingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subcashplantinglabourcosts);
    }  
    
    public function subcashplantinglabourused(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashplantinglabourused = SubCashPlantingLabourCost::where('crop_id',$crop->id)->sum('no_of_persons');

        return response()->json($subcashplantinglabourused);
    } 

    public function subcashweedingcost (Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashweedingchemicalcost  = SubCashWeedingChemicalCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subcashweedinglabourcost  = SubCashWeedingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subcashweedingtoolcost  = SubCashWeedingToolCost::where('crop_id',$crop->id)->sum('amount_paid');

        $subcashweedingcosts = $subcashweedingchemicalcost + $subcashweedinglabourcost + $subcashweedingtoolcost;
        return response()->json($subcashweedingcosts);
    }    
    
    public function subcashchemicalcost(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashchemicalcosts = SubCashWeedingChemicalCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subcashchemicalcosts);
    }

    public function subcashtoolcost(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashtoolcosts = SubCashWeedingToolCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subcashtoolcosts);
    }

    public function subcashweedinglabour(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashweedinglabourcosts = SubCashWeedingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subcashweedinglabourcosts);
    }  
    
    public function subcashweedinglabourused(Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashweedinglabourused = SubCashWeedingLabourCost::where('crop_id',$crop->id)->sum('no_of_persons');

        return response()->json($subcashweedinglabourused);
    } 

    public function subcashharvestcost (Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashharvestingtransportcost = SubCashHarvestingTransportCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subcashharvestinglabourcost = SubCashHarvestingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        $subcashharvestcosts = $subcashharvestingtransportcost + $subcashharvestinglabourcost;
        return response()->json($subcashharvestcosts);
    }    

    public function subcashtransportcost(Request $request, $id)
    {
        $crop= Crop::findOrFail($id);
        $subcashtransportcosts = SubCashHarvestingTransportCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subcashtransportcosts);                  
    }

    public function subcashharvestinglabour(Request $request, $id)
    {
        $crop= Crop::findOrFail($id);        
        $subcashharvestinglabourcosts = SubCashHarvestingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');

        return response()->json($subcashharvestinglabourcosts);                  
    }

    public function subcashharvestinglabourused(Request $request, $id)
    {
        $crop= Crop::findOrFail($id);        
        $subcashharvestinglabourused = SubCashHarvestingLabourCost::where('crop_id',$crop->id)->sum('no_of_persons');

        return response()->json($subcashharvestinglabourused);
    }     
    
    public function subcashcost (Request $request,$id)
    {
        $crop = Crop::findOrFail($id);
        $subcashplantingfertilizercost = SubCashPlantingFertilizerCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subcashplantingseedcost = SubCashPlantingSeedCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subcashplantinglabourcost = SubCashPlantingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');
        // $subcashplantingothercost = SubCashPlantingOtherCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subcashweedingchemicalcost = SubCashWeedingChemicalCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subcashweedinglabourcost = SubCashWeedingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subcashweedingtoolcost = SubCashWeedingToolCost::where('crop_id',$crop->id)->sum('amount_paid');
        // $subcashweedingothercost = SubCashWeedingOtherCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subcashharvestingtransportcost = SubCashHarvestingTransportCost::where('crop_id',$crop->id)->sum('amount_paid');
        $subcashharvestinglabourcost = SubCashHarvestingLabourCost::where('crop_id',$crop->id)->sum('amount_paid');
        // $subcashharvestingothercost = SubCashHarvestingOtherCost::where('crop_id',$crop->id)->sum('amount_paid');

        $subcashtotalcosts = $subcashplantingfertilizercost + $subcashplantingseedcost + $subcashplantinglabourcost +
         $subcashweedingchemicalcost + $subcashweedinglabourcost + $subcashweedingtoolcost + $subcashharvestingtransportcost +
          $subcashharvestinglabourcost;
        return response()->json($subcashtotalcosts);
    } 

    public function plantcost()
    {
        $plantingcosts = SubPlantingFertilizerCost::sum('amount_paid') + SubPlantingSeedCost::sum('amount_paid') +
                         SubPlantingLabourCost::sum('amount_paid') + SubPlantingOtherCost::sum('amount_paid') +  
                         CashPlantingFertilizerCost::sum('amount_paid') + CashPlantingSeedCost::sum('amount_paid') +
                         CashPlantingLabourCost::sum('amount_paid') + CashPlantingOtherCost::sum('amount_paid') +
                         SubCashPlantingFertilizerCost::sum('amount_paid') + SubCashPlantingSeedCost::sum('amount_paid') +
                         SubCashPlantingLabourCost::sum('amount_paid') + SubCashPlantingOtherCost::sum('amount_paid');

        return response()->json($plantingcosts);                 
    }

    public function fertilizercost()
    {
        $fertilizercosts = SubPlantingFertilizerCost::sum('amount_paid') +  
                         CashPlantingFertilizerCost::sum('amount_paid') + 
                         SubCashPlantingFertilizerCost::sum('amount_paid');

        return response()->json($fertilizercosts);                 
    }  
    
    public function seedcost()
    {
        $seedcosts = SubPlantingSeedCost::sum('amount_paid') +  
                         CashPlantingSeedCost::sum('amount_paid') + 
                         SubCashPlantingSeedCost::sum('amount_paid');

        return response()->json($seedcosts);                 
    } 
    
    public function plantinglabour()
    {
        $labourcosts = SubPlantingLabourCost::sum('amount_paid') +  
                         CashPlantingLabourCost::sum('amount_paid') + 
                         SubCashPlantingLabourCost::sum('amount_paid');

        return response()->json($labourcosts);                 
    }
    
    public function plantingmisc()
    {
        $othercosts = SubPlantingOtherCost::sum('amount_paid') +  
                         CashPlantingOtherCost::sum('amount_paid') + 
                         SubCashPlantingOtherCost::sum('amount_paid');

        return response()->json($othercosts);                 
    }
    
    public function acreplanted()
    {
        $acreageplanted = SubPlantingDetail::sum('acreage_planted') +
                          CashPlantingDetail::sum('acreage_planted') +
                          SubCashPlantingDetail::sum('acreage_planted');
                          
        return response()->json($acreageplanted);                  
    }

    public function plantinglabourused()
    {
        $plantinglabourused = SubPlantingLabourCost::sum('no_of_persons') +
                              CashPlantingLabourCost::sum('no_of_persons') +
                              SubCashPlantingLabourCost::sum('no_of_persons');
        
        return response()->json($plantinglabourused);                      
    }

    public function prevfertilizer()
    {
        $prevfertilizer = SubPlantingDetail::select('fertilizer_type')->selectRaw('COUNT(*) AS count')
                          ->groupBy('fertilizer_type')->orderByDesc('count')->limit(1)->get();
    }

    public function weedcost()
    {
        $weedingcosts = SubWeedingChemicalCost::sum('amount_paid') + SubWeedingToolCost::sum('amount_paid') +
                         SubWeedingLabourCost::sum('amount_paid') + SubWeedingOtherCost::sum('amount_paid') +  
                         CashWeedingChemicalCost::sum('amount_paid') + CashWeedingToolCost::sum('amount_paid') +
                         CashWeedingLabourCost::sum('amount_paid') + CashWeedingOtherCost::sum('amount_paid') +
                         SubCashWeedingChemicalCost::sum('amount_paid') + SubCashWeedingToolCost::sum('amount_paid') +
                         SubCashWeedingLabourCost::sum('amount_paid') + SubCashWeedingOtherCost::sum('amount_paid');
                         
        return response()->json($weedingcosts);                 
    }

    public function chemicalcost()
    {
        $chemicalcosts = SubWeedingChemicalCost::sum('amount_paid') +  
                         CashWeedingChemicalCost::sum('amount_paid') + 
                         SubCashWeedingChemicalCost::sum('amount_paid');

        return response()->json($chemicalcosts);
    }  
    
    public function toolcost()
    {
        $toolcosts = SubWeedingToolCost::sum('amount_paid') +  
                         CashWeedingToolCost::sum('amount_paid') + 
                         SubCashWeedingToolCost::sum('amount_paid');

        return response()->json($toolcosts);                 
    } 
    
    public function weedinglabour()
    {
        $labourcosts = SubWeedingLabourCost::sum('amount_paid') +  
                         CashWeedingLabourCost::sum('amount_paid') + 
                         SubCashWeedingLabourCost::sum('amount_paid');

        return response()->json($labourcosts);                 
    }
    
    public function weedingmisc()
    {
        $othercosts = SubWeedingOtherCost::sum('amount_paid') +  
                         CashWeedingOtherCost::sum('amount_paid') + 
                         SubCashWeedingOtherCost::sum('amount_paid');

        return response()->json($othercosts);                 
    }
    
    public function acreweeded()
    {
        $acreageweeded = SubWeedingDetail::sum('acreage_weeded') +
                          CashWeedingDetail::sum('acreage_weeded') +
                          SubCashWeedingDetail::sum('acreage_weeded');
                          
        return response()->json($acreageweeded);                  
    }

    public function weedinglabourused()
    {
        $weedinglabourused = SubWeedingLabourCost::sum('no_of_persons') +
                              CashWeedingLabourCost::sum('no_of_persons') +
                              SubCashWeedingLabourCost::sum('no_of_persons');
        
        return response()->json($weedinglabourused);                      
    }

    public function prevchemical()
    {
        $prevchemical = SubWeedingDetail::select('chemical_type')->selectRaw('COUNT(*) AS count')
                          ->groupBy('chemical_type')->orderByDesc('count')->limit(1)->get();
    }    
    
    public function harvestcost()
    {
        $harvestingcosts = SubHarvestingTransportCost::sum('amount_paid') + 
                         SubHarvestingLabourCost::sum('amount_paid') + SubHarvestingOtherCost::sum('amount_paid') +  
                         CashHarvestingTransportCost::sum('amount_paid') + 
                         CashHarvestingLabourCost::sum('amount_paid') + CashHarvestingOtherCost::sum('amount_paid') +
                         SubCashHarvestingTransportCost::sum('amount_paid') + 
                         SubCashHarvestingLabourCost::sum('amount_paid') + SubCashHarvestingOtherCost::sum('amount_paid');
         
        return response()->json($harvestingcosts);                 
    } 

    public function acreharvested()
    {
        $acreharvested = SubHarvestingDetail::sum('acreage_harvested') +
                          CashHarvestingDetail::sum('acreage_harvested') +
                          SubCashHarvestingDetail::sum('acreage_harvested');
                          
        return response()->json($acreharvested);                  
    }    
    
    public function cropharvest()
    {
        return CashHarvestingDetail::latest()->with('crop')->paginate(10);        
    }
    
    public function subcashcropharvest()
    {
        return SubCashHarvestingDetail::latest()->with('crop')->paginate(10);        
    } 

    public function transportcost()
    {
        $transportcosts = SubHarvestingTransportCost::sum('amount_paid') +
                          CashHarvestingTransportCost::sum('amount_paid') +
                          SubCashHarvestingTransportCost::sum('amount_paid');

        return response()->json($transportcosts);                  
    }

    public function harvestinglabour()
    {
        $harvestinglabourcosts = SubHarvestingLabourCost::sum('amount_paid') +
                          CashHarvestingLabourCost::sum('amount_paid') +
                          SubCashHarvestingLabourCost::sum('amount_paid');

        return response()->json($harvestinglabourcosts);                  
    }

    public function harvestinglabourused()
    {
        $harvestinglabourused = SubHarvestingLabourCost::sum('no_of_persons') +
                          CashHarvestingLabourCost::sum('no_of_persons') +
                          SubCashHarvestingLabourCost::sum('no_of_persons');

        return response()->json($harvestinglabourused);
    }

    public function harvestingmisc()
    {
        $harvestingmisccosts = SubHarvestingOtherCost::sum('amount_paid') +
                          CashHarvestingOtherCost::sum('amount_paid') +
                          SubCashHarvestingOtherCost::sum('amount_paid');

        return response()->json($harvestingmisccosts);
    }
    
    public function generalcost (Request $request)
    {
        $subplantingfertilizercost = SubPlantingFertilizerCost::sum('amount_paid');
        $subplantingseedcost = SubPlantingSeedCost::sum('amount_paid');
        $subplantinglabourcost = SubPlantingLabourCost::sum('amount_paid');
        $subplantingothercost = SubPlantingOtherCost::sum('amount_paid');
        $subweedingchemicalcost = SubWeedingChemicalCost::sum('amount_paid');
        $subweedinglabourcost = SubWeedingLabourCost::sum('amount_paid');
        $subweedingtoolcost = SubWeedingToolCost::sum('amount_paid');
        $subweedingothercost = SubWeedingOtherCost::sum('amount_paid');
        $subharvestingtransportcost = SubHarvestingTransportCost::sum('amount_paid');
        $subharvestinglabourcost = SubHarvestingLabourCost::sum('amount_paid');
        $subharvestingothercost = SubHarvestingOtherCost::sum('amount_paid');

        $cashplantingfertilizercost = CashPlantingFertilizerCost::sum('amount_paid');
        $cashplantingseedcost = CashPlantingSeedCost::sum('amount_paid');
        $cashplantinglabourcost = CashPlantingLabourCost::sum('amount_paid');
        $cashplantingothercost = CashPlantingOtherCost::sum('amount_paid');
        $cashweedingchemicalcost = CashWeedingChemicalCost::sum('amount_paid');
        $cashweedinglabourcost = CashWeedingLabourCost::sum('amount_paid');
        $cashweedingtoolcost = CashWeedingToolCost::sum('amount_paid');
        $cashweedingothercost = CashWeedingOtherCost::sum('amount_paid');
        $cashharvestingtransportcost = CashHarvestingTransportCost::sum('amount_paid');
        $cashharvestinglabourcost = CashHarvestingLabourCost::sum('amount_paid');
        $cashharvestingothercost = CashHarvestingOtherCost::sum('amount_paid');

        $subcashplantingfertilizercost = SubCashPlantingFertilizerCost::sum('amount_paid');
        $subcashplantingseedcost = SubCashPlantingSeedCost::sum('amount_paid');
        $subcashplantinglabourcost = SubCashPlantingLabourCost::sum('amount_paid');
        $subcashplantingothercost = SubCashPlantingOtherCost::sum('amount_paid');
        $subcashweedingchemicalcost = SubCashWeedingChemicalCost::sum('amount_paid');
        $subcashweedinglabourcost = SubCashWeedingLabourCost::sum('amount_paid');
        $subcashweedingtoolcost = SubCashWeedingToolCost::sum('amount_paid');
        $subcashweedingothercost = SubCashWeedingOtherCost::sum('amount_paid');
        $subcashharvestingtransportcost = SubCashHarvestingTransportCost::sum('amount_paid');
        $subcashharvestinglabourcost = SubCashHarvestingLabourCost::sum('amount_paid');
        $subcashharvestingothercost = SubCashHarvestingOtherCost::sum('amount_paid');

        $totalcosts = $subplantingfertilizercost + $subplantingseedcost + $subplantinglabourcost + $subplantingothercost +
     $subweedingchemicalcost + $subweedinglabourcost + $subweedingtoolcost + $subweedingothercost + $subharvestingtransportcost
     + $subharvestinglabourcost + $subharvestingothercost + $cashplantingfertilizercost + $cashplantingseedcost + $cashplantinglabourcost + $cashplantingothercost +
     $cashweedingchemicalcost + $cashweedinglabourcost + $cashweedingtoolcost + $cashweedingothercost + $cashharvestingtransportcost
     + $cashharvestinglabourcost + $cashharvestingothercost + $subcashplantingfertilizercost + $subcashplantingseedcost + $subcashplantinglabourcost + $subcashplantingothercost +
     $subcashweedingchemicalcost + $subcashweedinglabourcost + $subcashweedingtoolcost + $subcashweedingothercost + $subcashharvestingtransportcost
     + $subcashharvestinglabourcost + $subcashharvestingothercost;
        return response()->json($totalcosts);
    }       
}
