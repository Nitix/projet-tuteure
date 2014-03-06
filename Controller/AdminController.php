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

	// Liste des actions d'un admin
    static $actions = array(
	'nouveauDocument' => 'nouveauDocument',
	'modifierDocument' => 'modifierDocument',
	'enregistrerDocument' => 'enregistrerDocument',
	'nouvelleCategorie' => 'nouvelleCategorie',
	'modifierCategorie' => 'modifierCategorie',
	'enregistrerCategorie' => 'enregistrerCategorie',
	'modifierAccueil' => 'modifierAccueil',
	'listDocuments' => 'listDocuments',
	'supprimerDocument' => 'supprimerDocument',
	'supprimerCategorie' =>'supprimerCategorie',
	'listCategories' => 'listCategories',
	'cacherDocument' => 'cacherDocument',
	'montrerDocument' => 'montrerDocument'
    );
    static $allowedTags = "<div><p><h1><h2><h3><h4><h5><h6><ul><ol><li><dl><dt><dd><address><hr><pre><blockquote><center><ins><del><a><span><bdo><br><em><strong><dfn><code><samp><kbd><bar><cite><abbr><acronym><q><sub><sup><tt><i><b><big><small><u><s><strike><basefont><font><object><param><img><table><caption><colgroup><col><thead><tfoot><tbody><tr><th><td><embed>";

    public function home() {
	$view = new HomeAdminView();
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

    public function enregistrerDocument() {
	if (isset($_POST['jeton']) && $_SESSION[PREFIX . 'jeton'] == $_POST['jeton']) {
	    if (isset($_POST['id'])) {
	
		$document = Document::findByID($_POST['id']);
		if ($document == null) {
		    $view = new ErrorAdminView("Le document modifié n'existe pas");
		    $view->displayPage();
		} else {
		    $this->modifierInformationsDocument($document);
		    $document->update();
		    $view = new OkAdminView("Le document a bien été mis à jour");
		    $view->displayPage();
		}
	    } else {
		$document = new Document();
		$this->modifierInformationsDocument($document);
		$document->insert();
		$view = new OkAdminView("Le document a bien été ajouté");
		$view->displayPage();
	    }
	} else {
	    $view = new ErrorAdminView("Jeton incorrect, tentative de CRSF detecté, abondon de l'ajout");
	    $view->displayPage();
	}
    }

    private function modifierInformationsDocument(Document $document) {
	$document->setAdministrateur_id($_SESSION[PREFIX . 'user']);
	$document->setAutorisation($_POST['autorisation']);
	$document->setContenu(strip_tags($_POST['contenu'], static::$allowedTags));
	$document->setNom(htmlspecialchars($_POST['nom']));
	$document->setCategorie_id($_POST['categorie_id']);
    }

    public function nouvelleCategorie() {
	$view = new NouvelleCategorieAdminView();
	$view->displayPage();
    }

    public function modifierCategorie() {
	if (isset($_GET['id'])) {
	    $categorie = Categorie::findByID($_GET['id']);
	    if ($categorie == null) {
		$view = new ErrorAdminView("Categorie non trouvé");
		$view->displayPage();
	    } else {
		$view = new CategorieAdminView($categorie);
		$view->DisplayPage();
	    }
	} else {
	    $view = new ErrorAdminView("Requete incorrect");
	    $view->displayPage();
	}
    }

    public function enregistrerCategorie() {
	if ($_SESSION[PREFIX . 'jeton'] == $_POST['jeton']) {
	    if (isset($_POST['id'])) {
		$categorie = Categorie::findByID($_GET['id']);
		if ($categorie == null) {
		    $view = new ErrorAdminView("Le categorie modifié n'existe pas'");
		    $view->displayPage();
		} else {
		    $this->modifierInformationsCategorie($categorie);
		    $categorie->update();
		    $view = new OkAdminView("La catégorie a bien été mise à jour");
		    $view->displayPage();
		}
	    } else {
		$categorie = new Categorie();
		$this->modifierInformationsCategorie($categorie);
		$categorie->insert();
		$view = new OkAdminView("La catégorie a bien été ajoutée");
		$view->displayPage();
	    }
	} else {
	    $view = new ErrorAdminView("CSRF detecté");
	    $view->displayPage();
	}
    }

    private function modifierInformationsCategorie(Categorie $categorie) {
	$categorie->setNom(htmlspecialchars($_POST['nom']));
    }

    public function modifierAccueil() {
	$document = Document::findByID(1);
	$view = new ModifierAccueilAdminView($document);
	$view->displayPage();
    }
    
	// 1 cacher 2 montrer
    public function cacherDocument() {
	if (isset($_GET['id'])) {
	    $id = $_GET['id'];
	    if ($id != 1) {
		$document = Document::findByID($id); 
		$document->setAutorisation('9999-99-99');
		$document->update();
		$view = new OkAdminView("Le document est maintenant caché.");
		$view->displayPage();
	   }
    	}
    }	
	public function montrerDocument() {
	if (isset($_GET['id'])) {
	    $id = $_GET['id'];
	    if ($id != 1) {
		$document = Document::findByID($id); 
		$document->setAutorisation('0001-01-01');
		$document->update();
		$view = new OkAdminView("Le document est maintenant visible.");
		$view->displayPage();
	   }
    	}
    }		

    public function listDocuments() {
	$documents = Categorie::findDocumentsByCategorie();
	$view = new ListDocumentsAdminView($documents);
	$view->displayPage();
    }
	
    public function listCategories() {
	$categorie = Categorie::findAll();
	$view = new ListCategoriesAdminView($categorie);
	$view->displayPage();
    }
    
    public function supprimerCategorie() {
	if (isset($_GET['id'])) {
	    $id = $_GET['id'];
	    if ($id != 1) {
		$cat = Categorie::findByID($id);
		if ($cat == null) {
		    $view = new ErrorAdminView("Catégorie non trouvée");
		    $view->displayPage();
		} else {
		    $cat->delete();
		    $view = new OkAdminView("La catégorie a bien été supprimée");
		    $view->displayPage();
		}
	    } else {
		$view = new ErrorAdminView("Imposssible de supprimer l'accueil");
		$view->displayPage();
	    }
	}
    }

    public function supprimerDocument() {
	if (isset($_GET['id'])) {
	    $id = $_GET['id'];
	    if ($id != 1) {
		$document = Document::findByID($id);
		if ($document == null) {
		    $view = new ErrorAdminView("Document non trouvé");
		    $view->displayPage();
		} else {
		    $document->delete();
		    $view = new OkAdminView("Le document a bien été supprimé");
		    $view->displayPage();
		}
	    } else {
		$view = new ErrorAdminView("Imposssible de supprimer l'accueil");
		$view->displayPage();
	    }
	}
    }

}
