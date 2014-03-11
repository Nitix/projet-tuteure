<?php

require_once 'common.php';
try {
    if (isset($_GET['c'])) {
	switch ($_GET['c']) {
	    case 'Admin' :
		$user = new UserController();
		if ($user->isConnected()) {
		    $admin = new AdminController();
		    $admin->callAction();
		} else {
		    $user->login();
		}
		break;
	    case 'User' :
		$user = new UserController();
		$user->callAction();
		break;
	    default:
		$controleur = new CoursController();
		$controleur->callAction();
		break;
	}
    } else {
	$controleur = new CoursController();
	$controleur->callAction();
    }
} catch (Exception $e) {
    echo 'Erreur sérieuse, réessayer plus tard, si le site ne fonctionne pas, contacter l\'administrateur';
}