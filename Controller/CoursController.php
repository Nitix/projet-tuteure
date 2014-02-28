<?php

class CoursController extends Controller {

    protected static $actions = array(
	'voirDocument' => 'voirDocumentAction',
	'listDocuments' => 'listDocumentsAction',
	'accueil' => 'home'
    );

    public function home() {
	$accueil = Document::findByType_id(1);
	if (is_null($accueil)) {
	    throw new Exception('Accueil inexistant');
	}
	$view = new AccueilView($accueil[0]);
	$view->displayPage();
    }

    public function getMenu() {
	$menu = Type::findDocumentsByType();
	return $menu;
    }

    public function voirDocumentAction() {
	if (isset($_GET['id'])) {
	    $document = Document::findByID($_GET['id']);
	    if ($document == null) {
		$view = new ErrorDocumentView("Document non trouvé");
		$view->displayPage();
	    } else {
		$view = new DocumentView($document);
		$view->DisplayPage();
	    }
	} else {
	    $view = new ErrorDocumentView("Requete incorrect");
	    $view->displayPage();
	}
    }

    public function listDocumentsAction() {
	if (isset($_GET['id'])) {
	    $type = Type::findByID($_GET['id']);
	    if ($type == null) {
		$view = new ErrorView("Documents non trouvé");
		$view->displayPage();
	    } else {
		$documents = Document::findByType_IDAndAVailable($_GET['id']);
		$view = new ListDocumentsView($type, $documents);
		$view->DisplayPage();
	    }
	} else {
	    $view = new ErrorView("Requete incorrect");
	    $view->displayPage();
	}
    }

}
