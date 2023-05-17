<?php
session_start();

use App\Controller\RootController;


//All requires

//Model
require_once __DIR__ . "/../Model/DB.php";

    //Entity

    //Manager
    require_once __DIR__ . "/../Model/Manager/ManagerInterface.php";

//Controller
require_once __DIR__ . "/../Controller/AbstractController.php";
require_once __DIR__ . "/../Controller/RootController.php";
require_once __DIR__ . "/../Controller/ControllerInterface.php";


//Router

//Displays Homepage if nothing in url
if (!isset($_SERVER["PATH_INFO"]))
{
    (new RootController())->index();
    exit();
}

$controller = $_SERVER["PATH_INFO"];
$controller = str_replace("/", "", $controller);
$controller = ucfirst($controller) . "Controller";
$require = __DIR__ . "/../Controller/$controller.php";

//If this controller does not exist, sends the user to an error 404 page
if (!file_exists($require)) {
    (new RootController())->displayError(404);
    die();
}

require_once $require;

$controller = "App\\Controller\\$controller";
(new $controller)->index($_REQUEST);
