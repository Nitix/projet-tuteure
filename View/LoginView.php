<?php

/**
 * Description of LoginView
 *
 * @author Guillaume
 */
class LoginView extends MainView {

    private $error;

    public function __construct($error = null) {
	parent::__construct("Connexion");
	$this->error = $error;
    }

    public function body() {
	?>
	<section>
	    <?php
	    if ($this->error != null) :
		?>
	        <div class="alert alert-danger alert-dismissable" id="alert">
	    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	    	<strong>Erreur !</strong> <?php echo $this->error ?>
	        </div>
		<?php
	    endif;
	    ?>
	    <form action="/<?php echo BASE?>User/checkPassword" method="post" class="form-horizontal" role="form">
		<div class="form-group">
		    <label for="login" class="col-sm-2 col-lg-1 control-label">Identifiant</label>
		    <div class="col-sm-10  col-lg-11 ">
			<input type="text" id="login" name="login"  class="form-control" placeholder="Identifiant"/><br />
		    </div>
		</div>
		
		<div class="form-group">
		    <label for="password" class="col-sm-2 col-lg-1 control-label">Mot de passe</label>
		    <div class="col-sm-10 col-lg-11">
			<input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe"/>
		    </div>
		</div>
		
		<div class="form-group">
		    <div class="col-sm-offset-3 col-lg-offset-1 col-sm-10 col-lg-11">
			<button type="submit" class="btn btn-default">Se connecter</button>
		    </div>
		</div>
	    </form>
	</section>
	<?php
    }

}
