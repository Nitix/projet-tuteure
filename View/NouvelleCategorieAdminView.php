<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NouvelleCategorieView
 *
 * @author Guillaume
 */
class NouvelleCategorieAdminView extends AdminView {

    public function __construct() {
	parent::__construct("Nouvelle Catégorie");
    }

    public function body() {
	?>
	<section>
	    <form method="post" action="admin.php?a=enregistrerCategorie">
		<input type="hidden" name="jeton" value="<?php echo $_SESSION[PREFIX . 'jeton'] ?>" />
		<label for="nom">Nom de la catégorie :</label>
		<input type="text" id="nom" name="nom" /><br />
		<input type="submit" />
	    </form>
	</section>
	<?php
    }

}
