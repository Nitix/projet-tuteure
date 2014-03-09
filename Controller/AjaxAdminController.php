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
	"switchDocument" => "switchDocument",
	"supprimerDocument" => "supprimerDocument"
    );

    public function switchDocument() {
	$data = json_decode(file_get_contents('php://input'), true);
	if (isset($data['id'])) {
	    $id = $data['id'];
	    if ($id != 1) {
		$document = Document::findByID($id);
		if ($document != null) {
		    switch ($document->getAutorisation()) {
			case 0:
			    $reponse = array(
				"reponse" => "Error",
				"message" => "Impossible de masquer un fichier permanent"
			    );
			    break;
			case '9999-99-99':
			    $document->setAutorisation(date('Y-m-d'));
			    $reponse = array(
				"reponse" => "ok",
				"message" => "Le document est maintenant visible",
				"dispo" => date('d/m/Y'),
				"action" => "Masquer"
			    );
			    $document->update();
			    break;

			default:
			    $document->setAutorisation('9999-99-99');
			    $reponse = array(
				"reponse" => "ok",
				"message" => "Le document est maintenant masqué",
				"dispo" => "Masqué",
				"action" => "Montrer"
			    );
			    $document->update();
			    break;
		    }
		} else {
		    $reponse = array(
			"reponse" => "Error",
			"message" => "Document introuvable"
		    );
		}
	    } else {
		$reponse = array(
		    "reponse" => "Error",
		    "message" => "Impossible de masque l'accueil"
		);
	    }
	} else {
	    $reponse = array(
		"reponse" => "Error",
		"message" => "Identifiant manquant"
	    );
	}
	echo json_encode($reponse);
    }

    public function home() {
	$reponse = array(
	    "reponse" => "Error",
	    "message" => "Erreur"
	);
	echo json_encode($reponse);
    }

    public function supprimerDocument() {
	$data = json_decode(file_get_contents('php://input'), true);
	if (isset($data['id'])) {
	    $id = $data['id'];
	    if ($id != 1) {
		$document = Document::findByID($id);
		if ($document == null) {
		    $reponse = array(
			"reponse" => "Error",
			"message" => "Identifiant manquant"
		    );
		} else {
		    $document->delete();
		    $reponse = array(
			"reponse" => "ok",
			"message" => "Le document a été supprimé"
		    );
		}
	    } else {
		$reponse = array(
		    "reponse" => "Error",
		    "message" => "Identifiant manquant"
		);
	    }
	}
	echo json_encode($reponse);
    }

}
