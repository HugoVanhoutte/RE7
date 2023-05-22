<?php
session_start();
//TODO REMOVE DEBUG
var_dump($_SESSION);

use App\Controller\RootController;


//All requires

//Librairies
require_once __DIR__ . "/../vendor/phpmailer/phpmailer/src/PHPMailer.php";
require_once __DIR__ . "/../vendor/phpmailer/phpmailer/src/SMTP.php";
require_once __DIR__ . "/../vendor/phpmailer/phpmailer/src/Exception.php";

//Model
require_once __DIR__ . "/../Model/DB.php";

    //Entity
    require_once __DIR__ . "/../Model/Entity/User.php";
    //Manager
    require_once __DIR__ . "/../Model/Manager/ManagerInterface.php";
    require_once __DIR__ . "/../Model/Manager/UserManager.php";
    require_once __DIR__ . "/../Model/Manager/RoleManager.php";
    require_once __DIR__ . "/../Model/Manager/AbstractManager.php";

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
