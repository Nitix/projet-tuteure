<?php

require_once 'common.php';
header('Content-type: application/json');
try {
    $user = new UserController();
    if ($user->isConnected()) {
	$admin = new AjaxAdminController();
	$admin->callAction();
    } else {
	$reponse = array(
	    "reponse" => "error",
	    "message" => "Non autorisé"
	);
	echo json_encode($reponse);
    }
} catch (Exception $e) {
    $reponse = array(
	"reponse" => "error",
	"message" => 'Erreur sérieuse, réessayer plus tard, si le site ne fonctionne pas, contacter l\'administrateur'
    );
    echo json_encode($reponse);
}