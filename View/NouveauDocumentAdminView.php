<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NouveauDocumentView
 *
 * @author Guillaume
 */
class NouveauDocumentAdminView extends AdminView {

    public function __construct() {
	parent::__construct("Nouveau Document");
    }

    public function body() {
	?>
	<section>
	    <form method="post" action="admin.php?a=enregistrerDocument">
		<input type="hidden" name="jeton" value="<?php echo $_SESSION[PREFIX . 'jeton'] ?>" />
		<label for="nom">Nom du document :</label>
		<input type="text" id="nom" name="nom" /><br />
		<label for="categorie_id">Categorie du document.</label>

		<select name="categorie_id" id="categorie_id">
		    <?php
		    $categories = Categorie::findAll();
		    foreach ($categories as $categorie) :
			if ($categorie->getID() != 1) :
			    ?>
			    <option value="<?php echo $categorie->getID() ?>"><?php echo $categorie->getNom() ?></option>
			    <?php
			endif;

		    endforeach;
		    ?>
		</select><br />
		<label for="autorisation">Date où le document est disponible:</label>
		<input type="date" id="autorisation" name="autorisation" /><br />
		<input type="checkbox" name="always" value="1">Disponible tout le temps ?<br />
		<textarea name="contenu" id="contenu" rows="10" cols="80"></textarea>
		<input type="submit" />
	    </form>

	    <script>
		CKEDITOR.replace('contenu');
	    </script>
	</section>
	<?php
    }

    public function javascript() {
	parent::javascript();
	?>
	<script type="text/x-mathjax-config">
	    MathJax.Hub.Config({
	    extensions: ["tex2jax.js"],
	    jax: ["input/TeX","output/HTML-CSS"],
	    tex2jax: {inlineMath: [["$","$"],["\\(","\\)"]]}
	    });
	</script>
	<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?locale=fr"></script>
	<script src="data/js/ckeditor/ckeditor.js"></script>
	<?php
    }

    //put your code here
}
