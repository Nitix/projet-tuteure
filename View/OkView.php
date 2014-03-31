<?php

/**
 * Description of OkAdminView
 *
 * @author Guillaume
 */
class OkView extends MainView {

    private $message;

    public function __construct($message = "La requête e été executé correctement") {
        parent::__construct("Succès de l'opération");
        $this->message = $message;
    }

    public function body() {
        ?>
        <section class="paddingSection">
            <?php echo $this->message ?>
        </section>
    <?php

    }

}
