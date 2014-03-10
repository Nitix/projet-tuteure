<?php
require_once 'common.php';


try {
    $user = new UserController();
    if ($user->isConnected()) {
	$admin = new AdminController();
	$admin->callAction();
    } else {
	$user->login();
    }
} catch (Exception $e) {
    echo 'Erreur sérieuse, réessayer plus tard, si le site ne fonctionne pas, contacter l\'administrateur';
}
