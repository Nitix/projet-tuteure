<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ErrorAdminView
 *
 * @author Guillaume
 */
class ErrorAdminView extends AdminView {

    private $error;

    public function __construct($error) {
	$this->error = $error;
    }

    public function body() {
	?>
	<section class="paddingSection">
	    <div class="alert alert-danger" id="alert">
		<strong>Erreur !</strong> <?php echo $this->error ?>
	    </div>
	</section>
	<?php
    }

//put your code here
}
