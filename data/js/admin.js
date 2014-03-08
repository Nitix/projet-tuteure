$(document).ready(function() {

    bootstrap_alert = function() {
    };

    bootstrap_alert.warning = function(message) {
	$('#placeholder').html('<div class="alert alert-warning alert-dismissable" id="warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Attention !</strong> ' + message + ' </div>');
    };

    bootstrap_alert.danger = function(message) {
	$('#placeholder').html('<div class="alert alert-danger alert-dismissable" id="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erreur !</strong> ' + message + ' </div>');
    };

    bootstrap_alert.success = function(message) {
	$('#placeholder').html('<div class="alert alert-success alert-dismissable" id="success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> ' + message + ' </div>');
    };

    $('#document').on('submit', function() {

	var id = $('#id').val();
	var mail = $('#mail').val();

	if (pseudo == '' || mail == '') {
	    alert('Les champs doivent êtres remplis');
	} else {
	    $.ajax({
		url: $(this).attr('action'),
		type: $(this).attr('method'),
		data: $(this).serialize(),
		dataType: 'json',
		success: function(json) {
		    if (json.reponse == 'ok') {
			alert('Tout est bon');
		    } else {
			alert('Erreur : ' + json.reponse);
		    }
		}
	    });
	}
	return false;
    });

    $('.switch').on('click', function() {
	var id = $(this).data("id");

	if (id == 1) {
	    bootstrap_alert.danger("Impossible de cacher l'accueil");
	} else {
	    $.ajax({
		url: "ajaxAdmin.php?a=switchDocument",
		type: "post",
		data: '{ "id" : "' + id + '" }',
		dataType: 'json',
		success: function(json) {
		    if (json.reponse == 'ok') {
			bootstrap_alert.success(json.message);
			var doc = getLigne(id);
			dispo = doc.children(".dispo");
			dispo.html(json.dispo);
			dispo.animate({
			    opacity: 0
			}, 0);
			dispo.animate({
			    opacity: 1
			}, 500);
			button = doc.find(".switch");
			button.html(json.action);
			button.animate({
			    opacity: 0
			}, 0);
			button.animate({
			    opacity: 1
			}, 500);
		    } else {
			bootstrap_alert.danger(json.message);
		    }
		}
	    });
	}
	return false;
    });


    $('.delete').on('click', function() {
	var id = $(this).data("id");

	if (id == 1) {
	    bootstrap_alert.danger("Impossible de supprimer l'accueil");
	} else {
	    $('#delete-id').data('id', id);
	    $('#delete-confirm').modal('show');
	}
	return false;
    });

    $('#delete-id').on('click', function() {
	$('#delete-confirm').modal('hide');
	var id = $(this).data("id");
	
	if (id == 1) {
	    bootstrap_alert.danger("Impossible de supprimer l'accueil");
	} else {
	    $.ajax({
		url: "ajaxAdmin.php?a=supprimerDocument",
		type: "delete",
		data: '{ "id" : "' + id + '" }',
		dataType: 'json',
		success: function(json) {
		    if (json.reponse == 'ok') {
			bootstrap_alert.success(json.message);
			var doc = getLigne(id);
			doc.fadeOut(800);
		    } else {
			bootstrap_alert.danger(json.message);
		    }
		}
	    });
	}
	return false;
    });

    function getLigne(id) {
	return $(".doc-" + id);
    }
});

