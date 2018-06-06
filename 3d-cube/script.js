window.addEventListener('keydown', onKeyDown, true);
window.addEventListener('keyup', onKeyUp, true);

var code = false;
var percent = null;
var currentPercent = 0;

window.onload = function(){
	var stringPrefix = prefix.css;
	if(stringPrefix == "-ms-"){
		console.log('ms');
		document.getElementById("css-prefix").innerHTML = '-ms-   note: "transform-style: preserve-3d" is currently unsupported in IE';
	} else document.getElementById("css-prefix").innerHTML = prefix.css;
};

function onKeyDown(event){
		if(code !== event.keyCode && !code){
			code = event.keyCode;
			switch(code) {
				case 37:
					document.getElementById("cube").className += " spinLeft infinite";
				break;
				case 38:
					document.getElementById("cube").className += " vertical infinite";
					document.getElementById("cube").className += " spinUp infinite";
				break;
				case 39:
					document.getElementById("cube").className += " spinRight infinite";
				break;
				case 40:
					document.getElementById("cube").className += " vertical infinite";
					document.getElementById("cube").className += " spinDown infinite";
				break;
				default:
			}
			percent = null;
			currentPercent = 0;
			startInterval();
		}
}

function onKeyUp(event){
	document.getElementById("cube").className = "cube";
	document.getElementById("percent-indicator").innerHTML = currentPercent;
	//keyframeReverse();
	stopInterval();
	code = false;
}

function startInterval(){
	currentPercent = 0;
	percent = setInterval(function(){
		if(currentPercent < 100){
			currentPercent += 1;
		} else {
			currentPercent = 0;
		}
	}, 30);
	return percent;
}


function stopInterval(){
	clearInterval(percent);
	percent = null;
	currentPercent = 0;
}

var prefix = (function(){
	var i;
	var styles = window.getComputedStyle(document.documentElement,''),
		pre = (Array.prototype.slice
			.call(styles)
			.join('')
			.match(/-(moz|webkit|ms)-/) || (styles.OLink === '' && ['', 'o'])
		)[1],
		dom = ('Webkit|Moz|MS|O').match(new RegExp('(' + pre + ')','i'))[i];
	return {
		dom: dom,
		lowercase: pre,
		css: '-' + pre + '-',
		js: pre[0].toUpperCase() + pre.substr(1)
	};
})();


var stylesheet = document.stylesheets
;
/*
var reverseKeyframesRule = stylesheet.cssRules[0];
	var reverseKeyframesRule_From = reverseKeyframesRule.cssRules[0];
	var reverseKeyframesRule_To = reverseKeyframesRule.cssRules[1];
*/
function keyframeReverse(){
	var calcKeyframe = Math.floor(3.6 * currentPercent);
	var reverseKeyframes = {
		37: { from: 'rotateY(-' + calcKeyframe + 'deg)', to: 'rotateY(0)' },
		38: { from: 'rotateX(' + calcKeyframe + 'deg)', to: 'rotateX(0)' },
		39: { from: 'rotateY(' + calcKeyframe + 'deg)', to: 'rotateY(0)' },
		40: { from: 'rotateX(-' + calcKeyframe + 'deg)', to: 'rotateX(0)' }
	};
	reverseKeyframesRule_From.style.setProperty(prefix.css + 'transform', reverseKeyframes[code]['from']);
		reverseKeyframesRule_From.style.setProperty('transform', reverseKeyframes[code]['from']);
	reverseKeyframesRule_To.style.setProperty(prefix.css + 'transform', reverseKeyframes[code]['to']);
		reverseKeyframesRule_To.style.setProperty('transform', reverseKeyframes[code]['to']);
	if(code == 38 || code == 40 ){
		document.getElementById("cube").className = "cube vertical reverse";
	} else document.getElementById("cube").className = "cube reverse";
}