<?php

require_once 'common.php';

$passwordhash = new PasswordHash(10, false);

//A remettre à zéro après ajout
$user = new Administrateur();
$user->setLogin("");
$user->setNom("");
$user->setPrenom("");
$user->setPassword($passwordhash->HashPassword("mot de passe"));

$user->insert();
// need restart apache
