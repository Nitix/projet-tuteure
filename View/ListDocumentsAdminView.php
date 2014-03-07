<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ListdocumentsAdminView
 *
 * @author Guillaume
 */
class ListDocumentsAdminView extends AdminView {

    private $documents;

    public function __construct($documents) {
	parent::__construct("Liste des documents");
	$this->documents = $documents;
    }

    public function body() {
	?>
	<section>
	    <div id="placeholder">
	    </div>    
	    <table class="table table-hover table-responsive">
		<thead>
		    <tr>
			<th> Nom </th>
			<th> Catégorie </th>
			<th> Disponibilité </th>
			<th> Modifier </th>
			<th> Cacher/Montrer </th>
			<th> Supprimer </th>

		    </tr>
		</thead>
		<tbody>
		    <?php
		    foreach ($this->documents as $categorie) :
			if ($categorie['categorie']->getID() != 1) :
			    foreach ($categorie['documents'] as $doc) :
				?>
		    	    <tr class="doc-<?php echo $doc->getID() ?>">
		    		<td><?php echo $doc->getNom() ?></td>
		    		<td><?php echo $categorie['categorie']->getNom() ?></td>
		    		<td class="dispo"><?php echo$this->getCorrectDispo($doc->getAutorisation()) ?></td>
				<td><a href="admin.php?a=modifierDocument&AMP;id=<?php echo $doc->getID(); ?>">
					    Modifier</a></td>
					    <td><a class="switch" href="#" data-id="<?php echo $doc->getID() ?>"><?php echo $this->getStatus($doc->getAutorisation()) ?>
		    			</a></td>
		    		<td><a href="admin.php?a=supprimerDocument&AMP;id=<?php echo $doc->getID() ?>">Supprimer
		    			</a></td>
		    	    </tr>
				<?php
			    endforeach;
			endif;
		    endforeach;
		    ?>
		</tbody>
	    </table>
	</section>
	<?php
    }

    /* admin.php?a=montrerDocument&AMP;id=<?php echo $doc->getID() ?> */

    private function getCorrectDispo($autorisation) {
	if ($autorisation == 0)
	    return "Tout le temps";
	if ($autorisation == "9999-99-99")
	    return "Masqué";
	return date('d/m/Y', strtotime($autorisation));
    }

    private function getStatus($autorisation){
	if ($autorisation == "9999-99-99") {
	    return "Montrer";
	}else {
	    return "Masquer";
	}
    }
}
