<?php

require_once 'common.php';

//A remettre à zéro après ajout
$passwordhash = new PasswordHash(10, false);
$user = new Administrateur();
$user->setLogin($login);
$user->setNom($nom);
$user->setPrenom($prenom);
$user->setPassword($passwordhash->HashPassword($password));

