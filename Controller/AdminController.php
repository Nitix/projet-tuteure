<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author Guillaume
 */
class AdminController extends Controller {

    // Liste des actions d'un admin
    static $actions = array(
        'nouveauDocument' => 'nouveauDocument',
        'modifierDocument' => 'modifierDocument',
        'enregistrerDocument' => 'enregistrerDocument',
        'nouvelleCategorie' => 'nouvelleCategorie',
        'modifierCategorie' => 'modifierCategorie',
        'enregistrerCategorie' => 'enregistrerCategorie',
        'modifierAccueil' => 'modifierAccueil',
        'listDocuments' => 'listDocuments',
        'listCategories' => 'listCategories',
        'nouveauAdmin' => 'nouveauAdmin',
        'modifierAdmin' => 'modifierAdmin',
        'enregistrerAdmin' => 'enregistrerAdmin',
        'enregistrerNouveauAdmin' => 'enregistrerNouveauAdmin'
    );
    static $allowedTags = "<div><p><h1><h2><h3><h4><h5><h6><ul><ol><li><dl><dt><dd><address><hr><pre><blockquote><center><ins><del><a><span><bdo><br><em><strong><dfn><code><samp><kbd><bar><cite><abbr><acronym><q><sub><sup><tt><i><b><big><small><u><s><strike><basefont><font><object><param><img><table><caption><colgroup><col><thead><tfoot><tbody><tr><th><td><embed>";

    public function home() {
        $view = new HomeAdminView();
        $view->displayPage();
    }

    public function nouveauDocument() {
        $view = new NouveauDocumentAdminView();
        $view->displayPage();
    }

    public function modifierDocument() {
        if (isset($_GET['id'])) {
            $document = Document::findByID($_GET['id']);
            if ($document == null) {
                $view = new ErrorAdminView("Document non trouvé");
                $view->displayPage();
            } else {
                $view = new DocumentAdminView($document);

                $view->DisplayPage();
            }
        } else {
            $view = new ErrorAdminView("Requete incorrect");
            $view->displayPage();
        }
    }

    public function enregistrerDocument() {
        if (isset($_POST['jeton']) && $_SESSION[PREFIX . 'jeton'] == $_POST['jeton']) {
            if (isset($_POST['id'])) {
                $document = Document::findByID($_POST['id']);
                if ($document == null) {
                    $view = new ErrorAdminView("Le document modifié n'existe pas");
                    $view->displayPage();
                } else {
                    $this->modifierInformationsDocument($document);
                    $document->update();
                    $view = new OkAdminView("Le document a bien été mis à jour");
                    $view->displayPage();
                }
            } else {
                $document = new Document();
                if(isset($_FILES["cours"])){
                    $this->modifierInformationsDocument($document);
                    $document->insert();
                    $view = new OkAdminView("Le document a bien été ajouté");
                    $view->displayPage();
                }else{
                    $view = new ErrorAdminView("Fichier Manquant");
                    $view->displayPage();
                }
            }
        } else {
            $view = new ErrorAdminView("Jeton incorrect, tentative de CRSF detecté, abondon de l'ajout");
            $view->displayPage();
        }
    }

    private function modifierInformationsDocument(Document $document) {
        $document->setAdministrateur_id($_SESSION[PREFIX . 'user']);
        if( $_POST['autorisation'] != 0 && !isset($_POST['always'])){
            $date = DateTime::CreateFromFormat('d/m/Y', $_POST['autorisation']);
            $document->setAutorisation(date('Y-m-d', $date->getTimestamp()));
        }else{
            $document->setAutorisation(0);
        }
        if($document->getID() == 1){
            $document->setContenu(strip_tags($_POST['contenu'], static::$allowedTags));
        }else{
            if(isset($_FILES["cours"]) && $_FILES["cours"]["error"] == 0){
                $contenu = $document->getContenu();
                if(!empty($contenu))
                    unlink($document->getContenu());
                $ran = rand () ;
                move_uploaded_file($_FILES["cours"]["tmp_name"],
                    "pdf/" .  $ran . $_FILES["cours"]["name"]."");
                $document->setContenu("pdf/" .  $ran . $_FILES["cours"]["name"]);
            }
        }
        $document->setNom(htmlspecialchars($_POST['nom']));
        $document->setCategorie_id($_POST['categorie_id']);
    }

    public function nouvelleCategorie() {
        $view = new NouvelleCategorieAdminView();
        $view->displayPage();
    }

    public function modifierCategorie() {
        if (isset($_GET['id'])) {
            $categorie = Categorie::findByID($_GET['id']);
            if ($categorie == null) {
                $view = new ErrorAdminView("Catégorie non trouvé");
                $view->displayPage();
            } else {
                $view = new CategorieAdminView($categorie);
                $view->DisplayPage();
            }
        } else {
            $view = new ErrorAdminView("Requete incorrect");
            $view->displayPage();
        }
    }

    public function enregistrerCategorie() {
        if ($_SESSION[PREFIX . 'jeton'] == $_POST['jeton']) {
            if (isset($_POST['id'])) {
                $categorie = Categorie::findByID($_GET['id']);
                if ($categorie == null) {
                    $view = new ErrorAdminView("Le categorie modifié n'existe pas'");
                    $view->displayPage();
                } else {
                    $this->modifierInformationsCategorie($categorie);
                    $categorie->update();
                    $view = new OkAdminView("La catégorie a bien été mise à jour");
                    $view->displayPage();
                }
            } else {
                $categorie = new Categorie();
                $this->modifierInformationsCategorie($categorie);
                $categorie->insert();
                $view = new OkAdminView("La catégorie a bien été ajoutée");
                $view->displayPage();
            }
        } else {
            $view = new ErrorAdminView("CSRF detecté");
            $view->displayPage();
        }
    }

    private function modifierInformationsCategorie(Categorie $categorie) {
        $categorie->setNom(htmlspecialchars($_POST['nom']));
    }

    public function modifierAccueil() {
        $document = Document::findByID(1);
        $view = new ModifierAccueilAdminView($document);
        $view->displayPage();
    }

    public function listDocuments() {
        $documents = Categorie::findDocumentsByCategorie();
        $view = new ListDocumentsAdminView($documents);
        $view->displayPage();
    }

    public function listCategories() {
        $categorie = Categorie::findAll();
        $view = new ListCategoriesAdminView($categorie);
        $view->displayPage();
    }

    public function nouveauAdmin($error = null) {
        $view = new NouveauAdministrateurAdminView($error);
        $view->displayPage();
    }

    public function enregistrerAdmin() {
        if ($_SESSION[PREFIX . 'jeton'] == $_POST['jeton']) {
            if (!empty($_POST['login']) && !empty($_POST['nom']) && !empty($_POST['prenom'])) {
                $usercont = new UserController();
                $admin = $usercont->getUser();
                if (!Administrateur::exist($_POST['login']) || $admin->getLogin() == $_POST['login']) {
                    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                        if ($admin == null) {
                            $view = new ErrorAdminView("Connexion perdue");
                            $view->displayPage();
                        } else {
                            $password = $admin->getPassword();
                            if (!empty($_POST['confirm'])) {
                                if ($_POST['confirm'] == $_POST['password']) {
                                    $password = $_POST['confirm'];
                                    $passwordhash = new PasswordHash(10, false);
                                    $password = $passwordhash->HashPassword($password);
                                } else {
                                    $this->modifierAdmin("Mot de passe différent");
                                    return;
                                }
                            }
                            $this->modifierInformationsAdministrateur($admin, $password);
                            $admin->update();
                            $view = new OkAdminView("Vos informationsont été mis à jour");
                            $view->displayPage();
                        }
                    } else {
                        $this->modifierAdmin("Email incorrect");
                    }
                } else {
                    $this->modifierAdmin("Le nouveau login existe déjà");
                }
            } else {
                $this->modifierAdmin("Informations manquantes");
            }
        } else {
            $view = new ErrorAdminView("CSRF detecté");
            $view->displayPage();
        }
    }

    public function enregistrerNouveauAdmin() {
        if ($_SESSION[PREFIX . 'jeton'] == $_POST['jeton']) {
            if (!empty($_POST['login']) && !empty($_POST['nom']) && !empty($_POST['prenom'])) {
                if (!Administrateur::exist($_POST['login'])) {
                    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                        $admin = new Administrateur();
                        $password = $this->randomPassword();
                        $passwordhash = new PasswordHash(10, false);
                        $hash = $passwordhash->HashPassword($password);
                        $this->modifierInformationsAdministrateur($admin, $hash);
                        $admin->insert();
                        $expediteur = '=?UTF-8?B?'.base64_encode("Site Pédagogique") .'?=';
                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=UTF8' . "\r\n";
                        $headers .= 'From: '.$expediteur.' <no-reply@iecn.u-nancy.fr>' . '\r\n';
                        if (mail($_POST['email'], 'Identifiants de connexion', "Vous êtes inscrit en tant qu'administrateur au site pédagogique<br /><br />"
                            . "Identifiant : " . $_POST['login'] . "<br />Mot de passe : " . $password .
                            '<br /><br />Pour des mesures de sécurités, veuillez changer ce mot de passe.<br />'
                            . '<a href="http://iecl.univ-lorraine.fr/SitePedagogique/">http://iecl.univ-lorraine.fr/SitePedagogique/</a>', $headers)) {
                            $view = new OkAdminView("L'administrateur a bien été ajouté, il recevra par email son mot de passe");
                        } else {
                            $view = new OkAdminView("L'administrateur a bien été ajouté, erreur lors de l'envoi du mail, voici son mote de passe : " . $password);
                        }
                        $view->displayPage();
                    } else {
                        $this->nouveauAdmin("Email incorrect");
                    }
                } else {
                    $this->nouveauAdmin("Le login existe déjà");
                }
            } else {
                $this->nouveauAdmin("Informations manquantes");
            }
        } else {
            $view = new ErrorAdminView("CSRF detecté");
            $view->displayPage();
        }
    }

    private function modifierInformationsAdministrateur(Administrateur $admin, $password) {
        $admin->setEmail(htmlspecialchars($_POST['email']));
        $admin->setLogin(htmlspecialchars($_POST['login']));
        $admin->setPassword($password);
        $admin->setNom(htmlspecialchars($_POST['nom']));
        $admin->setPrenom(htmlspecialchars($_POST['prenom']));
    }

    public function modifierAdmin($error = null) {
        $usercontroller = new UserController();
        $user = $usercontroller->getUser();
        $view = new ModifierAdministrateurAdmin($user, $error);
        $view->displayPage();
    }

    private function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}
