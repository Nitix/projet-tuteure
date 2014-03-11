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

    bootstrap_alert.info = function(message) {
	$('#placeholder').html('<div class="alert alert-info alert-dismissable" id="success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> ' + message + ' </div>');
    };

    $('.switch').on('click', function() {
	var doc = $(this).parent().parent();
	var id = doc.data("id");

	if (id === 1) {
	    bootstrap_alert.danger("Impossible de cacher l'accueil");
	} else {
	    $.ajax({
		url: "/SitePedagogique/ajaxAdmin.php?a=switchDocument",
		type: "post",
		data: '{ "id" : "' + id + '" }',
		dataType: 'json',
		success: function(json) {
		    if (json.reponse === 'ok') {
			bootstrap_alert.success(json.message);
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
    });


    $('.delete').on('click', function() {
	var doc = $(this).parent().parent();
	var id = doc.data("id");
	if (id === 1) {
	    bootstrap_alert.danger("Impossible de supprimer l'accueil");
	} else {
	    $('#delete-id').data('id', id);
	    $('#delete-confirm').modal('show');
	}
    });

    $('#delete-id').on('click', function() {
	$('#delete-confirm').modal('hide');
	var id = $(this).data("id");
	var doc = $("tbody").find("[data-id='" + id + "']");

	if (id === 1) {
	    bootstrap_alert.danger("Impossible de supprimer l'accueil");
	} else {
	    $.ajax({
		url: "/SitePedagogique/ajaxAdmin.php?a=supprimerDocument",
		type: "delete",
		data: '{ "id" : "' + id + '" }',
		dataType: 'json',
		success: function(json) {
		    if (json.reponse === 'ok') {
			bootstrap_alert.success(json.message);
			doc.fadeOut(800);
		    } else {
			bootstrap_alert.danger(json.message);
		    }
		}
	    });
	}
    });

    $('.delete-cat').on('click', function() {
	var cat = $(this).parent().parent();
	var id = cat.data("id");
	if (id === 1) {
	    bootstrap_alert.danger("Impossible de supprimer l'accueil");
	} else {
	    $('#delete-cat-id').data('id', id);
	    $('#delete-confirm').modal('show');
	}
    });

    $('#delete-cat-id').on('click', function() {
	$('#delete-confirm').modal('hide');
	var id = $(this).data("id");
	var cat = $("tbody").find("[data-id='" + id + "']");
	if (id === 1) {
	    bootstrap_alert.danger("Impossible de supprimer l'accueil");
	} else {
	    $.ajax({
		url: "/SitePedagogique/ajaxAdmin.php?a=supprimerCategorie",
		type: "delete",
		data: '{ "id" : "' + id + '" }',
		dataType: 'json',
		success: function(json) {
		    if (json.reponse === 'ok') {
			bootstrap_alert.success(json.message);
			cat.fadeOut(800);
		    } else {
			bootstrap_alert.danger(json.message);
		    }
		}
	    });
	}
    });

    $('#hideAll').on('click', function() {
	$('#hide-confirm-dialog').modal('show');
    });

    $('#hide-confirm-button').on('click', function() {
	$('#hide-confirm-dialog').modal('hide');
	$.ajax({
	    url: "/SitePedagogique/ajaxAdmin.php?a=masquerTous",
	    dataType: 'json',
	    success: function(json) {
		switch (json.reponse) {
		    case 'ok':
			bootstrap_alert.success(json.message);
			$('.maskable').html('Masqué');
			break;
		    case 'no-change':
			bootstrap_alert.info(json.message);
			break;
		    default:
			bootstrap_alert.danger(json.message);
			break;
		}
	    }
	});
    });

    $('#showAll').on('click', function() {
	$('#show-confirm-dialog').modal('show');
    });

    $('#show-confirm-button').on('click', function() {
	$('#show-confirm-dialog').modal('hide');
	$.ajax({
	    url: "/SitePedagogique/ajaxAdmin.php?a=montrerTous",
	    dataType: 'json',
	    success: function(json) {
		switch (json.reponse) {
		    case 'ok':
			bootstrap_alert.success(json.message);
			$('.maskable').html(json.date);
			break;
		    case 'no-change':
			bootstrap_alert.info(json.message);
			break;
		    default:
			bootstrap_alert.danger(json.message);
			break;
		}

	    }
	});
    });



    $('#newlogin').on('input', function() {
	var login = $(this).val();
	$.ajax({
	    url: "/SitePedagogique/ajaxAdmin.php?a=checkLogin",
	    method: "post",
	    data: '{ "login" : "' + login + '" }',
	    dataType: 'json',
	    success: function(json) {
		if (json.reponse === 'ok') {
		    $(".ok").show();
		    $(".remove").hide();
		} else {
		    $(".ok").hide();
		    $(".remove").show();
		}
	    }
	});
    });

    $('#changelogin').on('input', function() {
	var login = $(this).val();
	$.ajax({
	    url: "/SitePedagogique/ajaxAdmin.php?a=checkNewLogin",
	    method: "post",
	    data: '{ "login" : "' + login + '" }',
	    dataType: 'json',
	    success: function(json) {
		if (json.reponse === 'ok') {
		    $(".ok").show();
		    $(".remove").hide();
		} else {
		    $(".ok").hide();
		    $(".remove").show();
		}
	    }
	});
    });

    $('#email').on('input', function() {
	var email = $(this).val();
	if (validateEmail(email)) {
	    $(".ok-email").show();
	    $(".remove-email").hide();
	} else {
	    $(".ok-email").hide();
	    $(".remove-email").show();
	}

    });

    function validateEmail(email) {
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
    }
    ;

    $('#confirm').on('input', function() {
	var pass1 = $(this).val();
	var pass2 = $('#password').val();
	if (pass1 === pass2) {
	    $(".ok-password").show();
	    $(".remove-password").hide();
	} else {
	    $(".ok-password").hide();
	    $(".remove-password").show();
	}

    });

    $('.maskable').datepicker({
	language: "fr",
	autoclose: true
    }).on('changeDate', function(e) {
	var date = e.format();
	dispo = $(this);
	doc = dispo.parent();
	var id = doc.data("id");
	if (id === 1) {
	    bootstrap_alert.danger("Impossible de cacher l'accueil");
	} else {
	    $.ajax({
		url: "/SitePedagogique/ajaxAdmin.php?a=changeDateDocument",
		type: "post",
		data: '{ "id" : "' + id + '", "date" : "' + date + '" }',
		dataType: 'json',
		success: function(json) {
		    if (json.reponse === 'ok') {
			bootstrap_alert.success(json.message);
			dispo.html(date);
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
    });

    $('#autorisation').datepicker({
	language: "fr"
    });
});

