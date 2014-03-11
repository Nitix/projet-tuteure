<?php

/**
 * Description of listDocumentsView
 *
 * @author Guillaume
 */
class ListDocumentsView extends MainView {

    private $categorie;
    private $documents;

    public function __construct(Categorie $categorie, $documents) {
	parent::__construct($categorie->getNom());
	$this->categorie = $categorie;
	$this->documents = $documents;
    }

    public function body() {
	?>
	<section>
	    <h1><?php echo $this->categorie->getNom() ?></h1>
	    <?php if (empty($this->documents)) : ?>
	        <p>Aucun cours disponible pour cette catégorie</p>
	    <?php else : ?> 
	        <ul>
		    <?php foreach ($this->documents as $document) : ?>
		    <li><a href = "/<?php echo BASE?>Cours/voirDocument/<?php echo $document->getId() ?>"><?php echo $document->getNom() ?></a></li>
		    <?php endforeach; ?>
	        </ul>
	    <?php endif; ?>
	</section>
	<?php
    }

}
