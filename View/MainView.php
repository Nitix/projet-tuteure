<?php

/**
 * Description of mainView
 *
 */
abstract class MainView {

    private $title;
    private $id;
    private $is_document;
    private $cat_id;

    protected function __construct($title = "Site web pédagogique", $id = 0, $is_document = true, $cat_id = 0) {
	$this->title = $title;
	$this->id = $id;
	$this->is_document = $is_document;
	$this->cat_id = $cat_id;
    }

    function displayPage() {
	?>
	<!doctype html>
	<html lang="fr">
	    <head>
		<meta charset="utf-8">
		<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<![endif]-->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
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
	    <ul class="nav nav-pills nav-stacked">
		<?php
		foreach ($menus as $menu) :
		    if ($menu['categorie']->getID() == 1) :
			?><li class="<?php echo$this->isActive(1, false) ? "active" : "menu_box" ?>"><a href="index.php">Accueil </a></li><?php else :
			?>
			<li class="dropdown  <?php echo $this->isActive($menu['categorie']->getID(), false) ? "active" : "menu_box" ?>">
			    <a class="dropdown-toggle"
			       data-toggle="dropdown" data-target="#"
			       href="index.php?a=listDocuments&AMP;id=<?php echo $menu['categorie']->getID(); ?>">
				   <?php echo $menu['categorie']->getNom() ?>
				<span class="badge pull-right"><?php echo count($menu['documents']) ?></span>
				<span class="caret"></span>

			    </a>
			    <ul class="dropdown-menu">
				<?php
				foreach ($menu['documents'] as $doc) :
				    ?>
		    		<li <?php echo $this->isActive($doc->getID(), true) ? 'class="active"' : '' ?> >
		    		    <a href="index.php?a=voirDocument&AMP;id=<?php echo $doc->getID(); ?>">
					    <?php echo $doc->getNom() ?>
		    		    </a>
		    		</li>
				    <?php
				endforeach;
				?>
			    </ul>
			<?php
			endif;
		    endforeach;
		    ?>
	    </ul>
	</nav>
	<?php
    }

    private function isActive($id, $is_document) {
	if ($is_document) {
	    if ($this->is_document) {
		return $this->id == $id;
	    }
	    return false;
	}
	//C'est une catégorie
	if ($this->is_document) {
	    return $this->cat_id == $id;
	}
	return $this->id == $id;
    }

    public function css() {
	?>
	<link rel="stylesheet" href="data/css/bootstrap.css" />
	<link rel="stylesheet" href="data/css/bootstrap-theme.css" />
	<link rel="stylesheet" href="data/css/site.css" />
	<?php
    }

    public function javascript() {
	?>
	<script src="data/js/jquery-1.11.0.min.js"></script>
	<script src="data/js/bootstrap.js"></script>
	<?php
    }

}
