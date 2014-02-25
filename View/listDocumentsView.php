<?php

/**
 * Description of listDocumentsView
 *
 * @author Guillaume
 */
class listDocumentsView extends MainView {

    private $type;
    private $documents;

    public function __construct(Type $type, $documents) {
	parent::__construct($type->getNom());
	$this->type = $type;
	$this->documents = $documents;
    }

    public function body() {
	?>
	<section>
	    <h1><?php echo $this->type->getNom() ?></h1>
	    <?php if (empty($this->documents)) : ?>
	        <p>Aucun cours disponible pour cette catégorie</p>
	    <?php else : ?> 
	        <ul>
		    <?php foreach ($this->documents as $document) : ?>
		    <li><a href = "index.php?a=voirDocument&amp;id=<?php echo $document->getId() ?>"><?php echo $document->getNom() ?></a></li>
		    <?php endforeach; ?>
	        </ul>
	    <?php endif; ?>
	</section>
	<?php
    }

}
