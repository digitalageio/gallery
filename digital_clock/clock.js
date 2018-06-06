function Digit(element) {
    var self = this;
    self.element = element;
    self.on = [];
    self.off = [];
    self.prevValue = -1;

    for (var i = 0; i <= 9; i++) {
        self.on[i] = $(self.element).find('.d'+i);
        self.off[i] = $(self.element).find('.active.cell:not(.d'+i+')');
    }

    self.set = function(d) {
        if (self.prevValue == d) {
            return;
        }
        self.prevValue = d;
        self.on[d].css({'opacity': opacityOn});
        self.off[d].animate({opacity: opacityOff}, animateSpeed);
    };
}

function Circle(element, width) {
    var self = this;
    self.element = element;

    $(self.element).css({"width": width, "height": width});

    self.set = function(num, rgb){
        if(num >= 0 && num <= 180){
            $(self.element).css({"background-image": "linear-gradient(" + (90 + num) + "deg, transparent 50%, black 50%), linear-gradient(90deg, black 50%, transparent 50%)"});
        }
        if(num > 180 && num <= 360){
            $(self.element).css({"background-image": "linear-gradient(" + (num - 90) + "deg, transparent 50%, " + rgb + " 50%), linear-gradient(90deg, black 50%, transparent 50%)"});
        }
    };
}

var opacityOff = .20;
var opacityOn = 1;
var animateSpeed = 'fast';
var baseWidth = 300;
var intervalWidth = 20;
var digits = [];
var circles = [];

$('.digit').each(function(){
    digits.push(new Digit($(this)));
});

$('.circle').each(function(index){
    var width = baseWidth - (index * intervalWidth);
    circles.push(new Circle($(this), width));
});

setInterval(function() {
    var now = new Date();
    var h = (now.getHours() > 12) ? (now.getHours() - 12) : now.getHours();
    var m = now.getMinutes();
    var s = now.getSeconds();
    var rgb = 'rgb(' + Math.floor(h * 21.25) + ',' + Math.floor(m * 4.25) + ',' + Math.floor(s * 4.25) + ')';

    digits[0].set(Math.floor(h / 10));
    digits[1].set(h % 10);
    digits[3].set(Math.floor(m / 10));
    digits[4].set(m % 10);
    digits[6].set(Math.floor(s / 10));
    digits[7].set(s % 10);

    circles[0].set((h*30), rgb);
    circles[2].set((m*6), rgb);
    circles[4].set((s*6), rgb);

    $('.active').css({'background-color': rgb,'box-shadow': '0 0 15px ' + rgb});
    $('.circle:not(".separator")').css({'background-color': rgb});
}, 1000);