<?php

/**
 * Description of AccueilView
 *
 */
class AccueilView extends MainView {

    private $message;

    public function __construct($title, Document $message) {
	parent::__construct($title);
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
