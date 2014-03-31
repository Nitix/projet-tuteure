<?php

class MotDePassePerduView extends MainView {

    private $error;

    public function __construct($error = null) {
        parent::__construct("Connexion");
        $this->error = $error;
    }

    public function body() {
        ?>
        <section class="paddingSection">
            <?php
            if ($this->error != null) :
                ?>
                <div class="alert alert-danger alert-dismissable" id="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Erreur !</strong> <?php echo $this->error ?>
                </div>
            <?php
            endif;
            ?>
            <form action="/<?php echo BASE?>User/VerifierMotDePassePerdu" method="post" role="form">
                <div class="form-group">
                    <label for="login" class="control-label">Identifiant</label>
                    <div>
                        <input type="text" id="login" name="login" autofocus="true" class="form-control" placeholder="Identifiant"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <div>
                        <input type="text" id="email" name="email" class="form-control" placeholder="Email"/>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <button type="submit" class="btn btn-default">Demande de réinitialisation</button>
                    </div>
                </div>
            </form>
        </section>
    <?php
    }
} 