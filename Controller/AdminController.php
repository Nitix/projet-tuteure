<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author Guillaume
 */
class AdminController extends Controller {

    static $actions = array();

    public function home() {
	$view = new AdminView();
	$view->displayPage();
    }

    public function nouveauDocument() {
	$view = new NouveauDocumentAdminView();
	$view->displayPage();
    }

    public function modifierDocument() {
	if (isset($_GET['id'])) {
	    $document = Document::findByID($_GET['id']);
	    if ($document == null) {
		$view = new ErrorAdminView("Document non trouvé");
		$view->displayPage();
	    } else {
		$view = new DocumentAdminView($document);
		$view->DisplayPage();
	    }
	} else {
	    $view = new ErrorAdminView("Requete incorrect");
	    $view->displayPage();
	}
    }

    public function enregistrerModificationDocumentAction() {
	if ($_SESSION[PREFIX . 'jeton'] == $_POST['jeton']) {
	    if (isset($_POST['id'])) {
		$document = Document::findByID($_GET['id']);
		if ($document == null) {
		    $view = new ErrorAdminView("Le document modifié n'existe pas'");
		    $view->displayPage();
		} else {
		    $this->modifierInformationDocumen($document);
		    $document->update();
		}
	    } else {
		$document = new Document();
		$this->modifierInformationsDocument($document);
		$document->insert();
	    }
	}
    }

    private function modifierInformationsDocument(Document $document) {
	$document->setAdministrateur_id($_SESSION[PREFIX . 'id']);
	$document->setAutorisation($_POST['autorisation']);
	$document->setContenu(htmlspecialchars($_POST['contenu']));
	$document->setNom(htmlspecialchars($_POST['nom']));
	$document->setType_id($_POST['type_id']);
    }

    public function nouveauType() {
	$view = new NouveauTypeAdminView();
	$view->displayPage();
    }

    public function modifierType() {
	if (isset($_GET['id'])) {
	    $type = Type::findByID($_GET['id']);
	    if ($type == null) {
		$view = new ErrorAdminView("Type non trouvé");
		$view->displayPage();
	    } else {
		$view = new TypeAdminView($type);
		$view->DisplayPage();
	    }
	} else {
	    $view = new ErrorAdminView("Requete incorrect");
	    $view->displayPage();
	}
    }

    public function enregistrerModificationTypeAction() {
	if ($_SESSION[PREFIX . 'jeton'] == $_POST['jeton']) {
	    if (isset($_POST['id'])) {
		$type = Type::findByID($_GET['id']);
		if ($type == null) {
		    $view = new ErrorAdminView("Le type modifié n'existe pas'");
		    $view->displayPage();
		} else {
		    $this->modifierInformationDocumen($type);
		    $type->update();
		}
	    } else {
		$type = new Type();
		$this->modifierInformationsType($type);
		$type->insert();
	    }
	} else {
	    $view = new ErrorAdminView("CSRF detecté");
	    $view->displayPage();
	}
    }

    private function modifierInformationsType(Type $type) {
	$type->setNom(htmlspecialchars($_POST['nom']));
    }

}
