$( document ).ready(function(){
	/*------General------*/
	//Masque le loader
	$(".productions .grille [class*='col-']").hover(
		function(){$(this).addClass("zoom-effet");}
	);

	//Navbar active
	var url = window.location.pathname;
	var filename = url.split("/");

	$('nav .navbar-collapse ul li').each(function() {
		if(filename[5] == $(this).attr('id')) {
			$(this).addClass('active');
		}
	});

	//Navbar fixe
	var nav = $('nav');

	$(window).scroll(function () {
		if ($(this).scrollTop() > 50) {
			nav.addClass("nav-fixed");
			$('.body').css('margin-top', nav.height());
		} else {
			nav.removeClass("nav-fixed");
			$('.body').css('margin-top', '0');
		}
	});

	/*------liste annonces------*/
	//Change les balises accroche annonce en p
	$( ".annonce div[class^='col-'] .contenu .accroche" ).children().each(function(index){
		$(this).replaceWith($('<p>' + $(this).text() + '</p>'))
	})

	/*------PopupInfosBundle------*/
	//Creation d'un cookie (accepter utilisation cookies)
	function creatCookie(name, value, days, element) {
		var res = $(location).attr('href').split(".fr");
		var getUrlCreateCookie = res[0]+".fr" + Routing.generate('sd6_production_popup_infos_create_cookies');

		$.ajax({
			url : getUrlCreateCookie,
			type : 'POST',
			data: {name: name, value: value, days: days},
			success : function(code_html, statut){
				$(element).fadeOut("slow",function(){
		        $(element).remove();
		    })
				console.log('cookie ok');
			},
			error : function(resultat, statut, erreur){
				alert(erreur);
			}
		});
	}

	//Creation cookie si clique sur bouton "ok" msg utilisation cookie
	$(document).on('click', ".infos-cookies button", function(event) {
		creatCookie('ok_cookie', 'ok', 7, '.infos-cookies');
	});

	//Creation cookie si "ne plus afficher" la popup promotionnelle
	$('.popup-promo #checkbox-promo').click(function() {
		if ($(this).is(':checked')) {
			creatCookie('hide_popup_promo', 'ok', 7, '.popup-promo');
		}
	});

	//Hide popup infos promo
	$(document).on('click', ".popup-promo span", function(event) {
		creatCookie('hide_popup_promo_close', 'ok', 1, '.popup-promo');
	});

	//Taille de la video de l'index
	$('<style>video { width: '+$( window ).width()+'px; height: auto;}</style>').appendTo('head');

	$( window ).resize(function() {
	  $('<style>video { width: '+$( window ).width()+'px; height: auto;}</style>').appendTo('head');
	});

	//Masque le loader
	$('body .loader').fadeOut("slow");
});


/*---Animations in viewport---*/
function inViewport($el) {
    var elH = $el.outerHeight(),
        H   = $(window).height(),
        r   = $el[0].getBoundingClientRect(), t=r.top+150, b=r.bottom;
    return Math.max(0, t>0? Math.min(elH, H-t) : (b<H?b:H));
}



(function($, win) {
  $.fn.inViewport = function(cb) {
     return this.each(function(i,el) {
       function visPx(){
         var elH = $(el).outerHeight(),
             H = $(win).height(),
             r = el.getBoundingClientRect(), t=r.top+150, b=r.bottom;
         return cb.call(el, Math.max(0, t>0? Math.min(elH, H-t) : (b<H?b:H)));
       }
       visPx();
       $(win).on("resize scroll", visPx);
     });
  };
}(jQuery, window));

$(".element-left").inViewport(function(px){
  if(px) {
    $(this).addClass("animation-from-left") ;
    $( this ).css( "visibility", "visible" );
  }
});

$(".element-right").inViewport(function(px){
  if(px) {
    $(this).addClass("animation-from-right") ;
    $( this ).css( "visibility", "visible" );
  }
});

$(".element-down").inViewport(function(px){
  if(px) {
    $(this).addClass("animation-from-down") ;
    $( this ).css( "visibility", "visible" );
  }
});
