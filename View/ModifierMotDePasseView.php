<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 31/03/14
 * Time: 02:33
 */

class ModifierMotDePasseView extends MainView{

   private $error;

    public function __construct($error = null) {
        parent::__construct('Modification du mot de passe');
        $this->error = $error;
    }

    public function body()
    {
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
            <form action="/<?php echo BASE?>User/enregistrerMotDePasse" method="post" role="form">
                <input type="hidden" name="jeton" value="<?php echo $_SESSION[PREFIX . 'jeton'] ?>" />
                <div class="form-group">
                    <label for="password" class="control-label">Nouveau mot de passe
                    </label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe"/>
                </div>
                <div class="form-group">
                    <label for="confirm" class="control-label">Confirmation
                    </label>
                    <input type="password" name="confirm" id="confirm" class="form-control" placeholder="Mot de passe"/>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Modifier le mot de passe</button>
                </div>
            </form>
        </section>
    <?php
    }
}