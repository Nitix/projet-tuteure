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

    static $actions = array();

    public function home() {
	$view = new AdminView();
	$view->displayPage();
    }

}
