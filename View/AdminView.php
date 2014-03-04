<?php

/**
 * Description of DocumentView
 *
 * @author Guillaume
 */
abstract class AdminView extends MainView {

    public function __construct($title = "Administration") {
	parent::__construct($title);
    }

    public function javascript() {
	parent::javascript();
    }

    public function menu() {
	?>
	<nav>
	    <div class="high_res">
		<a href="index.php"><div class="menu_box menu_level_1 acceuil">Retour au site</div></a>
		<a href="admin.php?a=nouveauDocument">
		    <div class="menu_box menu_level_2">Nouveau Document</div>
		</a>
		<a href="admin.php?a=listDocuments">
		    <div class="menu_box menu_level_2">Tout les documents</div>
		</a>
		<a href="admin.php?a=nouvelleCategorie">
		    <div class="menu_box menu_level_2">Nouvelle catégorie</div>
		</a>
		<a href="admin.php?a=listCategorie">
		    <div class="menu_box menu_level_2">Toutes les catégories</div>
		</a>
		<a href="admin.php?a=modifierAccueil">
		    <div class="menu_box menu_level_2">Modifier l'accueil</div>
		</a>		
	    </div>
	</nav>   
	<?php
    }

}
