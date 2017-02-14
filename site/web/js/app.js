$( document ).ready(function(){
	/*------General------*/
	//Masque le loader
	$('body .loader').fadeOut("slow");

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
		if ($(this).scrollTop() > 135) {
			nav.addClass("nav-fixed");
		} else {
			nav.removeClass("nav-fixed");
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
    var dialogue = alertMessage("Supprimer cet éléments ?", "Voulez vous vraiment supprimer cet element ?", "Supprimer", "Annuler", "alert-supprimer");
    var localtion = ($(event.target).closest( 'div.boutons-admin' ));
    $(this).after(dialogue);
    console.log(dialogue);
  });



	/*------liste annonces------*/
	//Change les balises accroche annonce en p
	$( ".annonce div[class^='col-'] .contenu .accroche" ).children().each(function(index){
		$(this).replaceWith($('<p>' + $(this).text() + '</p>'))
	})


	/*------Equipe------*/
	//$(".equipe .paralax").parallax("center", 2900, 0.1, true);


	/*------Visuel gallerie photos------*/
	$(document).on('click','.galerie-photos .photos ul li a img', function(e) {
		e.preventDefault();
		var imageSrc = $(this).attr("src");
		$('.galerie-photos .photos ul li').removeClass("show");
		$(this).closest('.galerie-photos .photos ul li').addClass("show");

		if ($('#lightbox').length > 0) { // #lightbox exists
			//insert img tag with clicked link's href as src value
			$('#lightbox .contenu').html('<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><img src="' + imageSrc + '" /><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>');
			$('#lightbox').show();
		}else { //#lightbox does not exist
			//create HTML markup for lightbox window
			var lightbox =
			'<div id="lightbox" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">' +
				'<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></div>' +
				'<div class="contenu col-xs-12 col-sm-10 col-sm-offset-1">' + //insert clicked link's href into img src
					'<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>'+
					'<img src="' + imageSrc+'" />' +
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

	function boucleVisionneuse(sens) {
		/*Récupère le src de l'img du li suivant et le met dans le lightbox*/
		if (sens == "prev") {
			var PrecSuivli = $('.galerie-photos .photos ul li.show').prev('li');
		}else{
			var PrecSuivli = $('.galerie-photos .photos ul li.show').next('li');
		}
		var imgPrecSuivli = PrecSuivli.find('img');
		var imgSrc = imgPrecSuivli.attr("src");

		if (imgSrc != null) {
			$('.galerie-photos .photos ul li').removeClass("show");
			PrecSuivli.addClass("show");

			$('#lightbox .contenu').html('<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><img src="' + imgSrc + '" /><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>');
			$('#lightbox').show();
		}else{
			/*Boucle : retour à la première image*/
			if (sens == "prev") {
				var premierDernierLi = $('.galerie-photos .photos ul li').last();
			}else{
				var premierDernierLi = $('.galerie-photos .photos ul li').first();
			}
			var imgPremierDernierLi = premierDernierLi.find('img');
			var imgSrcPremierDernierLi = imgPremierDernierLi.attr("src");

			$('.galerie-photos .photos ul li').removeClass("show");
			premierDernierLi.addClass("show");

			$('#lightbox .contenu').html('<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><img src="' + imgSrcPremierDernierLi + '" /><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>');
			$('#lightbox').show();
		}
	}

	//Image suivante
	$(document).on('click', '#lightbox .contenu span.glyphicon-menu-right', function(){
		boucleVisionneuse('next');
	});

	//Image précédente
	$(document).on('click', '#lightbox .contenu span.glyphicon-menu-left', function(){
		boucleVisionneuse('prev');
	});



	//Retire la visionneuse de photos si click à coté
	$(document).mouseup(function (e){
		var container = $("#lightbox .contenu");

		if (!container.is(e.target) // if the target of the click isn't the container...
		&& container.has(e.target).length === 0) // ... nor a descendant of the container
		{
			$("#lightbox").hide();
		}
	});

});
