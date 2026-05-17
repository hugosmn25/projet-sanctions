<?php
declare(strict_types=1); //mode strict pour les types de données (pas de conversion automatique)

require_once __DIR__ . '/../vendor/autoload.php';
session_start();

$request = new App\Http\Request();
$response = new App\Http\Response();

$router = new App\Routing\Router($request, $response);

$authController = new App\Controller\AuthController();
$classController = new App\Controller\ClassController();
$studentController = new App\Controller\StudentController();
$professorController = new App\Controller\ProfessorController();
$sanctionController = new App\Controller\SanctionController();

$router->addRoute('index', [$authController, 'home'], ['GET']);
$router->addRoute('', [$authController, 'home'], ['GET']);
$router->addRoute('login', [$authController, 'login'], ['GET', 'POST']);
$router->addRoute('register', [$authController, 'register'], ['GET', 'POST']);
$router->addRoute('logout', [$authController, 'logout'], ['GET']);
$router->addRoute('dashboard', [$authController, 'dashboard'], ['GET']);

// Classes routes
$router->addRoute('create_class', [$classController, 'create'], ['GET', 'POST']);
$router->addRoute('liste-classes', [$classController, 'list'], ['GET']);

// Student routes
$router->addRoute('create_student', [$studentController, 'create'], ['GET', 'POST']);
$router->addRoute('liste-eleves', [$studentController, 'list'], ['GET']);

// Professor routes
$router->addRoute('create_professeur', [$professorController, 'create'], ['GET', 'POST']); 
$router->addRoute('liste-professeurs', [$professorController, 'list'], ['GET']);

// Sanction routes
$router->addRoute('create_sanction', [$sanctionController, 'create'], ['GET', 'POST']);
$router->addRoute('liste-sanctions', [$sanctionController, 'list'], ['GET']);

$router->handleRequest();