$( document ).ready(function(){
	/*------General------*/
	/*Ombres hover*/
	/*$(".annonce [class*='col-'] .contenu").hover(
		function(){$(this).toggleClass("ombres");}
	);*/

	$(".production .grille [class*='col-']").hover(
    function(){$(this).addClass("zoom-effet");}
  );

	/*Navbar*/
	$('nav .navbar-collapse ul li').click(function(){
		$('nav .navbar-collapse li').removeClass("active");
		$(this).addClass("active");
	});

	/*Navbar fixe*/
	var nav = $('nav');

	$(window).scroll(function () {
		if ($(this).scrollTop() > 135) {
			nav.addClass("nav-fixed");
		} else {
			nav.removeClass("nav-fixed");
		}
	});

	/*------liste annonces------*/
	/*Change les balises accroche annonce en p*/
	$( ".annonce div[class^='col-'] .contenu .accroche" ).children().each(function(index){
		$(this).replaceWith($('<p>' + $(this).text() + '</p>'))
	})


	/*------Equipe------*/
	//$(".equipe .paralax").parallax("center", 2900, 0.1, true);


	/*------Visuel gallerie photos------*/
	$(document).on('click','.galerie .photos ul li a', function(e) {
		e.preventDefault();
		var imageHref = $(this).attr("href");

		if ($('#lightbox').length > 0) { // #lightbox exists
			//insert img tag with clicked link's href as src value
			$('#lightbox .contenu').html('<img src="' + imageHref + '" />');
			$('#lightbox').show();
		}else { //#lightbox does not exist
			//create HTML markup for lightbox window
			var lightbox =
			'<div id="lightbox">' +
				'<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>' +
				'<div class="contenu">' + //insert clicked link's href into img src
					'<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>'+
					'<img src="' + imageHref +'" />' +
					'<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>'+
				'</div>' +
			'</div>';
			//insert lightbox HTML into page
			$('body').append(lightbox);
		}
	});

	//Click anywhere on the page to get rid of lightbox window
	$(document).on('click', '#lightbox span.glyphicon-remove-circle', function(){
		$('#lightbox').hide();
	});

	$(document).on('click', '#lightbox .contenu span.glyphicon-menu-right', function(){
		console.log('ici');
	});

})
