let heroCounter = 1;
changeHero();
let heroInterval = setInterval(changeHero, 10000);
function changeHero() {
	let heroContainer = document.getElementById('hero');
	heroContainer.style.backgroundImage = 'linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("images/hero'+heroCounter+'.jpg")';
	heroCounter++;
	if(heroCounter > 3) {
		heroCounter = 1;
	}
}

const location1 = document.getElementById('navbar-location');
const contactUs = document.getElementById('navbar-contact-us');
const aboutUs = document.getElementById('navbar-about-us');

location1.addEventListener('click', function() { setTimeout(closeOffCanvas, 1000); } );
contactUs.addEventListener('click', function() { setTimeout(closeOffCanvas, 1000); });
aboutUs.addEventListener('click', function() { setTimeout(closeOffCanvas, 1000); });

function closeOffCanvas() {
	const offcanvas = document.getElementById('navbarNav');
	let openedCanvas = bootstrap.Offcanvas.getInstance(offcanvas);
    openedCanvas.hide();
}