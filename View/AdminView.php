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
	?>
	<script src="data/js/admin.js"></script>
	<?php
    }

    public function menu() {
	?>
	<nav>
	    <ul class="nav nav-pills nav-stacked">
		<li class="menu_box"><a href="index.php">
			Retour au site
		    </a></li>
		<li class="menu_box"><a href="admin.php?a=nouveauDocument">
			Nouveau Document
		    </a></li>
		<li class="menu_box"><a href="admin.php?a=listDocuments">
			Tout les documents
		    </a></li>
		<li class="menu_box"><a href="admin.php?a=nouvelleCategorie">
			Nouvelle catégorie
		    </a></li>
		<li class="menu_box"><a href="admin.php?a=listCategories">
			Toutes les catégories
		    </a>
		<li class="menu_box"><a href="admin.php?a=modifierAccueil">
			Modifier l'accueil
		    </a></li>	
		<li class="menu_box"><a href="admin.php?a=nouveauAdmin">
			Ajouter un adminstrateur
		    </a></li>	
	    </ul>
	</nav>   
	<?php
    }

}
