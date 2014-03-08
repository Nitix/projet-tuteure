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
	    <div class="modal fade" id="delete-confirm" role="dialog" aria-labelledby="Confirmation suppression" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    <h4 class="modal-title">Etes vous-sûr ?</h4>
			</div>
			<div class="modal-body">
			    <p>La suppression est irréversible</p>
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			    <button type="button" id="delete-id" data-id="0" class="btn btn-danger">Supprimer</button>
			</div>
		    </div>
		</div>
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
		    		<td>
					<?php if ($this->canSwitch($doc->getAutorisation())) : ?>
					    <a class="switch" href="#" data-id="<?php echo $doc->getID() ?>"><?php echo $this->getStatus($doc->getAutorisation()) ?></a>
					<?php else : ?>
					    Impossible à masquer
					<?php endif; ?>
		    		</td>
		    		<td><a class="delete" href="#" data-id="<?php echo $doc->getID() ?>">Supprimer
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

    private function getCorrectDispo($autorisation) {
	if ($autorisation == 0)
	    return "Tout le temps";
	if ($autorisation == "9999-99-99")
	    return "Masqué";
	return date('d/m/Y', strtotime($autorisation));
    }

    private function getStatus($autorisation) {
	if ($autorisation == "9999-99-99")
	    return "Montrer";
	return "Masquer";
    }

    private function canSwitch($autorisation) {
	return $autorisation != 0;
    }

}
