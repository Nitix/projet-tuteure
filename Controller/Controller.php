<?php

/**
 * Classe générique des contrôleurs
 *
 */
abstract class Controller {

    public function callAction() {
	if (isset($_GET['a'])) {
	    if (array_key_exists($_GET['a'], $this->$actions)) {
		$this->$actions[$_GET['a']]();
	    }
	}
	$this->home();
    }

    abstract function home();
}
