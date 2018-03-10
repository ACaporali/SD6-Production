$(document).on('click','.galerie-photos .photos div.photo a img', function(e) {
  e.preventDefault();
  var imageSrc = $(this).attr("src");
  $('.galerie-photos .photos div.photo').removeClass("show");
  $(this).closest('.galerie-photos .photos div.photo').addClass("show");

  if ($('#lightbox').length > 0) { // #lightbox exists
    //insert img tag with clicked link's href as src value
    $('#lightbox .contenu').html('<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><img style="max-height: '+ ($(window).height()-100) +'px; max-width: '+ ($(window).width()-130) +'px;" src="' + imageSrc + '" /><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>');
    $('#lightbox').show();
  }else { //#lightbox does not exist
    //create HTML markup for lightbox window
    var lightbox =
    '<div id="lightbox" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">' +
      '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></div>' +
      '<div class="contenu col-xs-12 col-sm-10 col-sm-offset-1">' + //insert clicked link's href into img src
        '<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>'+
        '<img style="max-height: '+ ($(window).height()-100) +'px; max-width: '+ ($(window).width()-130) +'px;" src="' + imageSrc+'" />' +
        '<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>'+
      '</div>' +
    '</div>';
    //insert lightbox HTML into page
    $('body').append(lightbox);

    //Image dans viewport du navigateur
    //$('#lightbox img').css('max-height', $(window).height()-100);
    console.log('li');
  }
});

//Hide la lightbox si clique sur croix en haut à droite
$(document).on('click', '#lightbox span.glyphicon-remove-circle', function(){
  $('#lightbox').hide();
});

function boucleVisionneuse(sens) {
  /*Récupère le src de l'img du li suivant et le met dans le lightbox*/
  if (sens == "prev") {
    var PrecSuivli = $('.galerie-photos .photos div.show').prev('div.photo');
  }else{
    var PrecSuivli = $('.galerie-photos .photos div.show').next('div.photo');
  }
  var imgPrecSuivli = PrecSuivli.find('img');
  var imgSrc = imgPrecSuivli.attr("src");

  if (imgSrc != null) {
    $('.galerie-photos .photos div.photo').removeClass("show");
    PrecSuivli.addClass("show");

    $('#lightbox .contenu').html('<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><img src="' + imgSrc + '" /><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>');
    $('#lightbox').show();
  }else{
    /*Boucle : retour à la première image*/
    if (sens == "prev") {
      var premierDernierLi = $('.galerie-photos .photos div.photo').last();
    }else{
      var premierDernierLi = $('.galerie-photos .photos div.photo').first();
    }
    var imgPremierDernierLi = premierDernierLi.find('img');
    var imgSrcPremierDernierLi = imgPremierDernierLi.attr("src");

    $('.galerie-photos .photos div.photo').removeClass("show");
    premierDernierLi.addClass("show");

    $('#lightbox .contenu').html('<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><img src="' + imgSrcPremierDernierLi + '" /><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>');
    $('#lightbox').show();
  }

  //Image dans viewport du navigateur
  $('#lightbox img').css('max-height', $(window).height()-100);
  $('#lightbox img').css('max-width', $(window).width()-130);
  console.log('lu');
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
