<?php 
include('defaultcreds.php');
$gg = mysql_query("SELECT tax_map,grp,parcnum1,parcnum2,spec_int,super_id FROM parcels WHERE CONCAT(tax_map,grp,parcnum1,parcnum2,spec_int) = '{$_POST['parcel']}'");
$g = mysql_fetch_assoc($gg);
$fin = $g['tax_map'] . " " . $g['grp'] . " " . $g['parcnum1'] . "." . $g['parcnum2'] . " SI " . $g['spec_int'];
print $fin;
?>
