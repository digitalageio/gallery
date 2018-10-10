<?php
//include('loginvars.php');
?>

<!DOCTYPE html>
<html = xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta charset="UTF-8" />
	<title>Parcel Description</title>
<script type="text/javascript" src="jquery.min.js" language="javascript"></script>
<script type="text/javascript" language="javascript">
	var select = $('#idname').serializeArray();

	function showCreate(){
		document.getElementById('create').style.display="block";
		document.getElementById('next').style.display="none";
	}

	function id_check(x){
			var pieces = new Array();
			var piece = document.getElementById(x).value;
			pieces.push({ name: x, value: piece });
			console.debug(pieces);
		$.ajax({
				url: './id_check.php',
				type: 'POST',
				dataType: "html",
				data: pieces,
				success: function (returned){
					docid = x + "_check";
					docidvar = document.getElementById(docid);
					alert(returned);
					if(returned){
						docidvar.innerHTML = "&#10003";
						docidvar.color = "green";
					} else {
						docidvar.innerHTML = "&#10007";
						docidvar.color = "red";
					}
					}
			})
	}	
						
				
				
		
	function changei(){
		select = $('#idname').serializeArray();
		if(document.getElementById('pri')){
			var p = document.getElementById('pri');
			var primary = p.options[p.selectedIndex].value;
			select.push({ name: 'pri', value: primary });
		}
		if(document.getElementById('sec')){
			var s = document.getElementById('sec');
			var secondary = s.options[s.selectedIndex].value;
			select.push({ name: 'sec', value: secondary });
		}
		if(document.getElementById('gen')){
			var ge = document.getElementById('gen');
			var generic = ge.options[ge.selectedIndex].value;
			select.push({ name: 'gen', value: generic });
		}
		if(document.getElementById('spe')){
			var sp = document.getElementById('spe');
			var specific = sp.options[sp.selectedIndex].value;
			select.push({ name: 'spe', value: specific });
		} 
		$.ajax({
				url: './bldg_desc.php',
				type: 'POST',
				dataType: "html",
				data: select,
				success: function (lists){
					$('#lists').html(lists);
				}
			}) 
	}

	function createNew(){
		$.ajax({
				url: './createNew.php',
				type: 'POST',
				dataType: "html",
				data: select,
				success: function (newparc){
					$('#success').html(newparc);
				}
		})
	}			
</script>
</head>
<form enctype="multipart/form-data" method="POST" id="idname">
Tax Map: <input type="text" id="tax_map" name="tax_map" size="4" onchange="id_check('tax_map')" />  <font color="red" id="tax_map_check">&#10007</font><br />
<i>ex: "001","119A"</i><br />
<br />
Group: <input type="text" id="grp" name="grp" size="2" onchange="id_check('grp')" />  <font id="grp_check" color="red">&#10007</font><br />
<i>ex: "K"</i><br />
<br />
Parcel Number: <input type="text" id="parcnum1" name="parcnum1" size="3" onchange="id_check('parcnum1')" >.<input type="text" id="parcnum2" name="parcnum2" size="2" onchange="id_check('parcnum2')" />  <font color="red" id="parcnum1_check">&#10007</font>.<font color="red" id="parcnum2_check">&#10007</font><br />
<i>ex: "011.25","007.00"</i><br />
<br />
Special Interest<sup>*</sup>: SI <input type="text" id="spec_int" name="spec_int" size="3" onchange="id_check('spec_int')" />  <font id="spec_int_check" name="spec_int_check" color="red"></font><br />
<i>ex: "005","339"</i><br />
<br />
Name<sup>*</sup>: <input type="text" id="name" name="name" size="30" /><br />
<input type="button" id="next" value="Next" onclick="changei();showCreate()" />
</form>
<p id="lists">
</p>
<input id="create" style="display:none" type="button" value="Create" onclick="createNew()" /><br />
<sup>*</sup><i>optional values</i>
<p id="success">
</p>
