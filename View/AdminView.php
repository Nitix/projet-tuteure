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
	<script src="/<?php echo BASE?>data/js/admin.js"></script>
	<script>var BASE = '<?php echo BASE?>'</script>
	<?php
    }

    public function menu() {
	?>
	<nav>
	    <ul class="nav nav-pills nav-stacked">
		<li class="menu_box"><a href="/<?php echo BASE?>Accueil">
			Retour au site
		    </a></li>
		<li class="menu_box"><a href="/<?php echo BASE?>Admin/nouveauDocument">
			Nouveau document
		    </a></li>
		<li class="menu_box"><a href="/<?php echo BASE?>Admin/listDocuments">
			Tous les documents
		    </a></li>
		<li class="menu_box"><a href="/<?php echo BASE?>Admin/nouvelleCategorie">
			Nouvelle catégorie
		    </a></li>
		<li class="menu_box"><a href="/<?php echo BASE?>Admin/listCategories">
			Toutes les catégories
		    </a>
		<li class="menu_box"><a href="/<?php echo BASE?>Admin/modifierAccueil">
			Modifier l'accueil
		    </a></li>	
		<li class="menu_box"><a href="/<?php echo BASE?>Admin/nouveauAdmin">
			Ajouter un adminstrateur
		    </a></li>	
		<li class="menu_box"><a href="/<?php echo BASE?>Admin/modifierAdmin">
			Gérer ses identifiants
		    </a></li>	
	    </ul>
	</nav>   
	<?php
    }

}
