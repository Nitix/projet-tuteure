<?php

/**
 * Classe de categorie active record sur la table Administrateur
 * Gére la table Administrateur, une ligne correspond à un objet de cette classe
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
class Administrateur {

    /**
     * @var int Identifiant de l'administrateur
     */
    private $id;

    /**
     * @var String Login de l'administrateur
     */
    private $login;

    /**
     * @var String Password de l'administrateur
     */
    private $password;

    /**
     * @var String nom de l'administrateur
     */
    private $nom;

    /**
     * @var String prenom de l'administrateur
     */
    private $prenom;

    /**
     * @var String dernier cookie de l'administrateur
     */
    private $cookie;

    /**
     * Met à jour l' adminstrateur actuel
     * @throw PrimaryKeyNotValidException Identifiant non instancié
     */
    public function update() {
	if (!isset($this->id)) {
	    throw new PrimaryKeyNotValidException(__CLASS__ . ": Primary Key undefined : cannot update");
	}
	$pdo = Base::getConnection();

	$query = $pdo->prepare('UPDATE Administrateur SET login=:login, password=:password, nom=:nom, prenom=:prenom, cookie=:cookie where id=:id');

	$query->bindParam(':login', $this->login, PDO::PARAM_STR);
	$query->bindParam(':password', $this->password, PDO::PARAM_STR);
	$query->bindParam(':nom', $this->nom, PDO::PARAM_STR);
	$query->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
	$query->bindParam(':cookie', $this->cookie, PDO::PARAM_STR);
	$query->bindParam(':id', $this->id, PDO::PARAM_INT);

	return $query->execute();
    }

    /**
     * Insere l' adminstrateur actuel
     * @throw PrimaryKeyNotValidException Identifiant déjà instancié
     * 	 */
    public function insert() {
	if (isset($this->id)) {
	    throw new PrimaryKeyNotValidException(__CLASS__ . ": Primary Key defined : cannot insert");
	}

	$pdo = Base::getConnection();

	$query = $pdo->prepare('INSERT INTO Administrateur(login, password, nom, prenom, cookie) VALUES(:login, :password, :nom, :prenom, :cookie)');

	$query->bindParam(':login', $this->login, PDO::PARAM_STR);
	$query->bindParam(':password', $this->password, PDO::PARAM_STR);
	$query->bindParam(':nom', $this->nom, PDO::PARAM_STR);
	$query->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
	$query->bindParam(':cookie', $this->cookie, PDO::PARAM_STR);

	$nb = $query->execute();

	$this->id = $pdo->lastInsertId();
	return $nb;
    }

    /**
     * Supprime l' adminstrateur actuel de la base de données
     * @throw PrimaryKeyNotValidException Identifiant non instancié
     */
    public function delete() {
	if (!isset($this->id)) {
	    throw new PrimaryKeyNotValidException(__CLASS__ . ": Primary Key undefined : cannot delete");
	}

	$pdo = Base::getConnection();

	$query = $pdo->prepare('DELETE FROM Administrateur where id=:id');

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
     * Met à jour l'attribut login
     * @param String $login valeur à définir
     */
    public function setLogin($login) {
	$this->login = $login;
    }

    /**
     * Met à jour l'attribut password
     * @param String $password valeur à définir
     */
    public function setPassword($password) {
	$this->password = $password;
    }

    /**
     * Met à jour l'attribut nom
     * @param String $nom valeur à définir
     */
    public function setNom($nom) {
	$this->nom = $nom;
    }

    /**
     * Met à jour l'attribut prenom
     * @param int $prenom valeur à définir
     */
    public function setPrenom($prenom) {
	$this->prenom = $prenom;
    }

    /**
     * Met à jour l'attribut cookie
     * @param int $cookie valeur à définir
     */
    public function setCookie($cookie) {
	$this->cookie = $cookie;
    }

    /**
     * Retourne l'attribut id
     */
    public function getID() {
	return $this->id;
    }

    /**
     * Retourne l'attribut login
     */
    public function getLogin() {
	return $this->login;
    }

    /**
     * Retourne l'attribut password
     */
    public function getPassword() {
	return $this->password;
    }

    /**
     * Retourne l'attribut nom
     */
    public function getNom() {
	return $this->nom;
    }

    /**
     * Retourne l'attribut prenom
     */
    public function getPrenom() {
	return $this->prenom;
    }

    /**
     * Retourne l'attribut cookie
     */
    public function getCookie() {
	return $this->cookie;
    }

    /**
     * Recherche un adminstrateur dans la bdd à partir de son identifiant
     * @param int $id identifiant de l'administrateur
     * @return \Administrateur Administrateur récupéré de la base de donnée
     * @throws SQLException Erreur lors de la requete
     */
    public static function findByID($id) {
	$pdo = Base::getConnection();

	$query = $pdo->prepare("Select * From Administrateur where id=:id");
	$query->bindParam(':id', $id, PDO::PARAM_INT);
	$res = $query->execute();
	if (!$res) {
	    throw new SQLException('Requete non execute correctement');
	}

	$row = $query->fetch();
	if (!$row) {
	    return null;
	}
	$adminstrateur = new Administrateur();
	$adminstrateur->fetch($row);
	return $adminstrateur;
    }

    /**
     * Retourne tout les adminstrateurs de la base de données
     * @return \Administrateur[] adminstrateurs dans la base de données
     * @throws SQLException Erreur lors de la requete
     */
    public static function findALL() {
	$pdo = Base::getConnection();

	$query = $pdo->prepare("Select * from DOCUMENT");
	$res = $query->execute();
	if (!$res) {
	    throw new SQLException('Requete non execute correctement');
	}
	$adminstrateurs = array();
	while ($row = $query->fetch()) {
	    $adminstrateur = new Administrateur();
	    $adminstrateur->fetch($row);
	    $adminstrateurs[] = $adminstrateur;
	}
	return $adminstrateurs;
    }

    /**
     * Recherche un adminstrateur dans la bdd à partir de son login
     * @param String login de l'adminstrateur	
     * @return \Administrateur Administrateur récupéré de la base de donnée
     * @throws SQLException Erreur lors de la requete
     */
    public static function findByLogin($login) {
	$pdo = Base::getConnection();

	$query = $pdo->prepare("Select * From Administrateur where login=:login");
	$query->bindParam(':login', $login, PDO::PARAM_STR);
	$res = $query->execute();
	if (!$res) {
	    throw new SQLException('Requete non execute correctement');
	}
	$row = $query->fetch();
	if (!$row) {
	    return null;
	}
	$adminstrateur = new Administrateur();
	$adminstrateur->fetch($row);
	return $adminstrateur;
    }

    /**
     * Ajoute les attibuts aux adminstrateurs
     * @param categorie $row tableau contenant les informations de l'administrateurs
     */
    private function fetch($row) {
	$this->id = $row['id'];
	$this->login = $row['login'];
	$this->password = $row['password'];
	$this->nom = $row['nom'];
	$this->prenom = $row['prenom'];
	$this->cookie = $row['cookie'];
    }

}
