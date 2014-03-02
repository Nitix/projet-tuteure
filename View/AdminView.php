<?php

/**
 * Description of DocumentView
 *
 * @author Guillaume
 */
class AdminView extends MainView {

    public function __construct() {
	parent::__construct("Administration");
    }

    public function body() {
	//TODO correct Type
	?>
	<section>
	    <form method="post" action="admin.php?a=enregistrerDocument">
		<input type="hidden" value="<?php echo $_SESSION[PREFIX.'jeton']?>" />
		<label for="nom">Nom du document :</label>
		<input type="text" name="nom" /><br />
		<label for="nom">Type du document.</label>

		<select name="type_id">
		    <?php
		    $types = Type::findAll();
		    foreach ($types as $type) :
			?>
	    	    <option value="<?php echo $type->getID() ?>"><?php echo $type->getNom() ?></option>
			<?php
		    endforeach;
		    ?>
		</select><br />
		<label for="autorisation">Date où le document est disponible:</label>
		<input type="date" name="autorisation" />
		<textarea name="contenu" id="contenu" rows="10" cols="80"></textarea>
		<input type="submit" />
	    </form>

	    <script>
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace( 'contenu' );
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

}
