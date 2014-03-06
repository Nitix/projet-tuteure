$(document).ready(function() {

    bootstrap_alert = function() {
    };

    bootstrap_alert.warning = function(message) {
	$('#placeholder').html('<div class="alert alert-warning alert-dismissable" id="warning" style="display: none"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Attention !</strong> ' + message + ' </div>');
    };

    bootstrap_alert.danger = function(message) {
	$('#placeholder').html('<div class="alert alert-danger alert-dismissable" id="alert" style="display: none"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Impossible !</strong> ' + message + ' </div>');
    };
    
    bootstrap_alert.success = function(message){
	$('#placeholder').html('<div class="alert alert-success alert-dismissable" id="success" style="display: none"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Succès !</strong> '+ message +' </div>');
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
	var id = $(this).attr("value");

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

});

