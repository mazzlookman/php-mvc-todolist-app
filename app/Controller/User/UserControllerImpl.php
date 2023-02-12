<?php

namespace Aqibmoh\PHP\MVC\Controller\User;

use Aqibmoh\PHP\MVC\App\ViewRender;
use Aqibmoh\PHP\MVC\Config\Database;
use Aqibmoh\PHP\MVC\Exception\ValidationException;
use Aqibmoh\PHP\MVC\Model\UserLoginRequest;
use Aqibmoh\PHP\MVC\Model\UserRegisterRequest;
use Aqibmoh\PHP\MVC\Repository\Session\SessionRepositoryImpl;
use Aqibmoh\PHP\MVC\Repository\TodoList\TodoListRepositoryImpl;
use Aqibmoh\PHP\MVC\Repository\User\UserRepository;
use Aqibmoh\PHP\MVC\Repository\User\UserRepositoryImpl;
use Aqibmoh\PHP\MVC\Service\Session\SessionService;
use Aqibmoh\PHP\MVC\Service\Session\SessionServiceImpl;
use Aqibmoh\PHP\MVC\Service\TodoList\TodoListService;
use Aqibmoh\PHP\MVC\Service\TodoList\TodoListServiceImpl;
use Aqibmoh\PHP\MVC\Service\User\UserService;
use Aqibmoh\PHP\MVC\Service\User\UserServiceImpl;

class UserControllerImpl implements UserContoller
{
    private UserService $userService;
    private UserRepository $userRepository;
    private SessionService $sessionService;
    private TodoListService $todoListService;

    public function __construct()
    {
        $this->userRepository = new UserRepositoryImpl(Database::getConnectionTest());
        $this->userService = new UserServiceImpl($this->userRepository);
        $this->sessionService = new SessionServiceImpl(
            new SessionRepositoryImpl(Database::getConnectionTest()),
            $this->userRepository
        );
        $this->todoListService = new TodoListServiceImpl(
            new TodoListRepositoryImpl(Database::getConnectionTest())
        );
    }

    //Register Page
    public function registerPage():void{
        ViewRender::render("User/register.php",["title"=>"Register user here!"]);
    }

    public function postRegister():void{
        $request = new UserRegisterRequest();
        $request->name = $_POST["name"];
        $request->username = $_POST["username"];
        $request->password = $_POST["password"];

        try {
            $response = $this->userService->register($request);
            ViewRender::redirect("/users/register/success?n=".$response->user->name);
        }catch (ValidationException $exception){
            ViewRender::render("User/register.php",[
                "title"=>"Register user here!",
                "error"=>$exception->getMessage()
            ]);
        }
    }

    //Login Page
    public function loginPage():void{
        ViewRender::render("User/login.php",["title"=>"Login Here"]);
    }

    public function postLogin():void{
        $request = new UserLoginRequest();
        $request->username = $_POST["username"];
        $request->password = $_POST["password"];

        try {
            $response = $this->userService->login($request);
            $this->sessionService->create($response->user->id);
            ViewRender::redirect("/users/workspace");
        }catch (ValidationException $exception){
            ViewRender::render("User/login.php",[
                "title"=>"Login here",
                "error"=>$exception->getMessage()
            ]);
        }
    }

    public function logout():void{
        $this->sessionService->destroy();
        ViewRender::redirect("/");
    }

    public function workSpace(): void
    {
        $currentUser = $this->sessionService->currentUser();
        $arr = $this->todoListService->findByUserID($currentUser->id);
        $rows = [];
        foreach ($arr as $row){
            $rows[] = $row;
        }
        ViewRender::render("User/work_space.php",[
            "title"=>"Workspace",
            "allTodoList"=> $rows
        ]);
    }

    public function afterRegister():void{
        ViewRender::render("User/after_register.php",[
            "title"=>"Register success",
            "message"=>"Your registration has been successfully"]);
    }

}