document.addEventListener('scroll', () => {
	var scroll_position = window.scrollY;
    var navbar = document.querySelector('#navbar-section');
    var nav_ads = document.querySelector('.nav-ads');
	
	if (scroll_position > 100) {
		navbar.style.backgroundColor = '#212121';
        nav_ads.style.display = 'block';
	} else {
		navbar.style.backgroundColor = 'transparent';
        nav_ads.style.display = 'none';
	}

	if(scroll_position >= 8900){
		nav_ads.style.display = 'none';
	}
});

function dropdown(){
	document.getElementById("myDropdown").classList.toggle("show");
}
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}