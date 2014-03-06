<?php

/**
 * Prépare toutes les configurations du site
 * 
 * Aucune classe n'est présente dans ce fichier
 * 
 * Contient l'autoloader des classes
 * Prépare la session et crée un jeton aléatoire de session
 */
//fonctions neccessaires au bon fonctionnement du site
//crée la session
session_start();
define('PREFIX', 'SitePedagogique');

//Crée un jeton si besoin
if (!isset($_SESSION[PREFIX .'jeton'])) {
    $_SESSION[PREFIX.'jeton'] = hash('sha256', uniqid());
}

//class loader des fonctions crée

/**
 * Autoloader des classes
 * 
 * Les fichiers doivent avoir le même nom que leur classe
 * 
 * @param string $classname nom de la classe à charger7
 * @ignore
 */
function loadClasses($classname) {
    // le répertoire d'installation de l'application
    if (is_file($classname . '.php')) {
	require_once $classname . '.php';
    }
    $myAppDirs = array('Controller', 'Model', 'View', 'lib');
    foreach ($myAppDirs as $cdir) {
	$filepath = $cdir . DIRECTORY_SEPARATOR . $classname . '.php';
	if (is_file($filepath)) {
	    require_once $filepath;
	}
    }
}

//enregistre le loader
spl_autoload_register('loadClasses');
