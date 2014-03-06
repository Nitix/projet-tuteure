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
class AjaxAdminController {

    public function switchDocument() {
	
    }

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
		$document->setAutorisation(date('Y-m-d'));
		$document->update();
		$view = new OkAdminView("Le document est maintenant visible.");
		$view->displayPage();
	    }
	}
    }

}
