<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DocumentAdminView
 *
 * @author Guillaume
 */
class DocumentAdminView extends AdminView {

    private $document;

    public function __construct(Document $document) {
        parent::__construct("Modification de " . $document->getNom());
        $this->document = $document;
    }

    public function body() {
        ?>
        <section class="paddingSection">
            <form method="post" enctype="multipart/form-data" action="/<?php echo BASE?>Admin/enregistrerDocument">
                <input type="hidden" name="jeton" value="<?php echo $_SESSION[PREFIX . 'jeton'] ?>" />
                <input type="hidden" name="id" value="<?php echo $this->document->getID() ?>" />
                <div class="form-group">
                    <label for="nom">Nom du document :</label>
                    <input type="text" id="nom" name="nom" class="form-control" value="<?php echo $this->document->getNom() ?>"/>
                </div>
                <div class="form-group">
                    <label for="categorie_id">Categorie du document.</label>
                    <select name="categorie_id" class="form-control" id="categorie_id">
                        <?php
                        $categories = Categorie::findAll();
                        foreach ($categories as $categorie) :
                            if ($categorie->getID() != 1) :
                                ?>
                                <option <?php echo $categorie->getID() == $this->document->getID() ? "selected" : "" ?> value="<?php echo $categorie->getID() ?>"><?php echo $categorie->getNom() ?></option>
                            <?php
                            endif;

                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="autorisation">Date où le document est disponible:</label>
                    <input type="text" class="form-control" id="autorisation" name="autorisation" value="<?php echo date('d/m/Y', strtotime($this->document->getAutorisation())) ?>" />
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="always" <?php echo $this->document->getAutorisation() == 0 ? "checked" : "" ?> value="1" />Disponible tout le temps
                    </label>
                </div>
                <div class="form-group">
                    <label for="fichier">Fichier PDF du cours</label>
                    <input type="file" id="fichier" name="cours">
                </div>
                <button type="submit" class="btn btn-default">Enregistrer</button>
            </form>
        </section>
    <?php
    }

    public function javascript() {
        parent::javascript();
        ?>
        <script src="/<?php echo BASE?>data/js/bootstrap-datepicker.js"></script>
        <script src="/<?php echo BASE?>data/js/locales/bootstrap-datepicker.fr.js"></script>
    <?php
    }

    public function css() {
        parent::css();
        ?>
        <link rel="stylesheet" href="/<?php echo BASE?>data/css/datepicker3.css" />
    <?php
    }

}
