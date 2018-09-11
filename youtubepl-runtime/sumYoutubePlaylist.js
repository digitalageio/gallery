var timestamps = document.getElementsByClassName('timestamp'), i, total = 0;

for(i in timestamps){
    if(timestamps[i].firstChild){
        var time = timestamps[i].children[0].innerHTML.split(":").reverse();
        time.forEach(function(e, i){
            total += parseInt(e) * Math.pow(60, i);
        });
    }
}

parseFloat((total/3600).toFixed(2));