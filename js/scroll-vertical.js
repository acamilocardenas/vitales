let elem;
let width;
let cldWidth;
let distance;
let doScroll;
let mean = 20;
let current = 0;
let desplazamiento = 0;
let resposive = 0;

function scrollVertical() {
	CambioVentana2();
	elem = document.getElementById('scroll-area');
	width = parseInt(elem.offsetWidth);
	cldWidth = (parseInt(elem.children[0].offsetWidth) - 52);
	distance = cldWidth - width;
	current = 0;
	desplazamiento = 0;
};

$(window).resize(function() {
   clearTimeout(id);
   id = setTimeout(CambioVentana2(), 1000);
   resposive = 1;
});

function CambioVentana2() {
	if(resposive != 0) {
		resposive = 0;
		RemoveEventHandler();
	}
	Init();
}

function MouseScroll (event) {
	if(distance <= 0 || distance == undefined) {
		resposive = 0;
		RemoveEventHandler();
	}

	event = window.event || event;
	var delta = Math.max(-1, Math.min(1, (event.wheelDelta || -event.detail)));
    if ((delta == -1 && current * mean >= -distance) || (delta == 1 && current * mean < 0)) {
        current = current + delta;
    }
	desplazamiento = current * mean;
    if(desplazamiento < 0){
    	desplazamiento = desplazamiento * -1;
    }
    if(desplazamiento < distance) {
    	$('.table-overflow').scrollLeft(desplazamiento);
    }
    else {
    	$('.table-overflow').scrollLeft(distance);
    }  	
    event.preventDefault();
}

function Init () {
	elem = document.getElementById('scroll-area');
	width = parseInt(elem.offsetWidth);
	cldWidth = (parseInt(elem.children[0].offsetWidth));
	distance = cldWidth - width;
	$('.table-overflow').scrollLeft(current);
    if (elem.addEventListener) {
        elem.addEventListener ("mousewheel", MouseScroll, false);
        elem.addEventListener ("DOMMouseScroll", MouseScroll, false);
    }
    else {
        if (elem.attachEvent) {
            elem.attachEvent ("onmousewheel", MouseScroll);
        }
    }
}

function RemoveEventHandler () {
	if (elem.removeEventListener) {
	    elem.removeEventListener ("mousewheel", MouseScroll, false);
	    elem.removeEventListener ("DOMMouseScroll", MouseScroll, false);
	}
	else {
	    if (elem.detachEvent) {
	        elem.detachEvent ('onmousewheel', MouseScroll);
	    }
	}
}