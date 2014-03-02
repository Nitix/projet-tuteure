<?php

require_once 'common.php';

$user = new UserController();
if($user->isConnected()){
    $admin = new AdminController();
    $admin->callAction();
}else{
    $user->login();
}
