var base_radius = 247;
var radius = 247;
var time = 250;
var current_piece_num = 0;

var anchor_map = {
	"Something": 1,
}

var piece_angles = {
	1:{
		"start_angle":"54",
		"end_angle":"126"
	},
	2:{
		"start_angle":"127",
		"end_angle":"199"
	},
	3:{
		"start_angle":"200",
		"end_angle":"272"
	},
	4:{
		"start_angle":"273",
		"end_angle":"345"
	},
	5:{
		"start_angle":"346",
		"end_angle":"53"
	}
}


var css_original = {
	1:{
		"width":"291",
		"height":"247",
		"top":"125",
		"left":"217",
		"z-index":"10"
	},
	2:{
                "width":"246",
                "height":"277",
                "top":"174",
                "left":"367",
                "z-index":"20"     
        },
        3:{
                "width":"264",
                "height":"247",
                "top":"380",
                "left":"363",
                "z-index":"30"
        },
        4:{
                "width":"235",
                "height":"247",
                "top":"380",
                "left":"124",
                "z-index":"40"
        },
        5:{
                "width":"246",
                "height":"278",
                "top":"174",
                "left":"111",
                "z-index":"50"
        }

};

var css_larger = {
        1:{
                "width":"388",
                "height":"329",
                "top":"40",
                "left":"166",
                "z-index":"10"
        },
        2:{
                "width":"329",
                "height":"369",
                "top":"109",
                "left":"364",
                "z-index":"20"
        },
        3:{
                "width":"350",
                "height":"329",
                "top":"381",
                "left":"361",
                "z-index":"30"
        },
        4:{
                "width":"313",
                "height":"328",
                "top":"381",
                "left":"42",
                "z-index":"40"
        },
        5:{
                "width":"329",
                "height":"370",
                "top":"106",
                "left":"25",
                "z-index":"50"
        }
};

function initialPopup(){
	for(var i=1;i<=5;i++){
		expandPiece(i);
	}
	setTimeout(function(){
		closeAll();
		setTimeout(function(){
			var p = anchorPiece();
			if(p > 0 && p < 6){
			expandPiece(p);
			}
		},750);
	},200);
}

function anchorPiece(){
	var url = document.URL;
	var anchor = url.split("#")[1];
	return anchor_map[anchor];
}

function inPiece(r,center_X,center_Y,mouse_X,mouse_Y){
	var difference_X = center_X - mouse_X;
	var difference_Y = center_Y - mouse_Y;
    	var distance = Math.sqrt((Math.pow(difference_X,2))+(Math.pow(difference_Y,2)));
    	var radians = Math.atan2(difference_Y,difference_X);
	var degrees = radians * (180/Math.PI);
	if(degrees < 0){
		degrees += 360;
	}
	for(var i=1;i<=4;i++){
			if(distance <= r && distance > 194){
				if(degrees > piece_angles[i].start_angle && degrees < piece_angles[i].end_angle){
					return i;
				} else if(degrees > 346 || degrees < 53){ 
					return 5;
				}
			} else return 0;
	}
}

function expandPiece(num,ratio){
	var n = num.toString();
        jQuery(".piece" + n).stop().animate({
        	width: css_larger[num].width + "px",
        	height: css_larger[num].height + "px",
        	top: css_larger[num].top + "px",
        	left: css_larger[num].left + "px",
        },time,function(){
				jQuery(".piece" + n).css("overflow","visible");
				jQuery(".piece" + n).children(".content").css("display","block");
				jQuery(".piece" + n).children(".content").stop().animate({
                			opacity:0.85
						},time);
				});
}

function closeAll(){
	var i = 1;
	for(i=1;i<=5;i++){				
		jQuery(".piece" + i).children(".content").stop().animate({
                					opacity:0.01
								},time);
        					jQuery(".piece" + i).stop().animate({
        						width: css_original[i].width + "px",
        						height: css_original[i].height + "px",
        						top: css_original[i].top + "px",
        						left: css_original[i].left + "px"
        					},time);
	}
}

jQuery(window).load(function(){
	var X = jQuery(".center").offset().left + jQuery(".center").width()/2;
	var Y = jQuery(".center").offset().top + jQuery(".center").height()/2;
	
	initialPopup();
	
	jQuery(".splashWrapper").mousemove(function(event){
		if(current_piece_num > 0){
		var c = current_piece_num.toString();
		var hovering = jQuery(".piece" + c).children(".content").is(":hover");
		}	
		if(!hovering){
			var piece_num = inPiece(radius,X,Y,event.pageX,event.pageY);
			if(piece_num != current_piece_num){
				current_piece_num = piece_num;
				closeAll();
				radius = base_radius;
				if(current_piece_num > 0){
					expandPiece(piece_num);
				}
			} else if(piece_num === current_piece_num && piece_num > 0){
						radius = 330;
					} 
		}
		
	});
});
