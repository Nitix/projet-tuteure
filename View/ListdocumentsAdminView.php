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
class ListdocumentsAdminView extends AdminView {

    private $documents;

    public function __construct($documents) {
	parent::__construct("Liste des documents");
	$this->documents = $documents;
    }

    public function body() {
	?>
	<section>
	    <table>
		<thead>
		    <tr>
			<th>Nom</th>
			<th>Catégorie</th>
			<th>Disponibilité</th>
			<th>Supprimer ?</th>
		    </tr>
		</thead>
		<tbody>
		    <?php
		    foreach ($this->documents as $categorie) :
			if ($categorie['categorie']->getID() == 1) :
			    ?>
			    <tr><td><a href="admin.php?a=modifierAccueil">Acceuil</a></td><td>Accueil</td><td>Tout le temps</td><td>Impossible à supprimer</td></tr>
			    <?php
			else :
			    ?>
			    <?php
			    foreach ($categorie['documents'] as $doc) :
				?>
		    	    <tr>
		    		<td><a href="admin.php?a=modifierDocument&AMP;id=<?php echo $doc->getID(); ?>"> <?php echo $doc->getNom() ?></a></td>
		    		<td><?php echo $categorie['categorie']->getNom() ?></td>
		    		<td><?php echo $doc->getAutorisation() != 0 ? date('d/m/Y', strtotime($doc->getAutorisation())) : "Tout le temps" ?></td>
				<td><a href="admin.php?a=supprimerDocument&AMP;id=<?php echo $doc->getID()?>">Supprimer</a></td>
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

}
