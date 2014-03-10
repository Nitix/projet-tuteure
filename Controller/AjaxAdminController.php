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
	"supprimerDocument" => "supprimerDocument",
	"masquerTous" => "masquerTous",
	"montrerTous" => "montrerTous",
	"changeDateDocument" => "changeDateDocument",
	"supprimerCategorie" => "supprimerCategorie"
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
				"action" => "Masquer",
			    );
			    $document->update();
			    break;

			default:
			    $document->setAutorisation('9999-99-99');
			    $reponse = array(
				"reponse" => "ok",
				"message" => "Le document est maintenant masqué",
				"dispo" => "Masqué",
				"action" => "Montrer",
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
	    "message" => "Méthode non correcte"
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
			"message" => "Document inexistant"
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

    public function masquerTous() {
	$documents = Document::findALL();
	$reponse = "no-change";
	$message = "Aucun changement a été effectué";
	$first = true;
	foreach ($documents as $doc) {
	    if ($doc->getID() != 1 && $doc->getAutorisation() != 0 && $doc->getAutorisation() != '9999-99-99') {
		$doc->setAutorisation('9999-99-99');
		$doc->update();
		if ($first) {
		    $reponse = "ok";
		    $message = "Les documents sont maintenants masqués";
		    $first = false;
		}
	    }
	}
	$result = array(
	    "reponse" => $reponse,
	    "message" => $message
	);
	echo json_encode($result);
    }

    public function montrerTous() {
	$documents = Document::findALL();
	$reponse = "no-change";
	$message = "Aucun changement a été effectué";
	$first = true;
	foreach ($documents as $doc) {
	    if ($doc->getID() != 1 && $doc->getAutorisation() != 0 && $doc->getAutorisation() == '9999-99-99') {
		$doc->setAutorisation(date('Y-m-d'));
		$doc->update();
		if ($first) {
		    $reponse = "ok";
		    $message = "Les documents sont maintenants visible";
		    $first = false;
		}
	    }
	}
	$result = array(
	    "reponse" => $reponse,
	    "message" => $message,
	    "date" => date('d/m/Y')
	);
	echo json_encode($result);
    }

    public function changeDateDocument() {
	$data = json_decode(file_get_contents('php://input'), true);
	if (isset($data['id'])) {
	    $id = $data['id'];
	    if ($id != 1) {
		$document = Document::findByID($id);
		if ($document == null) {
		    $reponse = array(
			"reponse" => "Error",
			"message" => "Document inexistant"
		    );
		} else {
		    $date = DateTime::CreateFromFormat('d/m/Y', $data['date']);
		    $document->setAutorisation(date('Y-m-d', $date->getTimestamp()));
		    $document->update();
		    $reponse = array(
			"reponse" => "ok",
			"message" => "La disponibilité du document à bien été changé",
		    );
		}
	    } else {
		$reponse = array(
		    "reponse" => "Error",
		    "message" => "Impossible de supprimer l'accueil"
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

    public function supprimerCategorie() {
	$data = json_decode(file_get_contents('php://input'), true);
	if (isset($data['id'])) {
	    $id = $data['id'];
	    if ($id != 1) {
		$categorie = Categorie::findByID($id);
		if ($categorie == null) {
		    $reponse = array(
			"reponse" => "Error",
			"message" => "Catégorie inexistante"
		    );
		} else {
		    $documents = Document::findByCategorie_ID($id);
		    foreach ($documents as $doc) {
			$doc->delete();
		    }
		    $categorie->delete();
		    $reponse = array(
			"reponse" => "ok",
			"message" => "La catégorie a été supprimé"
		    );
		}
	    } else {
		$reponse = array(
		    "reponse" => "Error",
		    "message" => "Impossible de supprimer la catégorie Accueil"
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

}
