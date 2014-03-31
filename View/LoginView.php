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
	<section class="paddingSection">
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
	    <form action="/<?php echo BASE?>User/checkPassword" method="post" role="form">
		<div class="form-group">
		    <label for="login" class="control-label">Identifiant</label>
			<input type="text" id="login" name="login" autofocus="true" class="form-control" placeholder="Identifiant"/>
		</div>
		
		<div class="form-group">
		    <label for="password" class="control-label">Mot de passe</label>
			<input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe"/>
		</div>
		
		<div class="form-group">
			<button type="submit" class="btn btn-default">Se connecter</button>
            <a href="/<?php echo BASE?>User/MotDePassePerdu"><button class="btn btn-default" type="button">Mot de passe perdu</button></a>
        </div>
	    </form>
	</section>
	<?php
    }

}
