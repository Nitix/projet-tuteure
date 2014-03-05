<?php

/**
 * Description of AccueilView
 *
 */
class AccueilView extends MainView {

    private $message;

    public function __construct(Document $message) {
	parent::__construct($message->getNom());
	$this->message = $message;
    }

    public function body() {
	?>
	<section>
	    <?php
	    echo $this->message->getContenu();
	    ?>
	</section>
	<?php
    }

}
