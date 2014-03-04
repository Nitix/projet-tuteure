<?php

require_once 'common.php';

try {
    $user = new UserController();
    $user->callAction();
} catch (Exception $e) {
    echo 'Erreur sérieuse, réessayer plus tard, si le site ne fonctionne pas, contacter l\'administrateur';
}