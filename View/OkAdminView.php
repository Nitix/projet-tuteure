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

    private $message;

    public function __construct($message = "La requête e été executé correctement") {
	parent::__construct("Succès de l'opération");
	$this->message = $message;
    }

    public function body() {
	?>
	<section class="paddingSection">
	    <?php echo $this->message ?>
	</section>
	<?php

    }

}
