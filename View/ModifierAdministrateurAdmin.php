<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModifierAdministrateurAdmin
 *
 * @author Guillaume
 */
class ModifierAdministrateurAdmin extends AdminView {

    private $error;
    private $admin;

    public function __construct(Administrateur $admin, $error = null) {
	parent::__construct("Modification administrateur");
	$this->admin = $admin;
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
	    <form action="admin.php?a=enregistrerAdmin" method="post" class="form-horizontal" role="form">
		<input type="hidden" name="jeton" value="<?php echo $_SESSION[PREFIX . 'jeton'] ?>" />
		<div class="alert alert-info alert-dismissable" id="success">
		    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		    Un identifiant doit être unique
		</div>

		<div class="form-group">
		    <label for="changelogin" class="col-sm-2 col-lg-1 control-label">Identifiant 
			<span class="glyphicon glyphicon-ok ok" style="display: none"></span>
			<span class="glyphicon glyphicon-remove remove" style="display: none"></span>
		    </label>
		    <div class="col-sm-10  col-lg-11 ">
			<input type="text" id="changelogin" name="login"  class="form-control" value="<?php echo $this->admin->getLogin() ?>"/>
		    </div>
		</div>
		<div class="form-group">
		    <label for="nom" class="col-sm-2 col-lg-1 control-label">Nom</label>
		    <div class="col-sm-10 col-lg-11">
			<input type="text" name="nom" id="nom" class="form-control" value="<?php echo $this->admin->getNom() ?>"/>
		    </div>
		</div>
		<div class="form-group">
		    <label for="prenom" class="col-sm-2 col-lg-1 control-label">Prénom</label>
		    <div class="col-sm-10 col-lg-11">
			<input type="text" name="prenom" id="prenom" class="form-control" value="<?php echo $this->admin->getPrenom() ?>"/>
		    </div>
		</div>		
		<div class="form-group">
		    <label for="email" class="col-sm-2 col-lg-1 control-label">Email
			<span class="glyphicon glyphicon-ok ok-email" style="display: none"></span>
			<span class="glyphicon glyphicon-remove remove-email" style="display: none"></span>
		    </label>
		    <div class="col-sm-10 col-lg-11">
			<input type="text" name="email" id="email" class="form-control" value="<?php echo $this->admin->getEmail() ?>"/>
		    </div>
		</div>
		<div class="form-group">
		    <label for="password" class="col-sm-2 col-lg-1 control-label">Nouveau mot de passe
		    </label>
		    <div class="col-sm-10 col-lg-11">
			<input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe"/>
		    </div>
		</div>
		<div class="form-group">
		    <label for="confirm" class="col-sm-2 col-lg-1 control-label">Confirmation
			<span class="glyphicon glyphicon-ok ok-password" style="display: none"></span>
			<span class="glyphicon glyphicon-remove remove-password" style="display: none"></span>
		    </label>
		    <div class="col-sm-10 col-lg-11">
			<input type="password" name="confirm" id="confirm" class="form-control" placeholder="Mot de passe"/>
		    </div>
		</div>
		<div class="form-group">
		    <div class="col-sm-offset-3 col-lg-offset-1 col-sm-10 col-lg-11">
			<button type="submit" class="btn btn-default">Enregistrer l'administrateur</button>
		    </div>
		</div>
	    </form>
	</section>
	<?php
    }

//put your code here
}
