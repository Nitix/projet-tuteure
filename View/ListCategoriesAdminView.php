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
	<section>
	    <table>
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

				<tr><td><?php echo $cat->getNom(); ?> </td>
				<td><a href="admin.php?a=supprimerCategorie&AMP;id=<?php echo $cat->getID()?>"><button type="button" class="btn btn-default btn-lg"> Supprimer
</button>
</a></td></tr>

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
