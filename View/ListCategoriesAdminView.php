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
			<th>Nom</th>
			<th>Supprimer</th>
		    </tr>
		</thead>
		<tbody>
		    <?php
		    foreach ($this->categories as $cat) :
		    	?>
				<tr><td><?php echo $cat->getNom(); ?> </td></tr>
				<?php
		    endforeach;
		    ?>
		</tbody>
	    </table>
	</section> <?php
    }

}
?>
