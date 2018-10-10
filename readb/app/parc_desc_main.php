<!DOCTYPE = html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<meta http-equiv="content-type" content="text/html" />
<meta charset="UTF-8" />

<script src="jquery.min.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" language="javascript">
		var csel = new Array();
	function loadcategory(){
		csel = [];
		var cs = document.getElementById('categoryselect');
		var csval = cs.options[cs.selectedIndex].value;
		csel.push({ name: 'category', value: csval });
		$.ajax({	
				url:'./loadcategory.php',
				type: 'POST',	
				dataType: "html",
				data: csel,
				success: function (response){
					$('#categoryp').html(response);
					}
			})
	}

	function alterval(ind){	
		var psh = new Array();
		var con = "";
		var dastype = ind.attributes["type"].value;
		alert(dastype);
		if(dastype == "select"){
			alert("no else");
			con = ind.options[ind.selectedIndex];
			psh.push({ name: 'con', value: con.value });
			psh.push({ name: 'col', value: ind.attributes["name"].value });
			psh.push({ name: 'id', value: ind.attributes["class"].value });
		} 
		if(dastype == "text"){
			alert(ind.value);
			psh.push({ name: 'con', value: ind.value });
			psh.push({ name: 'col', value: ind.attributes["name"].value });
			psh.push({ name: 'id', value: ind.attributes["class"].value });
		}
		var tr = $(ind).closest('table')[0];
		psh.push({ name: 'tab', value: tr.attributes["name"].value });
		$.ajax({
				url:'./alterval.php',
				type: 'POST',
				dataType: "html",
				data: psh,
				success: function (hi){
					alert(hi);
					}
			})
	}

	function newval(){
		var nval = document.getElementById('newvalinput').value;
		csel.push({ name: 'newval', value: nval });
		$.ajax({
				url:'./newval.php',
				type: 'POST',
				dataType: "html",
				data: csel
			})
	}

	function multival(){
		$.ajax({
				url:'./valpush.php',
				type: 'POST',
				dataType: "html",
				data: val_id,
			});
		var vv = document.getElementById(choice);	
		openvals(vv);
	}

		var parcel = new Array();
	function loadtype(){
		parcel = [];
		var cparc = document.getElementById('parcselect');
		var curparc = cparc.options[cparc.selectedIndex].value;
		parcel.push({ name: 'parcel', value: curparc });
		var ffff = $(cparc).parent();
		$(ffff).nextAll().html("");
		$.ajax({
				url: './changetype.php',
				type: 'POST',
				dataType: "html",
				data: parcel,
				success: function (t){
					$('#typeselection').html(t);
					$('#opener').html("");
				}
			})
	}

		var choice;
		var area_id = new Array();
	function expandtype(x){
		choice = x.options[x.selectedIndex].value;
		area_id = [];
		var f = $(x).parent();
		area_id.push({ name: 'aid', value: choice });
		$(f).nextAll().html("");
		$.ajax({
				url: './expandtype.php',
				type: 'POST',
				dataType: "html",
				data: area_id,
				success: function (z){
					$(x).nextAll().html("");
					$('#typeselection').append(z);
					$('#opener').html("");
				}
			})
	}

		var val_id = Array();
		var cet = "";
	function openvals(y){
		cet = y.options[y.selectedIndex].value;
		val_id = [];
		val_id.push({ name: 'aid', value: choice });
		val_id.push({ name: 'vid', value: cet });
		$.ajax({
				url: './openvals.php',
				type: 'POST',
				dataType: "html",
				data: val_id,
				success: function (a){
					$('#opener').html(a);
				}
			})
		}

		var twostep = Array();
		var threestep = Array();
	function armaker(b){
		twostep = [];
		threestep = [];
		var jar = $(b).parent();
		twostep.push({ name: 'parent', value: b.name });
		var threestep = parcel.concat(twostep);
		if(b.value == '+'){
			b.value = '-';
			$.ajax({
				url: './armaker.php',
				type: 'POST',
				dataType: "html",
				data: threestep,
				success: function(g){
					jar.append(g);
					}
			})
		} else { 
			if (b.value == '-'){
			b.value = '+';
			$(b).nextAll().html("");
			}
		}
	}

	function adder(theb){
		var thef =  $(theb).parent();
		var prior = $(thef).parent();
		var wharr = $(prior).prev();
		var stuff = $(thef).serializeArray();
		$.ajax({
				url: 'adder.php',
				type: 'POST',
				dataType: "html",
				data: stuff,
			});
		$(wharr).children("select").change();
	}
	
	function valadder(j){
		if(j.value == '+'){
			j.value = '-';
			$('#columns').css("display","inline");
			$('#vlad').css("display","inline");
		} else {
			if(j.value == '-'){
				j.value = '+';
				$('#columns').css("display","none");
				$('#vlad').css("display","none");
			}
		}
	}

	function valpush(hmm){
		var co = document.getElementById('columns');
		var cho = co.options[co.selectedIndex].value;
		var prop = new Array();
		prop.push({ name: 'tab', value: cho });
		prop.push({ name: 'par', value: choice });
		$.ajax({
				url: 'valadder.php',
				type: 'POST',
				dataType: "html",
				data: prop,
				success: function(k){
					}
				})
	}

	function valmaker(val){
		if(val.value == 'Edit'){
			val.value = 'Done';
			$('#categorydiv').css("display","inline");
		} else {
			if(val.value == 'Done'){
				val.value = 'Edit';
				$('#categorydiv').css("display","none");
			}}
	}

	function tviewer(){
		$('#templatemaker').toggle();
		templar();
	}

	function cviewer(){
		$('#supermaker').toggle();
	}

	function tempc(){
		var tname = document.getElementById('newtempcolumn').value;
		$.ajax({
				url: 'tempc.php',
				type: 'POST',
				dataType: "html",
				data: ({ name: 'name', value: tname }),
				success: function(ff){
					templar();
					}
			})
	}

	function tempchange(ttt,x){
		var ttd = $(ttt).parent();
		var ttr = $(ttd).parent().children();
		var tti = $(ttd).parent().children().index(ttd);
		var tth = $(ttr).closest('table').find('th').eq(tti);
		var tmp = new Array();
		tmp.push({ name: 'ind', value: x });
		tmp.push({ name: 'val', value: ttt.value });
		tmp.push({ name: 'col', value: $(tth).attr("name") });
		$.ajax({
				url: 'tempchange.php',
				type: 'POST',
				dataType: "html",
				data: tmp,
				success: function(tt){
					templar();
					}
			})
	}

	function tempplus(ttt){
		var ttd = $(ttt).parent();
		var ttr = $(ttd).parent().children();
		var tti = $(ttd).parent().children().index(ttd);
		var tth = $(ttr).closest('table').find('th').eq(tti);
		var tmp = new Array();
		tmp.push({ name: 'val', value: ttt.value });
		tmp.push({ name: 'col', value: $(tth).attr("name") });
		$.ajax({
				url: 'newtempval.php',
				type: 'POST',
				dataType: "html",
				data: tmp,
				success: function(tt){
					alert(tt);
					templar();
					}
			})
	}

	function templar(){ 
		$.ajax({
				url: 'templar.php',
				type: 'POST',
				dataType: "html",
				success: function(go){
					$('#templatemaker').html(go);
				}
			})
	}	

	function supermaker(){
		var vars = $('#superform').serializeArray();
		$.ajax({
				url: 'supermaker.php',
				type: 'POST',
				dataType: "html",
				data: vars,
				success: function(sc){
					alert(sc);
					}
			})
	}

	function duptog(){
		$('#duplicate').toggle();
	}
	function duplication(){
		var ind = $('#allsec').attr("selectedIndex");
		var sec = $('#allsec option').eq(ind).attr("value");
		var count = $('#iterations').val();
		var park = $('#parcselect').val();
		$.ajax({
				url: './duplicate.php',
				type: 'POST',
				dataType: 'html',
				data: ({ 'sec': sec,'count': count, 'parc': park }),
				success: function(yy){
					alert(yy);
				}
		})
	}
</script>
<?php	
include('defaultcreds.php');
print"Current Parcel: <br />";
print"<select id='parcselect' name='parcselect' onchange=\"loadtype()\">";
print"<option></option>";
$dasq = mysql_query("SELECT tax_map,grp,parcnum1,parcnum2,spec_int,super_id FROM parcels");
$parcels = array();
	while($go = mysql_fetch_assoc($dasq)){
		array_push($parcels,$go);
	}
	foreach($parcels as $key => $value){
			print"<option value='" . array_pop($parcels[$key]) . "'>" . implode($parcels[$key]) . "</option>";
	}
print"</select><br />All Sections: <br /><input type='button' id='dup' value='Duplicate' onclick='duptog()' />";
print"<p id='duplicate' style='display:none'><input type='text' size='4' id='iterations' /><br />";
print"Warning: ensure that all variables are properly set before duplicating a section.<br />";
print"<input type='button' value='Copy Section' onclick='duplication()' /></p>";
?>

<?php

print"<div id='typeselection'></div>";
print"<div id='opener'></div>";
?>

<?php
print"<div id='categorydiv' style='display:none'>";
print"-------------------------------------------<br />";
print"Add to category<br />";
print"<select id='categoryselect' onchange=\"loadcategory()\">";
$pvals = mysql_query("SHOW COLUMNS FROM posvals");
$posvals = array();
	while($go = mysql_fetch_array($pvals)){
		array_push($posvals,$go);
	}
	print "<option></option>";
	foreach($posvals as $key => $value){
		if($posvals[$key][0]=='id'){
		} else print"<option>{$posvals[$key][0]}</option>";
	}
print"</select>";
print"<br />";
print"<input type='text' id='newvalinput' size='30'/>";
print"<input type='button' id='newvalenter' value='Add'onclick=\"newval();loadcategory()\" />";
print"<p id='categoryp'></p>";
print"</div>";
print"-------------------------------------------<br />";
print"<input type='button' id='cbutton' value='New Category' onclick='cviewer()' />";
print"<div id='supermaker' style='display:none'>";
print"<form enctype='multipart/form-data' id='superform' method='POST'>";
print"Category Name:<input name='newtable' type='text' size='30'><br />";
print"Datum: *check if freeform<br /> ";
print"<input name='col1' type='text' size='30'><input name='col1c' type='checkbox' value='col1' /><br />";
print"<input name='col2' type='text' size='30'><input name='col2c' type='checkbox' value='col2' /><br />";
print"<input name='col3' type='text' size='30'><input name='col3c' type='checkbox' value='col3' /><br />";
print"<input name='col4' type='text' size='30'><input name='col4c' type='checkbox' value='col4' /><br />";
print"<input name='col5' type='text' size='30'><input name='col5c' type='checkbox' value='col5' /><br />";
print"</form>";
print"<input type='button' name='addcat' value='Create' onclick='supermaker()'/><br />------------------------------------------<br />";
print"</div>";
print"<input type='button' id='tbutton' value='Templates' onclick='tviewer()' />";
print"<div id='templatemaker' style='display:none'>";
print"</div>";
?>



	
		


