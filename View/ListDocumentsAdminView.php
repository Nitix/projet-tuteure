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
		<div class="alert alert-danger alert-dismissable" id="alert" style="display: none">
		    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		    <strong>Impossible !</strong> Une erreur est survenu pendant l'opération
		</div>
		<div class="alert alert-success alert-dismissable" id="success" style="display: none">
		    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		    <strong>Succès !</strong> Une erreur est survenu pendant l'opération
		</div>
		<div class="alert alert-warning alert-dismissable" id="warning" style="display: none">
		    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		    <strong>Attention !</strong> Etes vous sûr de vouloir supprimer ce document ? <a href="#" class="alert-link">OUI</a>
		</div>    
		<table>
		    <thead>
			<tr>
			    <th> Nom </th>
			    <th> Catégorie </th>
			    <th> Disponibilité </th>
			    <th> Supprimer </th>
			    <th> Cacher </th>
			    <th> Montrer </th>
			</tr>
		    </thead>
		    <tbody>
			<?php
			foreach ($this->documents as $categorie) :
			    if ($categorie['categorie']->getID() != 1) :
				foreach ($categorie['documents'] as $doc) :
				    ?>
		    		<tr>
		    		    <td><a href="admin.php?a=modifierDocument&AMP;id=<?php echo $doc->getID(); ?>"> <button type="button" class="btn btn-default"> 
						    <?php echo $doc->getNom() ?></button> </a></td>
		    		    <td><?php echo $categorie['categorie']->getNom() ?></td>
		    		    <td><?php echo$this->getCorrectDispo($doc->getAutorisation()) ?></td>
		    		    <td><a href="admin.php?a=supprimerDocument&AMP;id=<?php echo $doc->getID() ?>"><button type="button" class="btn btn-default"> Supprimer
		    			    </button></a></td>
		    		    <td><a href="admin.php?a=cacherDocument&AMP;id=<?php echo $doc->getID() ?>"> <button type="button" class="btn btn-default"> Cacher
		    			    </button></a></td>
		    		    <td><a class="switch" href="#" value="<?php echo $doc->getID() ?>"><button type="button" class="btn btn-default"> Montrer
		    			    </button></a></td>
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

}
