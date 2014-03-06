<?php

require_once 'common.php';

try {
    $controleur = new CoursController();
    $controleur->callAction();
} catch (Exception $e) {
    echo 'Erreur sérieuse, réessayer plus tard, si le site ne fonctionne pas, contacter l\'administrateur';
}