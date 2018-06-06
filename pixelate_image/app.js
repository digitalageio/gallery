window.onload = function() {
var	ctx = canvas.getContext('2d');
	img = new Image();
	play = false;

ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false;

img.onload = pixelate;

img.src = '/gallery/pixelate/smiling_elfman.jpg';

function pixelate(v) {
	var size = (play ? v : intensity.value) * 0.01,
		w = canvas.width * size,
		h = canvas.height * size;

	ctx.drawImage(img, 0, 0, w, h);
	ctx.drawImage(canvas, 0, 0, w, h, 0, 0, canvas.width, canvas.height);
}

function toggleAnimation() {
	var v = Math.min(25, parseInt(intensity.value, 10)),
		dx = 0.05;

	play = !play;
	animate.value = play ? 'Stop' : 'Start';
	if(play === true) anim();

	function anim() {
		v += dx;
		if(v <= 1 || v > 25) dx = -dx;
		pixelate(v);
		intensity.value = v;
		if(play === true) requestAnimationFrame(anim);
	}
}

intensity.addEventListener('change', pixelate, false);
animate.addEventListener('click', toggleAnimation, false);

window.requestAnimationFrame = (function() {
	return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || function (callback) {
		window.setTimeout(callback, 1000 / 60);
	};
})();

};
