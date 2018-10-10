function toggle(FormName, FieldName, CheckValue) {
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckboxes.checked = CheckValue;
	else
		for(var i = 0; i < countCheckBoxes; i++)
		objCheckBoxes[i].checked = CheckValue;
	}






