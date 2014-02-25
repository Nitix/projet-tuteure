<?php

/**
 * Description of mainView
 *
 */
abstract class MainView {

    private $title;

    protected function __construct($title = "Site web pédagogique") {
	$this->title = $title;
    }

    function displayPage() {
	?>
	<!doctype html>
	<html lang="fr">
	    <head>
		<meta charset="utf-8">
		<meta name="HandheldFriendly" content="true">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
		<title><?php echo $this->title ?></title>
		<?php
		echo $this->css();
		echo $this->javascript();
		?>
	    </head>
	    <body>
		<?php
		$this->header();
		$this->menu();
		$this->body();
		$this->footer();
		?>
	    </body>
	</html>
	<?php
    }

    public function header() {
	?>
	<header>
	    <div id="titre">
		Mathématiques
	    </div>
	    <div id="header_droit">
		<div>
		    Connexion
		</div>
	    </div>
	</header>
	<?php
    }

    abstract public function body();

    public function footer() {
	
    }

    public function menu() {
	$controller = new CoursController();
	$menus = $controller->getMenu();
	?>
	<nav>
	    <div class="high_res">
		<?php
		foreach ($menus as $menu) :
		    if ($menu['type']->getID() == 1) :
			?><a href="index.php"><div class="menu_box menu_level_1 acceuil">Acceuil</div></a><?php
		    else :
			?>
			<a href="index.php?a=listDocuments&AMP;id=<?php echo $menu['type']->getID(); ?>">
			    <div class="menu_box menu_level_1"><?php echo $menu['type']->getNom() ?></div>
			</a>
			<?php
			foreach ($menu['documents'] as $doc) :
			    ?>
		    	<a href="index.php?a=voirDocument&AMP;id=<?php echo $doc->getID(); ?>">
		    	    <div class="menu_box menu_level_2"><?php echo $doc->getNom() ?></div>
		    	</a>
			    <?php
			endforeach;
		    endif;
		endforeach;
		?>
	    </div>
	</nav>
	<?php
    }

    public function css() {
	?>
	<link rel="stylesheet" href="data/css/site.css" />
	<?php
    }

    public function javascript() {
	
    }

}
