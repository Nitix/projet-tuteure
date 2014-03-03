<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConnectedView
 *
 * @author Guillaume
 */
class ConnectedView extends MainView {

    public function __construct() {
	parent::__construct('Connecté(e)');
    }

    public function body() {
	?>
	<section>Vous êtes maintenant connecté(e)</section>
	<?php

    }

}
