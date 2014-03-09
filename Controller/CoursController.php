<?php

class CoursController extends Controller {

    protected static $actions = array(
	'voirDocument' => 'voirDocumentAction',
	'listDocuments' => 'listDocumentsAction',
	'accueil' => 'home',
	'imprimerDocument' => 'imprimerDocument'
    );

    public function home() {
	$accueil = Document::findByCategorie_id(1);
	if (is_null($accueil)) {
	    throw new Exception('Accueil inexistant');
	}
	$view = new DocumentView($accueil[0]);
	$view->displayPage();
    }

    public function getMenu() {
	$menu = Categorie::findDocumentsByCategorieAndAvailable();
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
	    $categorie = Categorie::findByID($_GET['id']);
	    if ($categorie == null) {
		$view = new ErrorView("Documents non trouvé");
		$view->displayPage();
	    } else {
		$documents = Document::findByCategorie_IDAndAVailable($_GET['id']);
		$view = new ListDocumentsView($categorie, $documents);
		$view->DisplayPage();
	    }
	} else {
	    $view = new ErrorView("Requete incorrect");
	    $view->displayPage();
	}
    }
    
    public function imprimerDocument() {
	if (isset($_GET['id'])) {
	    $document = Document::findByID($_GET['id']);
	    if ($document == null) {
		$view = new ErrorDocumentView("Document non trouvé");
		$view->displayPage();
	    } else {
		$view = new PrintDocumentView($document);
		$view->DisplayPage();
	    }
	} else {
	    $view = new ErrorDocumentView("Requete incorrect");
	    $view->displayPage();
	}
    }

}
