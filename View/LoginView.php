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
	    <div class="error"><?php echo $this->error ?></div>
	    <?php
	    endif;
	    ?>
	    <form action="user.php?a=checkPassword" method="post">
		<label for="login">Identifiant</label>
		<input type="text" id="login" name="login" /><br />
		<label for="password">Mot de passe</label>
		<input type="password" name="password" id="password" />
		<input type="submit" />
	    </form>
	</section>
	<?php
    }
        
}
