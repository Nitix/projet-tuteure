<?php

/**
 * Exception lancée quand la clé primaire n'est pas bonne pour les reqêtes sql
 * 
 * Il peut s'agir d'une erreur de clé primaire  (attribut) non existante pour 
 * la mise à jour ou la suppression ou alors un clé primaire déjà existante pour 
 * l'ajout de données
 * @package Model
 */
class PrimaryKeyNotValidException extends Exception {
    //Rien pour l'instant
}
