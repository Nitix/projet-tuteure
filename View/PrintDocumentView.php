<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrintDocumentView
 *
 * @author Guillaume
 */
class PrintDocumentView extends MainView {

    private $document;

    public function __construct(Document $document) {
	parent::__construct($document->getNom(), $document->getID(), true, $document->getCategorie_id());
	$this->document = $document;
    }

    public function body() {
	echo $this->document->getContenu();
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

    public function menu() {
	
    }

    public function header() {
	
    }

    public function footer() {
	echo "Cours sur http://iecl.univ-lorraine.fr/SitePedagogique/ <br />";
	echo "Site issue d'un projet tuteuré";
    }
    
     public function css() { }

}
