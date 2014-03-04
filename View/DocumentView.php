<?php

/**
 * Description of DocumentView
 *
 * @author Guillaume
 */
class DocumentView extends MainView {

    private $document;

    public function __construct(Document $document) {
	parent::__construct($document->getNom());
	$this->document = $document;
    }

    public function body() {
	?>
	<section>
	    <?php
	    echo $this->document->getContenu();
	    ?>
	</section>
	<?php
    }
    public function javascript(){
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
