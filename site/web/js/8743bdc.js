console.log('ici 123');
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
