<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AjaxAdminController
 *
 * @author Guillaume
 */
class AjaxAdminController extends Controller {

    static $actions = array(
	"switchDocument" => "switchDocument"
    );

    public function switchDocument() {
	$data = json_decode(file_get_contents('php://input'), true);
	if (isset($data['id'])) {
	    $id = $data['id'];
	    if ($id != 1) {
		$document = Document::findByID($id);
		if ($document->getAutorisation() == '9999-99-99') {
		    $document->setAutorisation(date('Y-m-d'));
		    $message = "Le document est maintenant visible";
		    $dispo = date('d/m/Y');
		    $action = "Masquer";
		} else {
		    $document->setAutorisation('9999-99-99');
		    $message = "Le document est maintenant masqué";
		    $dispo = "Masqué";
		    $action = "Montrer";
		}
		$document->update();
		$reponse = array(
		    "reponse" => "ok",
		    "message" => $message,
		    "dispo" => $dispo,
		    "action" => $action
		);
		echo json_encode($reponse);
	    } else {
		$reponse = array(
		    "reponse" => "Error",
		    "message" => "Impossible de masque l'accueil"
		);
		echo json_encode($reponse);
	    }
	} else {
	    $reponse = array(
		"reponse" => "Error",
		"message" => "Identifiant manquant"
	    );
	    echo json_encode($reponse);
	}
    }

    public function home() {
	$reponse = array(
	    "reponse" => "Error",
	    "message" => "Erreur"
	);
	echo json_encode($reponse);
    }

}
