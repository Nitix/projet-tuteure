<?php

/**
 * Description of UserController
 *
 * @author Guillaume
 */
class UserController extends Controller {

    static $actions = array(
        'login' => 'login',
        'logout' => 'logout',
        'checkPassword' => 'checkPassword',
        'MotDePassePerdu' => 'motDePassePerdu',
        'VerifierMotDePassePerdu' => 'verifierMotDePassePerdu',
        'enregistrerMotDePasse' => 'enregistrerMotDePasse',
        'resetPassword' => 'resetPassword'

    );

    public function home() {
        $this->login();
    }

    public function isConnected() {
        if(isset($_SESSION[PREFIX . "user"]))
            return true;
        if (isset($_COOKIE['login'])) {
            $cookie = unserialize($_COOKIE['login']);
            $admin = Administrateur::findByID($cookie['id']);
            if ($admin->getCookie() == $cookie['key']) {
                $this->registerUserToSession($admin);
                return true;
            } else {
                setcookie('login', '', time());
            }
        }
        return false;
    }

    public function login($error = NULL) {
        if ($this->isConnected()) {
            $view = new ConnectedView();
            $view->displayPage();
        } else {
            $view = new LoginView($error);
            $view->displayPage();
        }
    }

    public function checkPassword() {
        if (isset($_POST['login']) && isset($_POST['password'])) {
            $admin = Administrateur::findByLogin($_POST['login']);
            if ($admin != null) {
                $passwordHash = new PasswordHash(10, FALSE);
                if ($passwordHash->CheckPassword($_POST['password'], $admin->getPassword())) {
                    $this->registerUserToSession($admin);
                    $view = new ConnectedView();
                    $view->displayPage();
                } else {
                    $this->login("Identifiant ou mot de passe incorrect");
                }
            } else {
                $this->login("Identifiant ou mot de passe incorrect");
            }
        } else {
            $this->login("Nice try");
        }
    }

    private function registerUserToSession(Administrateur $admin) {
        $_SESSION[PREFIX . 'user'] = $admin->getID();
        $key = hash('sha256', uniqid());
        $cookie = array(
            'id' => $admin->getID(),
            'key' => $key
        );
        //Expiration dans un mois
        setcookie('login', serialize($cookie), time() + 2592000, '/'.BASE);
        $admin->setCookie($key);
        $admin->update();
    }

    public function logout() {
        if($this->isConnected()){
            setcookie('login', '', time());
            $admin = Administrateur::findByID($_SESSION[PREFIX . 'user']);
            $admin->setCookie(null);
            $admin->update();
            session_destroy();
            session_start();
        }
        $view = new LogoutView();
        $view->displayPage();
    }

    public function getUser() {
        if (!$this->isConnected()) {
            return null;
        }
        return Administrateur::findByID($_SESSION[PREFIX . 'user']);
    }

    public function motDePassePerdu($error = null){
        $view = new MotDePassePerduView($error);
        $view->displayPage();
    }

    public function verifierMotDePassePerdu(){
        if(isset($_POST['email']) && isset($_POST['login'])){
            $admin = Administrateur::findByLogin($_POST['login']);
            if($admin != null && strtolower($admin->getEmail()) == strtolower($_POST['email'])){
                $resetlink = hash('sha256', uniqid());
                $admin->setResetLink($resetlink);
                $admin->update();
                $expediteur = '=?UTF-8?B?'.base64_encode("Site Pédagogique") .'?=';
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=UTF8' . "\r\n";
                $headers .= 'From: '.$expediteur.' <no-reply@iecn.u-nancy.fr>' . '\r\n';
                if (mail($admin->getEmail(), 'Perte de mot de passe', "Si vous n'avez pas fait de requête de perte de mot de passe vous pouvez ignorer ce message, votre mot de passe ne sera pas changé.<br /><br />"
                    .'Cliquez sur ce lien pour changer de mot de passe : <a href="http://iecl.univ-lorraine.fr/SitePedagogique/User/resetPassword/'.$admin->getID().'/'.$resetlink.'">Changer de mot de passe</a><br /><br />'
                    . '<a href="http://iecl.univ-lorraine.fr/SitePedagogique/">http://iecl.univ-lorraine.fr/SitePedagogique/</a>', $headers)) {
                    $view = new OkView("Vous allez recevoir votre demande de réinitialisation par email");
                    $view->displayPage();
                } else {
                    $this->motDePassePerdu("Erreur lors de l'envoi du l'email");
                }
            }else{
                $this->motDePassePerdu("Combinaison incorrect");
            }
        }else{
            $view = new ErrorDocumentView("informations manquantes");
            $view->displayPage();
        }
    }

    public function resetPassword(){
        if(isset($_GET['id']) &&  isset($_GET['link'])){
            $admin = Administrateur::findByID($_GET['id']);
            if($admin != null && $admin->getResetLink() == $_GET['link']){
                $_SESSION[PREFIX.'id'] = $admin->getID();
                $_SESSION[PREFIX.'isResetting'] = true;
                $view = new ModifierMotDePasseView();
                $view->displayPage();
            }else{
                $view = new ErrorDocumentView("Administrateur ou lien de réinitialisation est incorrect");
                $view->displayPage();
            }
        }else{
            $view = new ErrorDocumentView("Nope");
            $view->displayPage();
        }
    }

    public function enregistrerMotDePasse(){
        if(isset($_POST['password']) && isset($_POST['confirm'])){
            if(isset($_SESSION[PREFIX.'isResetting']) && $_SESSION[PREFIX.'isResetting']){
                if($_POST['password'] == $_POST['confirm']){
                    $admin = Administrateur::findByID($_SESSION[PREFIX.'id']);
                    $passwordhash = new PasswordHash(10, false);
                    $hash = $passwordhash->HashPassword($_POST['password']);
                    $admin->setPassword($hash);
                    $admin->setResetLink("");
                    $admin->update();
                    $expediteur = '=?UTF-8?B?'.base64_encode("Site Pédagogique") .'?=';
                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=UTF8' . "\r\n";
                    $headers .= 'From: '.$expediteur.' <no-reply@iecn.u-nancy.fr>' . '\r\n';
                    if (mail(admin->getEmail(), 'Mot de passe changé', 'Votre mot de passe a été changé<br /><br />'
                        . '<a href="http://iecl.univ-lorraine.fr/SitePedagogique/">http://iecl.univ-lorraine.fr/SitePedagogique/</a>', $headers)) {
                        $view = new OkView("Votre mot de passe a été changé");
                        $view->displayPage();
                    } else {
                        $view = new OkView("Votre mot de passe a été changé");
                        $view->displayPage();
                    }
                }else{
                    $view = new ModifierMotDePasseView("Les mots de passe ne correspondent pas");
                    $view->displayPage();
                }
            }else{
                $view = new ErrorDocumentView("Tentative de changement de mote de passe non autorisé");
                $view->displayPage();
            }
        }else{
            $view = new ErrorDocumentView("Nope");
            $view->displayPage();
        }
    }
}
