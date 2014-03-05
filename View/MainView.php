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
		?>
		<div class="wraper">
		    <div class="wrapper_row">
			<?php
			$this->menu();
			$this->body();
			?>
		    </div>
		</div>
		<?php
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
		<?php
		$userController = new UserController();
		if ($userController->isConnected()):
		    $user = $userController->getUser();
		    ?>
	    	<div>
	    	    Bienvenue <?php echo $user->getPrenom() . " " . $user->getNom() ?><br /><a href="admin.php">Administrer le site</a><br /><a href="user.php?a=logout">Se deconnecter</a>
	    	</div>
		    <?php
		else:
		    ?>
	    	<div>
	    	    <a href="user.php?a=login">Connexion</a>
	    	</div>
		<?php
		endif;
		?>
	    </div>
	</header>
	<?php
    }

    abstract public function body();

    public function footer() { //??
	
    }

    public function menu() {
	$controller = new CoursController();
	$menus = $controller->getMenu();
	?>
	<nav>
	    <div class="high_res">
		<?php
		foreach ($menus as $menu) :
		    if ($menu['categorie']->getID() == 1) :
			?><a href="index.php"><div class="menu_box menu_level_1 acceuil">Acceuil</div></a><?php
		    else :
			?>
			<a href="index.php?a=listDocuments&AMP;id=<?php echo $menu['categorie']->getID(); ?>">
			    <div class="menu_box menu_level_1"><?php echo $menu['categorie']->getNom() ?></div>
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
