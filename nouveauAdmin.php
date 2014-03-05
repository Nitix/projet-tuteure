<?php

require_once 'common.php';

//A remettre à zéro après ajout
$passwordhash = new PasswordHash(10, false);
$user = new Administrateur();
$user->setLogin("Haksho");
$user->setNom("Richard");
$user->setPrenom("Adrien");
$user->setPassword($passwordhash->HashPassword($pas));

$user->insert();
// need restart apache
