<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Aqibmoh\PHP\MVC\App\Router;
use Aqibmoh\PHP\MVC\Controller\HomeController;
use Aqibmoh\PHP\MVC\Controller\TodoList\TodoListControllerImpl;
use Aqibmoh\PHP\MVC\Controller\User\UserControllerImpl;
use Aqibmoh\PHP\MVC\Middleware\MustLoginMiddleware;
use Aqibmoh\PHP\MVC\Middleware\MustNotLoginMiddleware;

Router::add("GET","/", HomeController::class, "home");
Router::add("GET","/users/login", UserControllerImpl::class,"loginPage", [MustNotLoginMiddleware::class]);
Router::add("POST","/users/login", UserControllerImpl::class,"postLogin",[MustNotLoginMiddleware::class]);
Router::add("GET","/users/logout",UserControllerImpl::class,"logout",[MustLoginMiddleware::class]);
Router::add("GET","/users/register",UserControllerImpl::class,"registerPage",[MustNotLoginMiddleware::class]);
Router::add("POST","/users/register",UserControllerImpl::class,"postRegister",[MustNotLoginMiddleware::class]);
Router::add("GET","/users/register/success",UserControllerImpl::class,"afterRegister",[MustNotLoginMiddleware::class]);
Router::add("GET","/users/workspace",UserControllerImpl::class,"workSpace",[MustLoginMiddleware::class]);
if (isset($_POST['deleteTodoButton'])){
    Router::add("POST","/users/workspace", TodoListControllerImpl::class,"postDeleteByID",[MustLoginMiddleware::class]);
}
if (isset($_POST['editTodoButton'])){
    Router::add("POST","/users/workspace", TodoListControllerImpl::class,"postUpdate",[MustLoginMiddleware::class]);
}
Router::add("POST","/users/workspace", TodoListControllerImpl::class,"postCreate",[MustLoginMiddleware::class]);

Router::run();
