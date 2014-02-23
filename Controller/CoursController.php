<?php

class CoursController extends Controller {

    static $actions = array(
	'voirDocument' => 'voirDccumentAction',
	'accueil' => 'home'
    );

    public function home() {
	$accueil = Document::findByType_id(1);
	if (is_null($accueil)) {
	    throw new Exception('Accueil inexistant');
	}
	$view = new AccueilView("Accueil", $accueil[0]);
	$view->displayPage();
    }

    public function getMenu() {
	$menu = Type::findDocumentsByType();
	return $menu;
    }

}
