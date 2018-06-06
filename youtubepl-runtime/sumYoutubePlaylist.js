var timestamps = document.getElementsByTagName('div'), i, total = 0;

for(i in timestamps){
	if(timestamps[i].className === 'timestamp'){
		total = total + parseInt(timestamps[i].children[0].innerHTML.split(":")[0]);
	}
}

console.log((total/60).toFixed(2));