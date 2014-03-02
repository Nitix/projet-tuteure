<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HomeAdminView
 *
 * @author Guillaume
 */
class HomeAdminView extends AdminView {

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
	<script src="data/js/ckeditor/ckeditor.js"></script>
	<?php
    }
   }
