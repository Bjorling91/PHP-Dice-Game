"option strict";
			
window.addEventListener("load", function() {
	
	let imgRefs = document.querySelectorAll("img");
	let nbr = imgRefs.length;
	let counter = 0;

	for(counter = 0; counter < nbr; counter++) {
		imgRefs.item(counter).setAttribute("class", "animation");
	}
});