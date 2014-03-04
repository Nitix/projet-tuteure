<?php

/**
 * Classe de categorie active record sur la table Categorie
 * Gére la table Categorie, une ligne correspond à un objet de cette classe
 * 
 * Un objet correspond à un ligne
 * 
 * Les fonctions statiques créent des objets de ce categorie
 * 
 * Des exceptions sont levés si les identifiants sont incorrect
 * 
 * @package Model
 * 
 */
class Categorie {

    /**
     * @var int Identifiant du Categorie
     */
    private $id;

    /**
     * @var String Nom du categorie
     */
    private $nom;

    /**
     * Met à jour le categorie actuel
     * @throw PrimaryKeyNotValidException Identifiant non instancié
     */
    public function update() {
	if (!isset($this->id)) {
	    throw new PrimaryKeyNotValidException(__CLASS__ . ": Primary Key undefined : cannot update");
	}
	$pdo = Base::getConnection();

	$query = $pdo->prepare('UPDATE Categorie SET nom=:nom where id=:id');

	$query->bindParam(':nom', $this->nom, PDO::PARAM_STR);
	$query->bindParam(':id', $this->id, PDO::PARAM_INT);

	return $query->execute();
    }

    /**
     * Insere le categorie actuel
     * @throw PrimaryKeyNotValidException Identifiant déjà instancié
     * 	 */
    public function insert() {
	if (isset($this->id)) {
	    throw new PrimaryKeyNotValidException(__CLASS__ . ": Primary Key defined : cannot insert");
	}

	$pdo = Base::getConnection();

	$query = $pdo->prepare('INSERT INTO Categorie(nom) VALUES(:nom)');

	$query->bindParam(':nom', $this->nom, PDO::PARAM_STR);
	$nb = $query->execute();

	$this->id = $pdo->lastInsertId();
	return $nb;
    }

    /**
     * Supprime le categorie actuel de la base de données
     * @throw PrimaryKeyNotValidException Identifiant non instancié
     */
    public function delete() {
	if (!isset($this->id)) {
	    throw new PrimaryKeyNotValidException(__CLASS__ . ": Primary Key undefined : cannot delete");
	}

	$pdo = Base::getConnection();

	$query = $pdo->prepare('DELETE FROM Categorie where id=:id');

	$query->bindParam(':id', $this->id, PDO::PARAM_INT);

	return $query->execute();
    }

    /**
     * Met à jour l'attribut id
     * @param int $id valeur à définir
     */
    public function setID($id) {
	$this->id = $id;
    }

    /**
     * Met à jour l'attribut nom
     * @param String $nom valeur à définir
     */
    public function setNom($nom) {
	$this->nom = $nom;
    }

    /**
     * Retourne l'attribut id
     */
    public function getID() {
	return $this->id;
    }

    /**
     * Retourne l'attribut nom
     */
    public function getNom() {
	return $this->nom;
    }

    /**
     * Recherche un categorie dans la bdd à partir de son identifiant
     * @param int $id identifiant du categorie
     * @return \Categorie Categorie récupéré de la base de donnée
     * @throws SQLException Erreur lors de la requete
     */
    public static function findByID($id) {
	$pdo = Base::getConnection();

	$query = $pdo->prepare("Select * From Categorie where id=:id");
	$query->bindParam(':id', $id, PDO::PARAM_INT);
	$res = $query->execute();
	if (!$res) {
	    throw new SQLException('Requete non execute correctement');
	}

	$row = $query->fetch();
	if (!$row) {
	    return null;
	}
	$categorie = new Categorie();
	$categorie->setId($row['id']);
	$categorie->setNom($row['nom']);
	return $categorie;
    }

    /**
     * Retourne tout les categories de la base de données
     * @return \Categorie[] categories dans la base de données
     * @throws SQLException Erreur lors de la requete
     */
    public static function findALL() {
	$pdo = Base::getConnection();

	$query = $pdo->prepare("Select * from categorie");
	$res = $query->execute();
	if (!$res) {
	    throw new SQLException('Requete non execute correctement');
	}
	$categories = array();
	while ($row = $query->fetch()) {
	    $categorie = new Categorie();
	    $categorie->setId($row['id']);
	    $categorie->setNom($row['nom']);
	    $categories[] = $categorie;
	}
	return $categories;
    }

    /**
     * Retourne tout les documents de la base de données
     * @return mixed documents triés par categorie
     * @throws SQLException Erreur lors de la requete
     */
    public static function findDocumentsByCategorie() {
	$pdo = Base::getConnection();

	$query = $pdo->prepare("Select * from categorie");
	$res = $query->execute();
	if (!$res) {
	    throw new SQLException('Requete non execute correctement');
	}
	$docs = array();
	while ($row = $query->fetch()) {
	    $categorie = new Categorie();
	    $categorie->setId($row['id']);
	    $categorie->setNom($row['nom']);
	    $docs[$row['id']]['categorie'] = $categorie;
	    $docs[$row['id']]['documents'] = Document::findByCategorie_ID($row['id']);
	}
	return $docs;
    }

    
        /**
     * Retourne tout les documents de la base de données
     * @return mixed documents triés par categorie
     * @throws SQLException Erreur lors de la requete
     */
    public static function findDocumentsByCategorieAndAvailable() {
	$pdo = Base::getConnection();

	$query = $pdo->prepare("Select * from categorie");
	$res = $query->execute();
	if (!$res) {
	    throw new SQLException('Requete non execute correctement');
	}
	$docs = array();
	while ($row = $query->fetch()) {
	    $categorie = new Categorie();
	    $categorie->setId($row['id']);
	    $categorie->setNom($row['nom']);
	    $docs[$row['id']]['categorie'] = $categorie;
	    $docs[$row['id']]['documents'] = Document::findByCategorie_IDAndAvailable($row['id']);
	}
	return $docs;
    }
}
