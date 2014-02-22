<?php

/**
 * Classe de type active record sur la table Document
 * Gére la table Document, une ligne correspond à un objet de cette classe
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
class Document {

    /**
     * Identifiant du document
     * @var int
     */
    private $id;

    /**
     * Nom du document
     */
    private $nom;

    /**
     * Contenu du document
     */
    private $contenu;

    /**
     * Date ou le document pourra être affiché
     */
    private $autorisation;

    /**
     * Type du document
     */
    private $type_id;

    /**
     * Créateur du document
     */
    private $utilisateur_id;

    /**
     * Met à jour le document actuel
     * @throw PrimaryKeyNotValidException Identifiant non instancié
     */
    public function update() {
        if (!isset($this->id)) {
            throw new PrimaryKeyNotValidException(__CLASS__ . ": Primary Key undefined : cannot update");
        }
        $pdo = Base::getConnection();

        $query = $pdo->prepare('UPDATE Document SET nom=:nom, contenu=:contenu, autorisation=:autorisation, type_id=:type_id, utilisateur:utilisateur_id where id=:id');

        $query->bindParam(':nom', $this->nom, PDO::PARAM_STR);
        $query->bindParam(':contenu', $this->contenu, PDO::PARAM_STR);
        $query->bindParam(':autorisation', $this->autorisation, PDO::PARAM_STR);
        $query->bindParam(':type_id', $this->type_id, PDO::PARAM_INT);
        $query->bindParam(':utilisateur_id', $this->utilisateur_id, PDO::PARAM_INT);
        $query->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $query->execute();
    }

    /**
     * Insere le document actuel
     * @throw PrimaryKeyNotValidException Identifiant déjà instancié
     * 	 */
    public function insert() {
        if (isset($this->id)) {
            throw new PrimaryKeyNotValidException(__CLASS__ . ": Primary Key defined : cannot insert");
        }

        $pdo = Base::getConnection();

        $query = $pdo->prepare('INSERT INTO Document(nom, contenu, autorisation, type_id, utilisateur) VALUES(:nom, :contenu, :autorisation, :type_id, :utilisateur)');

        $query->bindParam(':nom', $this->nom, PDO::PARAM_STR);
        $query->bindParam(':contenu', $this->contenu, PDO::PARAM_STR);
        $query->bindParam(':autorisation', $this->autorisation, PDO::PARAM_STR);
        $query->bindParam(':type_id', $this->type_id, PDO::PARAM_INT);
        $query->bindParam(':utilisateur_id', $this->utilisateur_id, PDO::PARAM_INT);

        $nb = $query->execute();

        $this->id = $pdo->lastInsertId();
        return $nb;
    }

    /**
     * Supprime le document actuel de la base de données
     * @throw PrimaryKeyNotValidException Identifiant non instancié
     */
    public function delete() {
        if (!isset($this->id)) {
            throw new PrimaryKeyNotValidException(__CLASS__ . ": Primary Key undefined : cannot delete");
        }

        $pdo = Base::getConnection();

        $query = $pdo->prepare('DELETE FROM Document where id=:id');

        $query->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $query->execute();
    }

    /**
     * Met à jour l'attribut
     * @param string $attr_name nom attribut à mettre à jour
     * @param $attr_value valeur à définir
     * @throws ParameterException Attribut non existant
     */
    public function __set($attr_name, $attr_value) {
        if (!property_exists(__CLASS__, $attr_name)) {
            throw new ParameterException(__CLASS__ . " " . $attr_name . "does not exist, cannot set");
        }
        $this->$attr_name = $attr_value;
    }

    /**
     * Retourne l'attribut
     * @param string $attr_name nom de l'attribut
     * @return mixed valeur de l'attribut
     * @throws ParameterException Attribut non existant
     */
    public function __get($attr_name) {
        if (!property_exists(__CLASS__, $attr_name)) {
            throw new ParameterException(__CLASS__ . " " . $attr_name . "does not exist, cannot get");
        }
        return $this->$attr_name;
    }

    /**
     * Recherche un document dans la bdd à partir de son identifiant
     * @param int $id identifiant du document
     * @return \Document Document récupéré de la base de donnée
     * @throws SQLException Erreur lors de la requete
     */
    public function findByID($id) {
        $pdo = Base::getConnection();

        $query = $pdo->prepare("Select * From Document where id=:id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $res = $query->execute();
        if (!$res) {
            throw new SQLException('Requete non execute correctement');
        }

        $row = $query->fetch();
        if (!$res) {
            return null;
        }
        $document = new Document();
        $document->__set('id', $row['id']);
        $document->__set('nom', $row['nom']);
        $document->__set('contenu', $row['contenu']);
        $document->__set('autorisation', $row['autorisation']);
        $document->__set('type_id', $row['type_id']);
        $document->__set('utilisateur_id', $row['utilisateur_id']);
        return $document;
    }

    /**
     * Retourne tout les documents de la base de données
     * @return \Document[] documents dans la base de données
     * @throws SQLException Erreur lors de la requete
     */
    public function findALL() {
        $pdo = Base::getConnection();

        $query = $pdo->prepare("Select * from DOCUMENT");
        $res = $query->execute();
        if (!res) {
            throw new SQLException('Requete non execute correctement');
        }
        $documents = array();
        while ($row = $query->fetch()) {
            $document = new Document();
            $document->__set('id', $row['id']);
            $document->__set('nom', $row['nom']);
            $document->__set('contenu', $row['contenu']);
            $document->__set('autorisation', $row['autorisation']);
            $document->__set('type_id', $row['type_id']);
            $document->__set('utilisateur_id', $row['utilisateur_id']);
            $documents[] = $document;
        }
        return $documents;
    }

    /**
     * Retourne la liste des documents disponible 
     * @return \Document[]  documents disponibles
     * @throws SQLException Erreur lors de la requete
     */
    public function findAvailable() {
        $pdo = Base::getConnection();

        $query = $pdo->prepare('Select * from document where autorisation <= ate(\'nom\')');
        $res = $query->execute();
        if (!res) {
            throw new SQLException('Requete non execute correctement');
        }
        $documents = array();
        while ($row = $query->fetch()) {
            $document = new Document();
            $document->__set('id', $row['id']);
            $document->__set('nom', $row['nom']);
            $document->__set('contenu', $row['contenu']);
            $document->__set('autorisation', $row['autorisation']);
            $document->__set('type_id', $row['type_id']);
            $document->__set('utilisateur_id', $row['utilisateur_id']);
            $documents[] = $document;
        }
        return $documents;
    }

}
