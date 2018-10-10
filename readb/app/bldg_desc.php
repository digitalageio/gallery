<?php
//include('loginvars.php');

print "<!DOCTYPE='html'>";
$choices = array();

$names = array('pri','sec','gen','spe');
foreach($names as $p => $u){
if(!empty($_POST[$names[$p]])){
	$choices[$names[$p]] = $_POST[$names[$p]];
}
}

$identifiers = array(
		'Improved' => array(
					'Residential' => array(
								'Condos' => 'Condos',
								'2+ Family Housing' => '2+ Family Housing',
								'House' => 'House'
								),
					'Commercial' => array(
								'Apartments' => array(
											'Multi-family' => 'Multi-family',
											'5+ Units' => '5+ Units'
											),
								'Auto Sales' => array(
											'Used Car Lots' => 'Used Car Lots',
											'Auto Dealerships' => 'Auto Dealerships'
											),
								'Billboards' => 'Billboards',
								'Carwashes' => array(
											'Automated' => 'Automated',
											'Self-serve' => 'Self-serve',
											'Mixed' => 'Mixed'
											),
								'Churches' => 'Churches',
								'C-stores' => 'C-stores',
								'Educational' => array(
											'Daycare' => 'Daycare',
											'Schools' => 'Schools'
											),
								'Entertainment' => 'Entertainment',
								'Funeral Homes' => 'Funeral Homes',
								'Health Care' => array(
											'Hospitals' => 'Hospitals',
											'Assisted Living' => 'Assisted Living',
											'Nursing Homes' => 'Nursing Homes'
											),
								'Lodging' => 'Lodging',
								'Mobile Home Parks' => 'Mobile Home Parks',
								'Offices' => array(
											'Multi-tenant' => 'Multi-tenant',
											'Office Freestanding' => 'Office Freestanding',
											'Medical' => 'Medical',
											'House Converted' => 'House Converted'
											),
								'Restaurant' => array(
											'Fast Food' => 'Fast Food',
											'Full Service' => 'Full Service'
											),
								'Retail' => array(
											'Retail Freestanding' => 'Retail Freestanding',
											'Multi-tenant' => 'Multi-tenant',
											'Warehouse Sales' => 'Warehouse Sales'
											),
								'Subdivisions' => array(
											'Residential Lots' => 'Residential Lots',
											'Residential Houses' => 'Residential Houses',
											'Condos' => 'Condos',
											'Commercial Lots' => 'Commercial Lots',
											'Commercial Improved' => 'Commercial Improved'
											),
								'Warehouses' => array(
											'Industrial' => 'Industrial',
											'Mini Storage' => 'Mini Storage'
											),
								),
					),
		'Vacant' => array(
					'Residential' => array(
								'Lots' => 'Lots',
								'Acreage' => 'Acreage'
								),
					'Commercial' => 'Commercial'
				),
		);

print "<select id='pri' onchange=\"changei()\">";
	foreach(array_keys($identifiers) as $ooms => $day){
	if($day == $_POST['pri']){
	print "<option selected='selected'>" . $day . "</option>";
	} else print "<option>" . $day . "</option>";
	}
print "</select>";
foreach($choices as $ey => $alue){
	switch($ey){
		case 'pri':
			if(is_array($identifiers[$choices['pri']])){
			print "<select id='sec' onchange=\"changei()\">";
			foreach(array_keys($identifiers[$choices['pri']]) as $ooms => $day){
			if($day == $_POST['sec']){
			print "<option selected='selected'>" . $day . "</option>";
			} else print "<option>" . $day . "</option>";
			}
			print "</select>";
			}
		break;
		case 'sec':
			if(is_array($identifiers[$choices['pri']][$choices['sec']])){
			print "<select id='gen' onchange=\"changei()\">";
			foreach(array_keys($identifiers[$choices['pri']][$choices['sec']]) as $ooms => $day){
			if($day == $_POST['gen']){
			print "<option selected='selected'>" . $day . "</option>";
			} else print "<option>" . $day . "</option>";
			}
			print "</select>";
			}
		break;
		case 'gen':
			if(is_array($identifiers[$choices['pri']][$choices['sec']][$choices['gen']])){
			print "<select id='spe' onchange=\"changei()\">";
			foreach(array_keys($identifiers[$choices['pri']][$choices['sec']][$choices['gen']]) as $ooms => $day){
			if($day == $_POST['spe']){
			print "<option selected='selected'>" . $day . "</option>";
			} else print "<option>" . $day . "</option>";
			}
			print "</select>";
			}
		break;
		default:
		break;
	}
	}

			
?>
