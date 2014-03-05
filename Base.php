<?php

include ('database.php');

/**
 * Gere la connection avec la bdd 
 */
class Base {

    /**
     * Connection en cours
     */
    public static $db;

    /**
     * Retourne la connection, en crée une si besoin
     * @return PDO connexion
     */
    static public function getConnection() {
	if (isset($db)) {
	    return $db;
	} else {
	    try {
		$dsn = 'sqlite:' . Database::$file;
		$db = new PDO($dsn, null, null, array(PDO::ATTR_ERRMODE => true, PDO::ERRMODE_EXCEPTION => true, PDO::ATTR_PERSISTENT => true));
		return $db;
	    } catch (PDOException $e) {
		echo $e->getMessage();
		exit();
	    }
	}
    }

}
