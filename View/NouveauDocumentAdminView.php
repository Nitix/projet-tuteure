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
	    <form method="post" action="index.php?c=Admin&amp;a=enregistrerDocument">
		<input type="hidden" name="jeton" value="<?php echo $_SESSION[PREFIX . 'jeton'] ?>" />
		<div class="form-group">
		    <label for="nom">Nom du document :</label>
		    <input type="text" id="nom" name="nom" class="form-control" placeholder="Nom du document"/>
		</div>
		<div class="form-group">
		    <label for="categorie_id">Categorie du document.</label>
		    <select name="categorie_id" class="form-control" id="categorie_id">
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
		    </select>
		</div>


		<div class="form-groupp">
		    <label for="autorisation">Date où le document est disponible:</label>
		    <input type="text" id="autorisation" placeholder="jj/mm/aaaa" class="form-control" name="autorisation" value="<?php echo date('d/m/Y') ?>"/>
		</div>

		<div class="checkbox">
		    <label>
			<input type="checkbox" name="always" value="1">Disponible tout le temps ?
		    </label>
		</div>

		<textarea name="contenu" id="contenu" rows="10" cols="80"></textarea><br />
		<button type="submit" class="btn btn-default">Enregistrer</button>
	    </form>
	</section>
	<script>
	    $('#contenu').ckeditor();
	</script>
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
	<script src="data/js/ckeditor/adapters/jquery.js"></script>
	<script src="data/js/bootstrap-datepicker.js"></script>
	<script src="data/js/locales/bootstrap-datepicker.fr.js"></script>

	<?php
    }

    public function css() {
	parent::css();
	?>
	<link rel="stylesheet" href="data/css/datepicker3.css" />
	<?php
    }

    //put your code here
}
