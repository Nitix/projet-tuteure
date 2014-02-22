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
     * @var int Identifiant du document
     */
    private $id;

    /**
     * @var String Nom du document
     */
    private $nom;

    /**
     * @var String Contenu du document
     */
    private $contenu;

    /**
     * @var String Date ou le document pourra être affiché
     */
    private $autorisation;

    /**
     * @var int Type du document
     */
    private $type_id;

    /**
     * @var int Créateur du document
     */
    private $administrateur_id;

    /**
     * Met à jour le document actuel
     * @throw PrimaryKeyNotValidException Identifiant non instancié
     */
    public function update() {
        if (!isset($this->id)) {
            throw new PrimaryKeyNotValidException(__CLASS__ . ": Primary Key undefined : cannot update");
        }
        $pdo = Base::getConnection();

        $query = $pdo->prepare('UPDATE Document SET nom=:nom, contenu=:contenu, autorisation=:autorisation, type_id=:type_id, administrateur_id=:administrateur_id where id=:id');

        $query->bindParam(':nom', $this->nom, PDO::PARAM_STR);
        $query->bindParam(':contenu', $this->contenu, PDO::PARAM_STR);
        $query->bindParam(':autorisation', $this->autorisation, PDO::PARAM_STR);
        $query->bindParam(':type_id', $this->type_id, PDO::PARAM_INT);
        $query->bindParam(':administrateur_id', $this->administrateur_id, PDO::PARAM_INT);
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

        $query = $pdo->prepare('INSERT INTO Document(nom, contenu, autorisation, type_id, administrateur_id) VALUES(:nom, :contenu, :autorisation, :type_id, :administrateur_id)');

        $query->bindParam(':nom', $this->nom, PDO::PARAM_STR);
        $query->bindParam(':contenu', $this->contenu, PDO::PARAM_STR);
        $query->bindParam(':autorisation', $this->autorisation, PDO::PARAM_STR);
        $query->bindParam(':type_id', $this->type_id, PDO::PARAM_INT);
        $query->bindParam(':administrateur_id', $this->administrateur_id, PDO::PARAM_INT);

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
     * Met à jour l'attribut contenu
     * @param String $contenu valeur à définir
     */
    public function setContenu($contenu) {
        $this->contenu = $contenu;
    }

    /**
     * Met à jour l'attribut autorisation
     * @param String $autorisation valeur à définir
     */
    public function setAutorisation($autorisation) {
        $this->autorisation = $autorisation;
    }

    /**
     * Met à jour l'attribut type_id
     * @param int $type_id valeur à définir
     */
    public function setType_id($type_id) {
        $this->type_id = $type_id;
    }

    /**
     * Met à jour l'attribut administrateur_id
     * @param int $administrateur_id valeur à définir
     */
    public function setAdministrateur_id($administrateur_id) {
        $this->administrateur_id = $administrateur_id;
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
     * Retourne l'attribut contenu
     */
    public function getContenu() {
        return $this->contenu;
    }

    /**
     * Retourne l'attribut autorisation
     */
    public function getAutorisation() {
        return $this->autorisation;
    }

    /**
     * Retourne l'attribut type_id
     */
    public function getType_id() {
        return $this->type_id;
    }

    /**
     * Retourne l'attribut administrateur_id
     */
    public function getAdministrateur_id() {
        return $this->administrateur_id;
    }

    /**
     * Recherche un document dans la bdd à partir de son identifiant
     * @param int $id identifiant du document
     * @return \Document Document récupéré de la base de donnée
     * @throws SQLException Erreur lors de la requete
     */
    public static function findByID($id) {
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
        $document->setId($row['id']);
        $document->setNom($row['nom']);
        $document->setContenu($row['contenu']);
        $document->setAutorisation($row['autorisation']);
        $document->setType_id($row['type_id']);
        $document->setAdministrateur_id($row['administrateur_id']);
        return $document;
    }

    /**
     * Retourne tout les documents de la base de données
     * @return \Document[] documents dans la base de données
     * @throws SQLException Erreur lors de la requete
     */
    public static function findALL() {
        $pdo = Base::getConnection();

        $query = $pdo->prepare("Select * from DOCUMENT");
        $res = $query->execute();
        if (!res) {
            throw new SQLException('Requete non execute correctement');
        }
        $documents = array();
        while ($row = $query->fetch()) {
            $document = new Document();
            $document->setId($row['id']);
            $document->setNom($row['nom']);
            $document->setContenu($row['contenu']);
            $document->setAutorisation($row['autorisation']);
            $document->setType_id($row['type_id']);
            $document->setAdministrateur_id($row['administrateur_id']);
            $documents[] = $document;
        }
        return $documents;
    }

    /**
     * Retourne la liste des documents disponible 
     * @return \Document[]  documents disponibles
     * @throws SQLException Erreur lors de la requete
     */
    public static function findAvailable() {
        $pdo = Base::getConnection();

        $query = $pdo->prepare('Select * from document where autorisation <= ate(\'nom\')');
        $res = $query->execute();
        if (!res) {
            throw new SQLException('Requete non execute correctement');
        }
        $documents = array();
        while ($row = $query->fetch()) {
            $document = new Document();
            $document->setId($row['id']);
            $document->setNom($row['nom']);
            $document->setContenu($row['contenu']);
            $document->setAutorisation($row['autorisation']);
            $document->setType_id($row['type_id']);
            $document->setAdministrateur_id($row['administrateur_id']);
            $documents[] = $document;
        }
        return $documents;
    }

    /**
     * Recherche un document dans la bdd à partir de son identifiant
     * @param int $id identifiant du document
     * @return \Document Document récupéré de la base de donnée
     * @throws SQLException Erreur lors de la requete
     */
    public static function findByType_ID($id) {
        $pdo = Base::getConnection();

        $query = $pdo->prepare("Select * From Document where type_id=:id");
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
        $document->setId($row['id']);
        $document->setNom($row['nom']);
        $document->setContenu($row['contenu']);
        $document->setAutorisation($row['autorisation']);
        $document->setType_id($row['type_id']);
        $document->setAdministrateur_id($row['administrateur_id']);
        return $document;
    }

}
