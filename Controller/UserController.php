<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author Guillaume
 */
class UserController extends Controller {

    static $actions = array(
        'login' => 'login',
        'logout' => 'logout',
        'checkPassword' => 'checkPassword'
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

}
