player = { x: 10, y: 10};
gs = tc = 20;
ax = ay = 15;
xv = yv = 0;
trail = [];
tail = 25; //75;
dframe = true;
frame = 0;
moves = 0;
//vars based on settings controls

//wrap global vars in re-initialize/retrieve function

//replace onload with gamestart event
window.onload = function(){
    canv = document.getElementById("snake-canvas");
    ctx = canv.getContext("2d");
    document.addEventListener("keydown", keyPush);
    run = setInterval( function() { game(); },1000/15);
}

function game(){
    ctx.fillStyle="black";
    ctx.fillRect(0,0,canv.width,canv.height);

    changeAcceleration(xv,yv);
    applyAcceleration(xv,yv);

    ctx.fillStyle="lime";
    for(var i = 0; i < trail.length; i++) {
        ctx.fillRect(trail[i].x*gs, trail[i].y*gs, gs-2, gs-2);
        if(trail[i].x === px && trail[i].y === py) {
            if(moves > 1){
                gameOver();
                console.log(trail);                         
            }
        }
        if(trail[i].x === ax && trail[i].y === ay) {
            if(i > 1){
                gameOver();
                console.log(trail);                         
            }
        }
    }               

    trail.push({ x: px, y: py });

    while(trail.length > tail) {
        trail.shift();
    }

    if(ax == px && ay == py){
        tail++;
        newApple();
        //apple tally ++
    }

    ctx.fillStyle="red";
    ctx.fillRect(ax*gs, ay*gs, gs-2, gs-2);

    frame++;
    dframe = true;

}

function newApple(){
    dax = day = 0;
    overlap = true;
    while(overlap){
        dax = Math.floor(Math.random() * tc);
        day = Math.floor(Math.random() * tc);
        for(var i = 0; i < trail.length; i++) {
            if(trail[i].x === dax && trail[i].y === day){
                break;
            }
            if(i === (trail.length - 1)){
                overlap = false;
            }
        }
    }
    ax = dax;
    ay = day;
    //need trail count win condition
    console.log(ax,ay,trail);               
}

function gameOver(){
    clearInterval(run);
    //writeScoreboard();
}

function writeScoreboard(){
    var http = new XMLHttpRequest();
    var url = "/writeScoreboard";
    var params = {
        length: trail.length,
        frames: frame,
    };
    http.open("POST", url, true);
    http.setRequestHeader("Content-type", "application/json");
    http.onreadystatechange = function(){
        if(http.readyState == 4 && http.status == 200){
            alert(http.responseText);
        }
    }
    http.send(JSON.stringify(params));
}

function applyAcceleration(dxv,dyv){
    if(dframe || acc){
        px += dxv;
        py += dyv;
    }
    dframe = false;
}

function changeAcceleration(dxv,dyv,acc=false){
    dpx = px + dxv;
    dpy = py + dyv;

    if(dpx < 0 || dpx > (tc - 1)){
        if(py <= tc/2){
            dxv = 0;
            dyv = 1;
        } else {
            dxv = 0;
            dyv = -1;
        }
    }

    if(dpy < 0 || dpy > (tc - 1)){
        if(px <= tc/2){
            dxv = 1;
            dyv = 0;
        } else {
            dxv = -1;
            dyv = 0;
        }
    }

    if(Math.abs(dxv) !== Math.abs(xv)){
        xv = dxv;
    }

    if(Math.abs(dyv) !== Math.abs(yv)){
        yv = dyv;
    }

}

function keyPush(evt){
    switch(evt.keyCode){
        case 37:
            changeAcceleration(-1,0);
                moves++;
            break;
        case 38:
            changeAcceleration(0,-1);
                moves++;
            break;
        case 39:
            changeAcceleration(1,0);
                moves++;
            break;
        case 40:
            changeAcceleration(0,1);
                moves++;
            break;
        case 32:
            clearInterval(run);
            break;
        default:
            break;
    }
}