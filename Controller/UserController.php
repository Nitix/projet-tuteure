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

    public function home() {
	$this->login();
    }

    public function isConnected() {
	if(isset($_COOKIE['login'])){
	    $admin = Administrateur::findByID($_COOKIE['login']['id']);
	    if($admin->getCookie() == $_COOKIE['login']['key']){
		$this->registerUserToSession($admin);
	    }else{
		setcookie('login', '', time());
	    }
	}
	return isset($_SESSION[PREFIX . "user"]);
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
    
    public function checkPassword(){
	if(isset($_POST['login']) && isset($_POST['password'])){
	    $admin = Administrateur::findByLogin($_POST['login']);
	    if($admin != null){
		$passwordHash = new PasswordHash(10, FALSE);
		if($passwordHash->CheckPassword($_POST['password'], $admin->getPassword())){
		    $this->registerUserToSession($admin);
		}else{
		    $this->login("Identifiant ou mot de passe incorrect");
		}
	    }else{
		$this->login("Identifiant ou mot de passe incorrect");
	    }
	}else{
	    $this->login("Nice try");
	}
    }

    private function registerUserToSession(Administrateur $admin){
	$_SESSION[PREFIX.'user'] = $admin->getID();
	$key = hash('sha256', uniqid());
	$cookie = array (
	    'id' => $admin->getID(),
	    'key' => $key
	);
	//Expiration dans un mois
	setcookie('login', $cookie, time()+60*60*24*30 );
	$admin->setCookie($key);
	$admin->update();
    }
    
    public function logout(){
	setcookie('login', '', time());
	$admin = Administrateur::findByID($_SESSION[PREFIX.'user']);
	$admin->setCookie(null);
	$admin->update();
	session_regenerate_id(TRUE);
	$view = new LogoutView();
	$view->displayPage();
    }
}
