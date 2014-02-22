<?php

/**
 * Classe de type active record sur la table Type
 * Gére la table Type, une ligne correspond à un objet de cette classe
 * 
 * Un objet correspond à un ligne
 * 
 * Les fonctions statiques créent des objets de ce type
 * 
 * Des exceptions sont levés si les identifiants sont incorrect
 * 
 * @package Model
 * 
 */
class Type{

    /**
     * @var int Identifiant du Type
     */
    private $id;

    /**
     * @var String Nom du type
     */
    private $nom;

  
    /**
     * Met à jour le type actuel
     * @throw PrimaryKeyNotValidException Identifiant non instancié
     */
    public function update() {
        if (!isset($this->id)) {
            throw new PrimaryKeyNotValidException(__CLASS__ . ": Primary Key undefined : cannot update");
        }
        $pdo = Base::getConnection();

        $query = $pdo->prepare('UPDATE Type SET nom=:nom where id=:id');

        $query->bindParam(':nom', $this->nom, PDO::PARAM_STR);
        $query->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $query->execute();
    }

    /**
     * Insere le type actuel
     * @throw PrimaryKeyNotValidException Identifiant déjà instancié
     * 	 */
    public function insert() {
        if (isset($this->id)) {
            throw new PrimaryKeyNotValidException(__CLASS__ . ": Primary Key defined : cannot insert");
        }

        $pdo = Base::getConnection();

        $query = $pdo->prepare('INSERT INTO Type(nom) VALUES(:nom)');

        $query->bindParam(':nom', $this->nom, PDO::PARAM_STR);
        $nb = $query->execute();

        $this->id = $pdo->lastInsertId();
        return $nb;
    }

    /**
     * Supprime le type actuel de la base de données
     * @throw PrimaryKeyNotValidException Identifiant non instancié
     */
    public function delete() {
        if (!isset($this->id)) {
            throw new PrimaryKeyNotValidException(__CLASS__ . ": Primary Key undefined : cannot delete");
        }

        $pdo = Base::getConnection();

        $query = $pdo->prepare('DELETE FROM Type where id=:id');

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
     * Recherche un type dans la bdd à partir de son identifiant
     * @param int $id identifiant du type
     * @return \Type Type récupéré de la base de donnée
     * @throws SQLException Erreur lors de la requete
     */
    public static function findByID($id) {
        $pdo = Base::getConnection();

        $query = $pdo->prepare("Select * From Type where id=:id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $res = $query->execute();
        if (!$res) {
            throw new SQLException('Requete non execute correctement');
        }

        $row = $query->fetch();
        if (!$res) {
            return null;
        }
        $type = new Type();
        $type->setId($row['id']);
        $type->setNom($row['nom']);
        return $type;
    }

    /**
     * Retourne tout les types de la base de données
     * @return \Type[] types dans la base de données
     * @throws SQLException Erreur lors de la requete
     */
    public static function findALL() {
        $pdo = Base::getConnection();

        $query = $pdo->prepare("Select * from type");
        $res = $query->execute();
        if (!res) {
            throw new SQLException('Requete non execute correctement');
        }
        $types = array();
        while ($row = $query->fetch()) {
            $type = new Type();
            $type->setId($row['id']);
            $type->setNom($row['nom']);
            $types[] = $type;
        }
        return $types;
    }

}
