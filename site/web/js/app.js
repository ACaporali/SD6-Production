$( document ).ready(function(){
	/*------General------*/
	/*Ombres hover*/
	/*$(".annonce [class*='col-'] .contenu").hover(
		function(){$(this).toggleClass("ombres");}
	);*/

	$(".production [class*='col-']").hover(
    function(){$(this).addClass("zoom-effet");}
  );

	/*Navbar*/
	$('nav .navbar-collapse ul li').click(function(){
		$('nav .navbar-collapse li').removeClass("active");
		$(this).addClass("active");
	});

	/*------liste annonces------*/
	/*Change les balises accroche annonce en p*/
	$( ".annonce div[class^='col-'] .contenu .accroche" ).children().each(function(index){
		$(this).replaceWith($('<p>' + $(this).text() + '</p>'))
	})


	/*------Equipe------*/
	//$(".equipe .paralax").parallax("center", 2900, 0.1, true);


	/*------Visuel gallerie photos------*/
	$(document).on('click','links', function() {
		event = event || window.event;
		var target = event.target || event.srcElement,
		link = target.src ? target.parentNode : target,
		options = {index: link, event: event},
		links = this.getElementsByTagName('a');
		blueimp.Gallery(links, options);
	});
})
