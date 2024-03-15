<?php

require_once "config.php";
Autoload::start();
require_once CONTROLLER."Router.php";


$request = $_GET['r'];

$routeur = new Router($request);
$routeur->renderController();        

