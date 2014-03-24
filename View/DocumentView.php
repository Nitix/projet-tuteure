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
            if($this->document->getID() != 1){
                ?>
                <iframe src="http://docs.google.com/viewer?url=<?php echo urlencode("iecl.univ-lorraine.fr/SitePedagogique/".$this->document->getContenu());?>&embedded=true" width="100%" height="100%" style="border: none;"></iframe>';
            <?php
            }else{
                echo $this->document->getContenu();
            }
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
