<?php

/**
 * Classe générique des contrôleurs
 *
 */
abstract class Controller {

    public function callAction() {
	if (isset($_GET['a'])) {
	    if (array_key_exists($_GET['a'], static::$actions)) {
		$action = static::$actions[$_GET['a']];
		$this->$action();
	    } else {
		$this->home();
	    }
	} else {
	    $this->home();
	}
    }

    abstract function home();
}
