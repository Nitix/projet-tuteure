<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HomeAdminView
 *
 * @author Guillaume
 */
class HomeAdminView extends AdminView {

    public function body() {
	?>
	<section class="paddingSection">
	    <h1>Bienvenue sur le panneau de configuration du site</h1>
	    <p>Il y a actuellement <?php echo Document::numberOfDocuments() - 1 ?> documents</p>
	    <p>Ici, vous pouvez modifier un document, un categorie.<br />
		Il est également possible de modifier l'accueil via l'onglet "Modifier Accueil"</p>

        <p>
            Pour ajouter un document, veuillez saisir son nom, sa catégorie, sa date, et le document PDF.
        </p>
	</section>
	<?php
    }

    /*
      <p>Vous pouvez ajouter de nouveaux utilisateurs pour qu'ils puissent créer eux mêmes des document, mais ils auront
      un accès total au site. <br />
      Ils pourront également ajouter des nouveaux utilisateurs à leur tour.
      </p>
     */
}