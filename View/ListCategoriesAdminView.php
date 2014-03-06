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
				<td><a href="admin.php?a=supprimerCategorie&AMP;id=<?php echo $cat->getID()?>">Supprimer</a></td></tr>

				<?php
			}
		    endforeach;
		    ?>
		</tbody>
	    </table>
	    <p> </br></br>Attention, supprimier une catégorie revient a supprimer l'intégralité des documents associés a celle-ci.</p>
	</section> <?php
    }

}
?>
