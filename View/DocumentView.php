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

            <?php
            if($this->document->getID() != 1){
                ?>
                <section>
                <iframe src="/<?php echo BASE ?>Cours/viewer/<?php echo $this->document->getID()?>" width="100%" height="100%" style="border: none;"></iframe>
            <?php
            }else{
                echo '<section class="paddingSection">';
                echo $this->document->getContenu();
            }
            ?>
        </section>
    <?php
    }

    public function javascript() {
        parent::javascript();
        ?>
    <?php
    }

}
