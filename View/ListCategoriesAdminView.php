<?php
/*
 * Liste des catégories
 */

class ListCategoriesAdminView extends AdminView {

    private $categories;

    public function __construct($categories) {
	parent::__construct("Liste des catégories");
	$this->categories = $categories;
    }

    public function body() {
	?>
	<section class="paddingSection">
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
			    <button type="button" id="delete-cat-id" data-id="0" class="btn btn-danger">Supprimer</button>
			</div>
		    </div>
		</div>
	    </div>
	    <table class="table table-hover table-responsive" >
		<thead>
		    <tr>
			<th> Nom </th>
			<th> Supprimer </th>
		    </tr>
		</thead>
		<tbody>
		    <?php
		    foreach ($this->categories as $cat) :
			if ($cat->getID() != 1) {
			    ?>

			    <tr data-id="<?php echo $cat->getID()?>">
				<td><?php echo $cat->getNom(); ?> </td>
				<td><a class="delete-cat" href="#"> Supprimer</a></td>
			    </tr>

			    <?php
			}
		    endforeach;
		    ?>
		</tbody>
	    </table>
	    <div class="alert alert-warning" id="warning" style="display: center">
		<strong>Attention </strong> , supprimier une catégorie revient a supprimer l'intégralité des documents associés a celle-ci.
	    </div> 

	</section> <?php
    }

}
?>
