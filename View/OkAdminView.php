<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OkAdminView
 *
 * @author Guillaume
 */
class OkAdminView extends AdminView {

    public function __construct() {
	parent::__construct("Requete effectuée avec succès");
    }

    public function body() {
	?>
	<section>
	    La requete à été effectuée avec succès
	</section>
	<?php

    }

}
