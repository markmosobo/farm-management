<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('domestictotalcosts/{id}',[API\AnimalReportController::class,'domesticcost']);
Route::apiResources([
    'user' => API\UserController::class,
    'farm' => API\FarmController::class,
    'crop' => API\CropController::class,
    'animal' => API\AnimalController::class,
    'poultry' => API\PoultryController::class,
    'resource' => API\ResourceController::class,
    'resourcepurchase' => API\ResourcePurchaseController::class,
    'resourcesale' => API\ResourceSaleController::class,

    'subplantingdetail' => API\SubPlantingDetailController::class,
    'subplantinglabourcost' => API\SubPlantingLabourCostController::class,
    'subplantingfertilizercost' => API\SubPlantingFertilizerCostController::class,
    'subplantingothercost' => API\SubPlantingOtherCostController::class,
    'subplantingseedcost' => API\SubPlantingSeedCostController::class,

    'cashplantingdetail' => API\CashPlantingDetailController::class,
    'cashplantinglabourcost' => API\CashPlantingLabourCostController::class,
    'cashplantingfertilizercost' => API\CashPlantingFertilizerCostController::class,
    'cashplantingothercost' => API\CashPlantingOtherCostController::class,
    'cashplantingseedcost' => API\CashPlantingSeedCostController::class,

    'subcashplantingdetail' => API\SubCashPlantingDetailController::class,
    'subcashplantinglabourcost' => API\SubCashPlantingLabourCostController::class,
    'subcashplantingfertilizercost' => API\SubCashPlantingFertilizerCostController::class,
    'subcashplantingothercost' => API\SubCashPlantingOtherCostController::class,
    'subcashplantingseedcost' => API\SubCashPlantingSeedCostController::class,

    'subweedingdetail' => API\SubWeedingDetailController::class,
    'subweedinglabourcost' => API\SubWeedingLabourCostController::class,
    'subweedingchemicalcost' => API\SubWeedingChemicalCostController::class,
    'subweedingothercost' => API\SubWeedingOtherCostController::class,
    'subweedingtoolcost' => API\SubWeedingToolCostController::class,

    'cashweedingdetail' => API\CashWeedingDetailController::class,
    'cashweedinglabourcost' => API\CashWeedingLabourCostController::class,
    'cashweedingchemicalcost' => API\CashWeedingChemicalCostController::class,
    'cashweedingothercost' => API\CashWeedingOtherCostController::class,
    'cashweedingtoolcost' => API\CashWeedingToolCostController::class,

    'subcashweedingdetail' => API\SubCashWeedingDetailController::class,
    'subcashweedinglabourcost' => API\SubCashWeedingLabourCostController::class,
    'subcashweedingchemicalcost' => API\SubCashWeedingChemicalCostController::class,
    'subcashweedingothercost' => API\SubCashWeedingOtherCostController::class,
    'subcashweedingtoolcost' => API\SubCashWeedingToolCostController::class,

    'subharvestingdetail' => API\SubHarvestingDetailController::class,
    'subharvestinglabourcost' => API\SubHarvestingLabourCostController::class,
    'subharvestingtransportcost' => API\SubHarvestingTransportCostController::class,
    'subharvestingothercost' => API\SubHarvestingOtherCostController::class,

    'cashharvestingdetail' => API\CashHarvestingDetailController::class,
    'cashharvestinglabourcost' => API\CashHarvestingLabourCostController::class,
    'cashharvestingtransportcost' => API\CashHarvestingTransportCostController::class,
    'cashharvestingothercost' => API\CashHarvestingOtherCostController::class,

    'subcashharvestingdetail' => API\SubCashHarvestingDetailController::class,
    'subcashharvestinglabourcost' => API\SubCashHarvestingLabourCostController::class,
    'subcashharvestingtransportcost' => API\SubCashHarvestingTransportCostController::class,
    'subcashharvestingothercost' => API\SubCashHarvestingOtherCostController::class,

    'cropsale' => API\CropSaleController::class,
    'subcashcropsale' => API\SubCashCropSaleController::class,

    'gradefeedingdetail' => API\GradeFeedingDetailController::class,
    'gradefeedingcost' => API\GradeFeedingCostController::class,
    'gradefeedingothercost' => API\GradeFeedingOtherCostController::class,

    'kienyejifeedingdetail' => API\KienyejiFeedingDetailController::class,
    'kienyejifeedingcost' => API\KienyejiFeedingCostController::class,
    'kienyejifeedingothercost' => API\KienyejiFeedingOtherCostController::class,

    'improvedkienyejifeedingdetail' => API\ImprovedKienyejiFeedingDetailController::class,
    'improvedkienyejifeedingcost' => API\ImprovedKienyejiFeedingCostController::class,
    'improvedkienyejifeedingothercost' => API\ImprovedKienyejiFeedingOtherCostController::class,

    'exoticfeedingdetail' => API\ExoticFeedingDetailController::class,
    'exoticfeedingcost' => API\ExoticFeedingCostController::class,
    'exoticfeedingothercost' => API\ExoticFeedingOtherCostController::class,

    'hybridfeedingdetail' => API\HybridFeedingDetailController::class,
    'hybridfeedingcost' => API\HybridFeedingCostController::class,
    'hybridfeedingothercost' => API\HybridFeedingOtherCostController::class,

    'gradevaccinatingdetail' => API\GradeVaccinatingDetailController::class,
    'gradetreatingdetail' => API\GradeTreatingDetailController::class,
    'gradevaccinecost' => API\GradeVaccineCostController::class,
    'gradedrugcost' => API\GradeDrugCostController::class,
    'gradetreatingothercost' => API\GradeTreatingOtherCostController::class,

    'kienyejivaccinatingdetail' => API\KienyejiVaccinatingDetailController::class,
    'kienyejitreatingdetail' => API\KienyejiTreatingDetailController::class,
    'kienyejivaccinecost' => API\KienyejiVaccineCostController::class,
    'kienyejidrugcost' => API\KienyejiDrugCostController::class,
    'kienyejitreatingothercost' => API\KienyejiTreatingOtherCostController::class,

    'ikienyejivaccinatingdetail' => API\ImprovedKienyejiVaccinatingDetailController::class,
    'ikienyejitreatingdetail' => API\ImprovedKienyejiTreatingDetailController::class,
    'ikienyejivaccinecost' => API\ImprovedKienyejiVaccineCostController::class,
    'ikienyejidrugcost' => API\ImprovedKienyejiDrugCostController::class,
    'ikienyejitreatingothercost' => API\ImprovedKienyejiTreatingOtherCostController::class,

    'exoticvaccinatingdetail' => API\ExoticVaccinatingDetailController::class,
    'exotictreatingdetail' => API\ExoticTreatingDetailController::class,
    'exoticvaccinecost' => API\ExoticVaccineCostController::class,
    'exoticdrugcost' => API\ExoticDrugCostController::class,
    'exotictreatingothercost' => API\ExoticTreatingOtherCostController::class,

    'hybridvaccinatingdetail' => API\HybridVaccinatingDetailController::class,
    'hybridtreatingdetail' => API\HybridTreatingDetailController::class,
    'hybridvaccinecost' => API\HybridVaccineCostController::class,
    'hybriddrugcost' => API\HybridDrugCostController::class,
    'hybridtreatingothercost' => API\HybridTreatingOtherCostController::class,

    'gradelayingdetail' => API\GradeLayingDetailController::class,
    'gradehatchingdetail' => API\GradeHatchingDetailController::class,
    'gradeeggsale' => API\GradeEggSaleController::class,
    'gradepoultrysale' => API\GradePoultrySaleController::class,
    'gradeproductotheruse' => API\GradeProductOtherUseController::class,

    'kienyejilayingdetail' => API\KienyejiLayingDetailController::class,
    'kienyejihatchingdetail' => API\KienyejiHatchingDetailController::class,
    'kienyejieggsale' => API\KienyejiEggSaleController::class,
    'kienyejipoultrysale' => API\KienyejiPoultrySaleController::class,
    'kienyejiproductotheruse' => API\KienyejiProductOtherUseController::class,

    'ikienyejilayingdetail' => API\ImprovedKienyejiLayingDetailController::class,
    'ikienyejihatchingdetail' => API\ImprovedKienyejiHatchingDetailController::class,
    'ikienyejieggsale' => API\ImprovedKienyejiEggSaleController::class,
    'ikienyejipoultrysale' => API\ImprovedKienyejiPoultrySaleController::class,
    'ikienyejiproductotheruse' => API\ImprovedKienyejiProductOtherUseController::class,

    'exoticlayingdetail' => API\ExoticLayingDetailController::class,
    'exotichatchingdetail' => API\ExoticHatchingDetailController::class,
    'exoticeggsale' => API\ExoticEggSaleController::class,
    'exoticpoultrysale' => API\ExoticPoultrySaleController::class,
    'exoticproductotheruse' => API\ExoticProductOtherUseController::class,

    'hybridlayingdetail' => API\HybridLayingDetailController::class,
    'hybridhatchingdetail' => API\HybridHatchingDetailController::class,
    'hybrideggsale' => API\HybridEggSaleController::class,
    'hybridpoultrysale' => API\HybridPoultrySaleController::class,
    'hybridproductotheruse' => API\HybridProductOtherUseController::class,

    'domesticfeedingdetail' => API\DomesticFeedingDetailController::class,
    'domesticfeedingcost' => API\DomesticFeedingCostController::class,
    'domesticfeedingothercost' => API\DomesticFeedingOtherCostController::class,

    'petfeedingdetail' => API\PetFeedingDetailController::class,
    'petfeedingcost' => API\PetFeedingCostController::class,
    'petfeedingothercost' => API\PetFeedingOtherCostController::class,

    'domesticvaccinatingdetail' => API\DomesticVaccinatingDetailController::class,
    'domestictreatingdetail' => API\DomesticTreatingDetailController::class,
    'domesticvaccinecost' => API\DomesticVaccineCostController::class,
    'domesticdrugcost' => API\DomesticDrugCostController::class,
    'domestictreatingothercost' => API\DomesticTreatingOtherCostController::class,

    'petvaccinatingdetail' => API\PetVaccinatingDetailController::class,
    'pettreatingdetail' => API\PetTreatingDetailController::class,
    'petvaccinecost' => API\PetVaccineCostController::class,
    'petdrugcost' => API\PetDrugCostController::class,
    'pettreatingothercost' => API\PetTreatingOtherCostController::class,

    'cowmilkingdetail' => API\CowMilkingDetailController::class,
    'otheranimalmilkingdetail' => API\OtherAnimalMilkingDetailController::class,
    'cowmilksale' => API\CowMilkSaleController::class,
    'otheranimalmilksale' => API\OtherAnimalMilkSaleController::class,
    'animalsale' => API\AnimalSaleController::class,
    'animalproductotheruse' => API\AnimalProductOtherUseController::class,

]);
Route::get('profile',[API\ProfileController::class,'profile']);
Route::put('profile',[API\ProfileController::class,'updateProfile']);
Route::get('listusers',[API\UserController::class,'list']);
Route::get('listfarms',[API\FarmController::class,'list']);
Route::get('subcroplist',[API\CropController::class,'list']);
Route::get('cashcroplist',[API\CropController::class,'listcash']);
Route::get('subcashcroplist',[API\CropController::class,'listsubcash']);
Route::get('cropsno',[API\CropController::class,'noofcrops']);

Route::get('gradepoultrieslist',[API\PoultryController::class,'list']);
Route::get('kienyejipoultrieslist',[API\PoultryController::class,'listkienyeji']);
Route::get('ikienyejipoultrieslist',[API\PoultryController::class,'listimprovedkienyeji']);
Route::get('exoticpoultrieslist',[API\PoultryController::class,'listexotic']);
Route::get('hybridpoultrieslist',[API\PoultryController::class,'listhybrid']);
Route::get('numberlaid',[API\EggReportController::class,'numberlaid']);
Route::get('numberhatched',[API\EggReportController::class,'numberhatched']);
Route::get('numbersold',[API\EggReportController::class,'numbersold']);
Route::get('eggsales',[API\EggReportController::class,'eggsale']);
Route::get('gradenumberlaid/{id}',[API\EggReportController::class,'gradenumberlaid']);
Route::get('gradenumberhatched/{id}',[API\EggReportController::class,'gradenumberhatched']);
Route::get('kienyejinumberlaid/{id}',[API\EggReportController::class,'kienyejinumberlaid']);
Route::get('kienyejinumberhatched/{id}',[API\EggReportController::class,'kienyejinumberhatched']);
Route::get('ikienyejinumberlaid/{id}',[API\EggReportController::class,'ikienyejinumberlaid']);
Route::get('ikienyejinumberhatched/{id}',[API\EggReportController::class,'ikienyejinumberhatched']);
Route::get('exoticnumberlaid/{id}',[API\EggReportController::class,'exoticnumberlaid']);
Route::get('exoticnumberhatched/{id}',[API\EggReportController::class,'exoticnumberhatched']);
Route::get('hybridnumberlaid/{id}',[API\EggReportController::class,'hybridnumberlaid']);
Route::get('hybridnumberhatched/{id}',[API\EggReportController::class,'hybridnumberhatched']);

Route::get('domesticanimalslist',[API\AnimalController::class,'list']);
Route::get('petanimalslist',[API\AnimalController::class,'listpet']);
Route::get('animalslist',[API\AnimalController::class,'listanimal']);
Route::get('milkanimalslist',[API\AnimalController::class,'listmilkanimal']);
Route::get('cownameslist',[API\CowMilkingDetailController::class,'list']);
Route::get('cowlitres/{id}',[API\MilkReportController::class,'cowlitre']);
Route::get('cowsoldlitres',[API\MilkReportController::class,'cowsoldlitre']);
Route::get('cowmilksales',[API\MilkReportController::class,'cowmilksale']);
Route::get('milkanimallitres/{id}',[API\MilkReportController::class,'milkanimallitre']);
Route::get('milkanimalsoldlitres/{id}',[API\MilkReportController::class,'milkanimalsoldlitre']);
Route::get('milkanimalmilksales/{id}',[API\MilkReportController::class,'milkanimalmilksale']);
Route::get('litresproduced',[API\MilkReportController::class,'litre']);
Route::get('litressold',[API\MilkReportController::class,'litresold']);
Route::get('generalmilksales',[API\MilkReportController::class,'milksale']);

Route::get('subplantingcosts/{id}',[API\CropReportController::class,'subplantingcost']);
Route::get('subfertilizercosts/{id}',[API\CropReportController::class,'subfertilizercost']);
Route::get('subseedcosts/{id}',[API\CropReportController::class,'subseedcost']);
Route::get('subplantinglabourcosts/{id}',[API\CropReportController::class,'subplantinglabour']);
Route::get('subplantinglabourused/{id}',[API\CropReportController::class,'subplantinglabourused']);
Route::get('subprevalentfertilizer/{id}',[API\CropReportController::class,'subprevfertilizer']);
Route::get('subweedingcosts/{id}',[API\CropReportController::class,'subweedingcost']);
Route::get('subchemicalcosts/{id}',[API\CropReportController::class,'subchemicalcost']);
Route::get('subtoolcosts/{id}',[API\CropReportController::class,'subtoolcost']);
Route::get('subweedinglabourcosts/{id}',[API\CropReportController::class,'subweedinglabour']);
Route::get('subweedinglabourused/{id}',[API\CropReportController::class,'subweedinglabourused']);
Route::get('subprevalentchemical/{id}',[API\CropReportController::class,'subprevchemical']);
Route::get('subcosts/{id}',[API\CropReportController::class,'subcost']);
Route::get('subacreageplanted/{id}',[API\CropReportController::class,'subplanted']);
Route::get('subacreageweeded/{id}',[API\CropReportController::class,'subweeded']);
Route::get('subharvestingcosts/{id}',[API\CropReportController::class,'subharvestcost']);
Route::get('subacreageharvested/{id}',[API\CropReportController::class,'subharvested']);
Route::get('subharvestinglabourused/{id}',[API\CropReportController::class,'subharvestinglabourused']);
Route::get('subprevalenttransportmeans/{id}',[API\CropReportController::class,'subprevtransportmeans']);
Route::get('subtransportcosts/{id}',[API\CropReportController::class,'subtransportcost']);
Route::get('subharvestinglabourcosts/{id}',[API\CropReportController::class,'subharvestinglabour']);
Route::get('cashcosts/{id}',[API\CropReportController::class,'cashcost']);
Route::get('cashsales/{id}',[API\CropReportController::class,'cashsale']);
Route::get('cashplantingcosts/{id}',[API\CropReportController::class,'cashplantingcost']);
Route::get('cashfertilizercosts/{id}',[API\CropReportController::class,'cashfertilizercost']);
Route::get('cashseedcosts/{id}',[API\CropReportController::class,'cashseedcost']);
Route::get('cashplantinglabourcosts/{id}',[API\CropReportController::class,'cashplantinglabour']);
Route::get('cashplantinglabourused/{id}',[API\CropReportController::class,'cashplantinglabourused']);
Route::get('cashprevalentfertilizer/{id}',[API\CropReportController::class,'cashprevfertilizer']);
Route::get('cashweedingcosts/{id}',[API\CropReportController::class,'cashweedingcost']);
Route::get('cashchemicalcosts/{id}',[API\CropReportController::class,'cashchemicalcost']);
Route::get('cashtoolcosts/{id}',[API\CropReportController::class,'cashtoolcost']);
Route::get('cashweedinglabourcosts/{id}',[API\CropReportController::class,'cashweedinglabour']);
Route::get('cashweedinglabourused/{id}',[API\CropReportController::class,'cashweedinglabourused']);
Route::get('cashprevalentchemical/{id}',[API\CropReportController::class,'cashprevchemical']);
Route::get('cashacreageplanted/{id}',[API\CropReportController::class,'cashplanted']);
Route::get('cashacreageweeded/{id}',[API\CropReportController::class,'cashweeded']);
Route::get('cashacreageharvested/{id}',[API\CropReportController::class,'cashharvested']);
Route::get('cashharvestingcosts/{id}',[API\CropReportController::class,'cashharvestcost']);
Route::get('cashharvestinglabourused/{id}',[API\CropReportController::class,'cashharvestinglabourused']);
Route::get('cashprevalenttransportmeans/{id}',[API\CropReportController::class,'cashprevtransportmeans']);
Route::get('cashtransportcosts/{id}',[API\CropReportController::class,'cashtransportcost']);
Route::get('cashharvestinglabourcosts/{id}',[API\CropReportController::class,'cashharvestinglabour']);
Route::get('subcashcosts/{id}',[API\CropReportController::class,'subcashcost']);
Route::get('subcashplantingcosts/{id}',[API\CropReportController::class,'subcashplantingcost']);
Route::get('subcashfertilizercosts/{id}',[API\CropReportController::class,'subcashfertilizercost']);
Route::get('subcashseedcosts/{id}',[API\CropReportController::class,'subcashseedcost']);
Route::get('subcashplantinglabourcosts/{id}',[API\CropReportController::class,'subcashplantinglabour']);
Route::get('subcashplantinglabourused/{id}',[API\CropReportController::class,'subcashplantinglabourused']);
Route::get('subcashprevalentfertilizer/{id}',[API\CropReportController::class,'subcashprevfertilizer']);
Route::get('subcashweedingcosts/{id}',[API\CropReportController::class,'subcashweedingcost']);
Route::get('subcashchemicalcosts/{id}',[API\CropReportController::class,'subcashchemicalcost']);
Route::get('subcashtoolcosts/{id}',[API\CropReportController::class,'subcashtoolcost']);
Route::get('subcashweedinglabourcosts/{id}',[API\CropReportController::class,'subcashweedinglabour']);
Route::get('subcashweedinglabourused/{id}',[API\CropReportController::class,'subcashweedinglabourused']);
Route::get('subcashprevalentchemical/{id}',[API\CropReportController::class,'subcashprevchemical']);
Route::get('subcashsales/{id}',[API\CropReportController::class,'subcashsale']);
Route::get('subcashacreageplanted/{id}',[API\CropReportController::class,'subcashplanted']);
Route::get('subcashacreageweeded/{id}',[API\CropReportController::class,'subcashweeded']);
Route::get('subcashacreageharvested/{id}',[API\CropReportController::class,'subcashharvested']);
Route::get('subcashharvestingcosts/{id}',[API\CropReportController::class,'subcashharvestcost']);
Route::get('subcashharvestinglabourused/{id}',[API\CropReportController::class,'subcashharvestinglabourused']);
Route::get('subcashprevalenttransportmeans/{id}',[API\CropReportController::class,'subcashprevtransportmeans']);
Route::get('subcashtransportcosts/{id}',[API\CropReportController::class,'subcashtransportcost']);
Route::get('subcashharvestinglabourcosts/{id}',[API\CropReportController::class,'subcashharvestinglabour']);
Route::get('generalcosts',[API\CropReportController::class,'generalcost']);
Route::get('plantingcosts',[API\CropReportController::class,'plantcost']);
Route::get('fertilizercosts',[API\CropReportController::class,'fertilizercost']);
Route::get('seedcosts',[API\CropReportController::class,'seedcost']);
Route::get('plantinglabourcosts',[API\CropReportController::class,'plantinglabour']);
Route::get('plantingmisccosts',[API\CropReportController::class,'plantingmisc']);
Route::get('acreageplanted',[API\CropReportController::class,'acreplanted']);
Route::get('plantinglabourused',[API\CropReportController::class,'plantinglabourused']);
Route::get('prevalentfertilizer',[API\CropReportController::class,'prevfertilizer']);
Route::get('weedingcosts',[API\CropReportController::class,'weedcost']);
Route::get('chemicalcosts',[API\CropReportController::class,'chemicalcost']);
Route::get('toolcosts',[API\CropReportController::class,'toolcost']);
Route::get('weedinglabourcosts',[API\CropReportController::class,'weedinglabour']);
Route::get('weedingmisccosts',[API\CropReportController::class,'weedingmisc']);
Route::get('acreageweeded',[API\CropReportController::class,'acreweeded']);
Route::get('weedinglabourused',[API\CropReportController::class,'weedinglabourused']);
Route::get('prevalentchemical',[API\CropReportController::class,'prevchemical']);
Route::get('harvestingcosts',[API\CropReportController::class,'harvestcost']);
Route::get('acreageharvested',[API\CropReportController::class,'acreharvested']);
Route::get('harvestinglabourused',[API\CropReportController::class,'harvestinglabourused']);
Route::get('prevalenttransportmeans',[API\CropReportController::class,'prevtransportmeans']);
Route::get('transportcosts',[API\CropReportController::class,'transportcost']);
Route::get('harvestinglabourcosts',[API\CropReportController::class,'harvestinglabour']);
Route::get('harvestingmisccosts',[API\CropReportController::class,'harvestingmisc']);
Route::get('cropharvest',[API\CropReportController::class,'cropharvest']);
Route::get('subcashcropharvest',[API\CropReportController::class,'subcashcropharvest']);

Route::get('domesticfeedingcosts/{id}',[API\AnimalReportController::class,'domesticfeedingcost']);
Route::get('domestictreatingcosts/{id}',[API\AnimalReportController::class,'domestictreatingcost']);
Route::get('pettotalcosts/{id}',[API\AnimalReportController::class,'petcost']);
Route::get('petfeedingcosts/{id}',[API\AnimalReportController::class,'petfeedingcost']);
Route::get('pettreatingcosts/{id}',[API\AnimalReportController::class,'pettreatingcost']);
Route::get('animalcosts',[API\AnimalReportController::class,'animalcost']);
Route::get('animalsales',[API\AnimalReportController::class,'animalsale']);

Route::get('gradefeedingcosts/{id}',[API\PoultryReportController::class,'gradefeedingcost']);
Route::get('gradetreatingcosts/{id}',[API\PoultryReportController::class,'gradetreatingcost']);
Route::get('gradevaccinecosts/{id}',[API\PoultryReportController::class,'gradevaccinecost']);
Route::get('gradedrugcosts/{id}',[API\PoultryReportController::class,'gradedrugcost']);
Route::get('gradetotalcosts/{id}',[API\PoultryReportController::class,'gradetotalcost']);
Route::get('gradepoultrysales/{id}',[API\PoultryReportController::class,'gradepoultrysale']);
Route::get('kienyejifeedingcosts/{id}',[API\PoultryReportController::class,'kienyejifeedingcost']);
Route::get('kienyejitreatingcosts/{id}',[API\PoultryReportController::class,'kienyejitreatingcost']);
Route::get('kienyejivaccinecosts/{id}',[API\PoultryReportController::class,'kienyejivaccinecost']);
Route::get('kienyejidrugcosts/{id}',[API\PoultryReportController::class,'kienyejidrugcost']);
Route::get('kienyejitotalcosts/{id}',[API\PoultryReportController::class,'kienyejitotalcost']);
Route::get('kienyejipoultrysales/{id}',[API\PoultryReportController::class,'kienyejipoultrysale']);
Route::get('ikienyejifeedingcosts/{id}',[API\PoultryReportController::class,'ikienyejifeedingcost']);
Route::get('ikienyejitreatingcosts/{id}',[API\PoultryReportController::class,'ikienyejitreatingcost']);
Route::get('ikienyejivaccinecosts/{id}',[API\PoultryReportController::class,'ikienyejivaccinecost']);
Route::get('ikienyejidrugcosts/{id}',[API\PoultryReportController::class,'ikienyejidrugcost']);
Route::get('ikienyejitotalcosts/{id}',[API\PoultryReportController::class,'ikienyejitotalcost']);
Route::get('ikienyejipoultrysales/{id}',[API\PoultryReportController::class,'ikienyejipoultrysale']);
Route::get('exoticfeedingcosts/{id}',[API\PoultryReportController::class,'exoticfeedingcost']);
Route::get('exotictreatingcosts/{id}',[API\PoultryReportController::class,'exotictreatingcost']);
Route::get('exoticvaccinecosts/{id}',[API\PoultryReportController::class,'exoticvaccinecost']);
Route::get('exoticdrugcosts/{id}',[API\PoultryReportController::class,'exoticdrugcost']);
Route::get('exotictotalcosts/{id}',[API\PoultryReportController::class,'exotictotalcost']);
Route::get('exoticpoultrysales/{id}',[API\PoultryReportController::class,'exoticpoultrysale']);
Route::get('hybridfeedingcosts/{id}',[API\PoultryReportController::class,'hybridfeedingcost']);
Route::get('hybridtreatingcosts/{id}',[API\PoultryReportController::class,'hybridtreatingcost']);
Route::get('hybridvaccinecosts/{id}',[API\PoultryReportController::class,'hybridvaccinecost']);
Route::get('hybriddrugcosts/{id}',[API\PoultryReportController::class,'hybriddrugcost']);
Route::get('hybridtotalcosts/{id}',[API\PoultryReportController::class,'hybridtotalcost']);
Route::get('hybridpoultrysales/{id}',[API\PoultryReportController::class,'hybridpoultrysale']);
Route::get('feedingcosts',[API\PoultryReportController::class,'feedingcost']);
Route::get('feedcosts',[API\PoultryReportController::class,'feedcost']);
Route::get('feedingmisccosts',[API\PoultryReportController::class,'feedingmisccost']);
Route::get('treatingcosts',[API\PoultryReportController::class,'treatingcost']);
Route::get('vaccinecosts',[API\PoultryReportController::class,'vaccinecost']);
Route::get('drugcosts',[API\PoultryReportController::class,'drugcost']);
Route::get('treatingmisccosts',[API\PoultryReportController::class,'treatingmisccost']);
Route::get('poultryfed',[API\PoultryReportController::class,'poultryfed']);
Route::get('poultryvaccinated',[API\PoultryReportController::class,'poultryvaccinated']);
Route::get('poultrytreated',[API\PoultryReportController::class,'poultrytreated']);
Route::get('prevalentvaccine',[API\PoultryReportController::class,'prevvaccine']);
Route::get('prevalentdrug',[API\PoultryReportController::class,'prevdrug']);

Route::get('poultrycosts',[API\PoultryReportController::class,'poultrycost']);
Route::get('poultrysales',[API\PoultryReportController::class,'poultrysale']);

Route::get('allcosts',[API\OverallReportController::class,'allcost']);
Route::get('allsales',[API\OverallReportController::class,'allsale']);
Route::get('allproduced',[API\OverallReportController::class,'allproduce']);
Route::get('allcropsales',[API\OverallReportController::class,'cropsale']);
Route::get('allcropcosts',[API\OverallReportController::class,'cropcost']);
Route::get('allanimalsales',[API\OverallReportController::class,'animalsale']);
Route::get('allanimalcosts',[API\OverallReportController::class,'animalcost']);
Route::get('allpoultrysales',[API\OverallReportController::class,'poultrysale']);
Route::get('allpoultrycosts',[API\OverallReportController::class,'poultrycost']);
Route::get('allresourcesales',[API\OverallReportController::class,'resourcesale']);
Route::get('allresourcecosts',[API\OverallReportController::class,'resourcecost']);
Route::get('allmisccosts',[API\OverallReportController::class,'misccost']);

Route::post('changestatus/{id}',[API\CropSaleController::class,'changestatus']);
