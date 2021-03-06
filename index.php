<?php
declare(strict_types=1);

require_once realpath(__DIR__ . "/vendor/autoload.php");
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

//Require Models
require 'Models/User.php';
require 'Models/Product.php';
require 'Models/PriceCalculator.php';
require 'Models/Quantity.php';
require 'Models/DataSource.php';

//Require Controllers
require 'Controllers/HomeController.php';

//Instantiate a new default Controller
$controller = new HomeController();

//Tell the controller to display a view by calling the render function
$controller->render($_GET, $_POST);