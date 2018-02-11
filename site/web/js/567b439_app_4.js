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

	//Message alerte
	function alertMessage(titre, msg, btn1, btn2, classCss) {
		msg = '<div class="bg-alert alert fade in '+classCss+'" id="alertMessage">'+
		'<div class=" alert-info alert-dismissible alert-contenu" role="alert"> '+
		'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
		'<span aria-hidden="true">×</span>'+
		'</button> '+
		'<h4>'+titre+'</h4> '+
		'<p>'+msg+'</p>';
		if (btn1 != 'null') {
			msg = msg + '<p> <button type="button" class="btn btn-info alert-btn1">'+btn1+'</button> ';
		}
		msg = msg + '<button type="button" class="btn btn-default alert-btn2" data-dismiss="alert">'+btn2+'</button> </p> '+
		'</div></div>';
		return msg;
	}

	//Retire le massage alert (popup) si click à coté
	$(document).mouseup(function (e){
		var container = $(".alert-contenu");

		if (!container.is(e.target) && container.has(e.target).length === 0)
		{
			$("#alertMessage").hide();
		}
	});

	//Affiche le message alert sur supprimer une annonce, membre, photo ou categorie
	$(document).on('click', ".boutons-admin .supprimer", function(event) {
		var dialogue = alertMessage("Supprimer cet élément ?", "Voulez vous vraiment supprimer cet element ?", "Supprimer", "Annuler", "alert-supprimer");
		var localtion = ($(event.target).closest( 'div.boutons-admin' ));
		$(this).after(dialogue);
	});

	$(document).on('click', ".actualites .alert-supprimer button.alert-btn1", function(event) {
		var id = $(event.target).closest('div.bouton').find('a.supprimer').data('id');
		supprimerElement(id, 'sd6_production_admin_delete_advert', 'sd6_production_app_actualites');
	});

	$(document).on('click', ".productions .alert-supprimer button.alert-btn1", function(event) {
		var id = $(event.target).closest('div.bouton').find('a.supprimer').data('id');
		supprimerElement(id, 'sd6_production_admin_delete_advert', 'sd6_production_app_productions');
	});

	$(document).on('click', ".equipe .alert-supprimer button.alert-btn1", function(event) {
		var id = $(event.target).closest('div.bouton').find('a.supprimer').data('id');
		supprimerElement(id, 'sd6_production_admin_delete_member', 'sd6_production_app_equipe');
	});

	$(document).on('click', ".galerie-photos .alert-supprimer button.alert-btn1", function(event) {
		var id = $(event.target).closest('div.bouton').find('a.supprimer').data('id');
		supprimerElement(id, 'sd6_production_admin_delete_image', 'sd6_production_app_photos');
	});

	$(document).on('click', ".casting .alert-supprimer button.alert-btn1", function(event) {
		var id = $(event.target).closest('div.bouton').find('a.supprimer').data('id');
		supprimerElement(id, 'sd6_production_admin_delete_advert', 'sd6_production_app_casting');
	});

	$(document).on('click', ".admin-annonces .alert-supprimer button.alert-btn1", function(event) {
		var id = $(event.target).closest('div.boutons-admin').find('a.supprimer').data('id');
		supprimerElementAdmin(id, 'sd6_production_admin_delete_advert', 'sd6_production_admin_advert_index');
	});

	$(document).on('click', ".admin-images .alert-supprimer button.alert-btn1", function(event) {
		var id = $(event.target).closest('div.boutons-admin').find('a.supprimer').data('id');
		supprimerElementAdmin(id, 'sd6_production_admin_delete_image', 'sd6_production_admin_image_index');
	});

	$(document).on('click', ".admin-comptes .alert-supprimer button.alert-btn1", function(event) {
		var id = $(event.target).closest('div.boutons-admin').find('a.supprimer').data('id');
		supprimerElementAdmin(id, 'sd6_production_admin_delete_account', 'sd6_production_admin_account_index');
	});

	$(document).on('click', ".admin-membres .alert-supprimer button.alert-btn1", function(event) {
		var id = $(event.target).closest('div.boutons-admin').find('a.supprimer').data('id');
		supprimerElementAdmin(id, 'sd6_production_admin_delete_member', 'sd6_production_admin_member_index');
	});

	$(document).on('click', ".admin-categories .alert-supprimer button.alert-btn1", function(event) {
		var id = $(event.target).closest('div.boutons-admin').find('a.supprimer').data('id');
		supprimerElementAdmin(id, 'sd6_production_admin_delete_category', 'sd6_production_admin_category_index');
	});

	$(document).on('click', ".popup-pinned .alert-supprimer button.alert-btn1", function(event) {
		var id = $(event.target).closest('div.boutons-admin').find('a.supprimer').data('id');
		supprimerElementAdmin(id, 'sd6_production_popup_infos_delete', 'sd6_production_popup_infos_all');
	});

	function supprimerElement(id, route, redirection){
		var baseUrl = "." + Routing.generate(route);
		var fullUrl = baseUrl + "/"+ id;

		$.ajax({
      url : fullUrl,
      type : 'POST',
      data: {id: id},
      success : function(code_html, statut){
        location.href = "." + Routing.generate(redirection);
      },

      error : function(resultat, statut, erreur){
        alert(erreur);
      }
  	});
	}

	function supprimerElementAdmin(id, route, redirection){
		var baseUrl = "../.." + Routing.generate(route);
		var fullUrl = baseUrl + "/"+ id;

		$.ajax({
      url : fullUrl,
      type : 'POST',
      data: {id: id},
      success : function(code_html, statut){
        location.href = "../.." + Routing.generate(redirection);
      },

      error : function(resultat, statut, erreur){
        alert(erreur);
      }
  	});
	}



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
