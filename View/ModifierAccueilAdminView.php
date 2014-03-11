<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DocumentAdminView
 *
 * @author Guillaume
 */
class ModifierAccueilAdminView extends AdminView {

    private $document;

    public function __construct(Document $document) {
	parent::__construct("Modification de l'accueil");
	$this->document = $document;
    }

    public function body() {
	?>
	<section>
	    <form method="post" action="/<?php echo BASE?>Admin/enregistrerDocument">
		<input type="hidden" name="jeton" value="<?php echo $_SESSION[PREFIX . 'jeton'] ?>" />
		<input type="hidden" name="categorie_id" value="1" />
		<input type="hidden" name="autorisation" value="0" />
		<input type="hidden" name="id" value="1" />
		<input type="hidden" name="nom" value="Accueil" />


		<h1>Modification de l'accueil</h1>
		<br />
		<textarea name="contenu" id="contenu" rows="10" cols="80"><?php echo $this->document->getContenu() ?></textarea>
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
	<script src="/<?php echo BASE?>data/js/ckeditor/ckeditor.js"></script>
	<?php
    }

}
