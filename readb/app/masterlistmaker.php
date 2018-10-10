<?php
 
$propertytemplate = array('PropertyAddress','Subdivision','County','Name','MailingAddress','PropertyType','LandUse','ImprovementType','SquareFeet','ParcelTaxID','SpecialInt','AlternateParcelID','LandMap','DistrictWard','CensusTractBlock');

$salestemplate = array('DateOf','Amount','BuyersOwners','BuyersOwners2','Instrument','Quality','BookPageorDocument');

$taxestemplate = array('TaxYear','CityTaxes','AppraisedLand','CountyTaxes','AppraisedImprovements','TotalTaxes','TotalTaxAppraisal','ExemptAmount','TotalAssessment','ExemptReason');

$mortgagetemplate = array('','DateOf','LoanAmount','Lender','Borrower','BookPageorDocument');

$featuretemplate = array('Feature','SizeorDescription','YearBuilt','Cond');

$lottemplate = array('LotDimensions','BlockLot','LotSquareFeet','LatitudeLongitude','Acreage');

$utilitytemplate = array('GasSource','RoadType','ElectricSource','Topography','WaterSource','DistrictTrend','SewerSource','SpecialSchoolDistrict1','OwnerType','PlatBookPage','Description');

$buildingtemplate = array('Type','Cond','SqFeet','YearBuilt','EffectiveYear','BRs','Baths','Rooms','Stories','Units','FirstStoryBase','FirstBaseStorySemifinished','Basementfinished','1','2','3','OpenPorchfinished','UpperStoryLow','Quality','RoofFraming','Shape','RoofCoverDeck','Partitions','CabinetMillwork','CommonWall','FloorFinish','Foundation','InteriorFinish','FloorSystem','AirConding','ExteriorWall','HeatType','StructuralFraming','BathroomTile','Fireplace','PlumbingFixtures','Occupancy','BuildingDataSource','AttachedGarage','ScreenedinPorchfinished');

$section = array();
$section[0] = implode(',',$propertytemplate);
$section[1] = repeater($salestemplate,20,"Sale");
$section[2] = implode(',',$taxestemplate);
$section[3] = repeater($mortgagetemplate,20,"Mortgage");
$section[4] = repeater($featuretemplate,50,"Feature");
$section[5] = implode(',',$lottemplate);
$section[6] = implode(',',$utilitytemplate);
$section[7] = repeater($buildingtemplate,15,"Bldg");

$protolist = implode(',',$section);
$protolist = explode(',',$protolist);
//var_dump($protolist);

?>

<?php 

function repeater($template,$count,$prefix){
	$fin = NULL;
	$durr = array();
	$temp = $template;
	$q = 0;
	for($q=0;$q<$count;$q++){
		foreach($temp as $key => $value){
			$durr[$key] = $prefix . $q . "_" . $temp[$key];
		}
	$durr = implode(',',$durr) . ',';
	$fin .= $durr;
	$durr = NULL;
	}
//var_dump($final);
return $fin;
}

?>
