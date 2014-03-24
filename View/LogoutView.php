<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LogoutView
 *
 * @author Guillaume
 */
class LogoutView extends MainView {

    public function __construct() {
	parent::__construct('Déconnecté(e)');
    }

    public function body() {
	?>
	<section class="paddingSection">Vous êtes maintenant déconnecté(e)</section>
	<?php

    }

}
