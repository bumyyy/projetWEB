<?php

require_once "config.php";
Autoload::start();
require_once CONTROLLER."Router.php";


// $request = $_GET['r'];
$request = isset($_GET['r']) ? $_GET['r'] : 'home.php';
// $request = isset($_GET['r']) ? $_GET['r'] : '';          // à voir si on enlève



$routeur = new Router($request);
$routeur->renderController();        

