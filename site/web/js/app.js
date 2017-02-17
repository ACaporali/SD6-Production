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
		if ($(this).scrollTop() > 50) {
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


});
