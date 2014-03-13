<?php

/**
 * Description of DocumentView
 *
 * @author Guillaume
 */
class DocumentView extends MainView {

    private $document;

    public function __construct(Document $document) {
	parent::__construct($document->getNom(), $document->getID(), true, $document->getCategorie_id());
	$this->document = $document;
    }

    public function body() {
	?>
	<section>
	    <?php
	    if ($this->document->getID() != 1) :
		?>
	        <span class="outils"><a target="_blank" href="/<?php echo BASE?>Cours/imprimerDocument/<?php echo $this->document->getID() ?>">
	    	    <button type="button" class="btn btn-default btn-default"><span class="glyphicon glyphicon-print"></span> Imprimer</button></a>
			<?php
			$user = new UserController();
			if ($user->isConnected()) {
			    echo '<a href="/'.BASE .'Admin/modifierDocument/' . $this->document->getID() . '"><button type="button" class="btn btn-default btn-default"><span class="glyphicon glyphicon-pencil"></span> Editer</button></a>';
			}
			?>
	        </span>
		<?php
	    endif;
	    echo $this->document->getContenu();
	    ?>
	</section>
	<?php
    }

    public function javascript() {
	parent::javascript();
	?>
	<script type="text/x-mathjax-config">
	    MathJax.Hub.Config({
	    extensions: ["tex2jax.js"],
	    jax: ["input/TeX","output/HTML-CSS"],
	    tex2jax: {inlineMath: [["$","$"],["\\(","\\)"]]}
	    });
	</script>
	<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?locale=fr"></script>
	<?php
    }

}
