<?php


use App\Controller\RootController;

session_start();

//All requires

//Librairies
require_once __DIR__ . "/../vendor/phpmailer/phpmailer/src/PHPMailer.php";
require_once __DIR__ . "/../vendor/phpmailer/phpmailer/src/SMTP.php";
require_once __DIR__ . "/../vendor/phpmailer/phpmailer/src/Exception.php";

//Utils
require_once __DIR__ . "/../utils/MailUtil.php";

//Model
require_once __DIR__ . "/../Model/DB.php";

    //Entity
    require_once __DIR__ . "/../Model/Entity/AbstractPost.php";
    require_once __DIR__ . "/../Model/Entity/User.php";
    require_once __DIR__ . "/../Model/Entity/Recipe.php";
    require_once __DIR__ . "/../Model/Entity/Comment.php";
    require_once __DIR__ . "/../Model/Entity/Ingredient.php";
    require_once __DIR__ . "/../Model/Entity/Unit.php";

    //Manager
    require_once __DIR__ . "/../Model/Manager/ManagerInterface.php";
    require_once __DIR__ . "/../Model/Manager/UserManager.php";
    require_once __DIR__ . "/../Model/Manager/RoleManager.php";
    require_once __DIR__ . "/../Model/Manager/AbstractManager.php";
    require_once __DIR__ . "/../Model/Manager/RecipeManager.php";
    require_once __DIR__ . "/../Model/Manager/CommentManager.php";
    require_once __DIR__ . "/../Model/Manager/IngredientManager.php";
    require_once __DIR__ . "/../Model/Manager/UnitManager.php";


//Controller
require_once __DIR__ . "/../Controller/AbstractController.php";
require_once __DIR__ . "/../Controller/RootController.php";
require_once __DIR__ . "/../Controller/ControllerInterface.php";
require_once __DIR__ . "/../Controller/RecipeController.php";
require_once __DIR__ . "/../Controller/CommentController.php";


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
