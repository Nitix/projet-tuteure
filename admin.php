<?php

require_once 'common.php';

//TODO A proteger des non connectés
$admin = new AdminController();
$admin->callAction();
