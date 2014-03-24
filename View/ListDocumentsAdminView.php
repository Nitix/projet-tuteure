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
	<section class="paddingSection">
	    <div id="placeholder">
	    </div>    
	    <div class="modal fade" id="delete-confirm" role="dialog" aria-hidden="true">
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
	    <div class="modal fade" id="hide-confirm-dialog" role="dialog"  aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    <h4 class="modal-title">Etes vous-sûr ?</h4>
			</div>
			<div class="modal-body">
			    <p>Tout les documents masqués seront masqués</p>
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			    <button type="button" id="hide-confirm-button" class="btn btn-warning">Oui</button>
			</div>
		    </div>
		</div>
	    </div>
	    <div class="modal fade" id="show-confirm-dialog" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    <h4 class="modal-title">Etes vous-sûr ?</h4>
			</div>
			<div class="modal-body">
			    <p>Tout les documents masqués seront visibles</p>
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			    <button type="button" id="show-confirm-button" class="btn btn-warning">Oui</button>
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
				$switch = $this->canSwitch($doc->getAutorisation());
				?>
		    	    <tr data-id="<?php echo $doc->getID() ?>">
		    		<td><?php echo $doc->getNom() ?></td>
		    		<td><?php echo $categorie['categorie']->getNom() ?></td>
		    		<td class="dispo <?php echo $switch ? "maskable" : "" ?>"><?php echo$this->getCorrectDispo($doc->getAutorisation()) ?></td>
		    		<td><a href="/<?php echo BASE?>Admin/modifierDocument/<?php echo $doc->getID(); ?>">
		    			Modifier</a></td>
		    		<td>
					<?php if ($switch) : ?>
					    <a class="switch" href="#"><?php echo $this->getStatus($doc->getAutorisation()) ?></a>
					<?php else : ?>
					    Impossible à masquer
					<?php endif; ?>
		    		</td>
		    		<td><a class="delete" href="#">Supprimer</a></td>
		    	    </tr>
				<?php
			    endforeach;
			endif;
		    endforeach;
		    ?>
		</tbody>
	    </table>
	    <button id="hideAll" class="btn btn-default">Masquer tout les documents </button>
	    <button id="showAll" class="btn btn-default">Montrer tout les documents </button>

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

    public function javascript() {
	parent::javascript();
	?>
	<script src="/<?php echo BASE?>data/js/bootstrap-datepicker.js"></script>
	<script src="/<?php echo BASE?>data/js/locales/bootstrap-datepicker.fr.js"></script>
	<?php
    }

    public function css() {
	parent::css();
	?>
	<link rel="stylesheet" href="/<?php echo BASE?>data/css/datepicker3.css" />
	<?php
    }

}
