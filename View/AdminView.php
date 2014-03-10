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
		<li class="menu_box"><a href="index.php?c=Admin&amp;a=nouveauDocument">
			Nouveau Document
		    </a></li>
		<li class="menu_box"><a href="index.php?c=Admin&amp;a=listDocuments">
			Tout les documents
		    </a></li>
		<li class="menu_box"><a href="index.php?c=Admin&amp;a=nouvelleCategorie">
			Nouvelle catégorie
		    </a></li>
		<li class="menu_box"><a href="index.php?c=Admin&amp;a=listCategories">
			Toutes les catégories
		    </a>
		<li class="menu_box"><a href="index.php?c=Admin&amp;a=modifierAccueil">
			Modifier l'accueil
		    </a></li>	
		<li class="menu_box"><a href="index.php?c=Admin&amp;a=nouveauAdmin">
			Ajouter un adminstrateur
		    </a></li>	
		<li class="menu_box"><a href="index.php?c=Admin&amp;a=modifierAdmin">
			Gérer ses identifiants
		    </a></li>	
	    </ul>
	</nav>   
	<?php
    }

}
