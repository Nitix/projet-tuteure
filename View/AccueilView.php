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

    public function displayPage() {
        echo $this->message->getContenu();
    }

}
