<?php

namespace Aqibmoh\PHP\MVC\Controller\User;

use Aqibmoh\PHP\MVC\Config\Database;
use Aqibmoh\PHP\MVC\Model\UserRegisterRequest;
use Aqibmoh\PHP\MVC\Repository\User\UserRepositoryImpl;
use Aqibmoh\PHP\MVC\Service\User\UserService;
use Aqibmoh\PHP\MVC\Service\User\UserServiceImpl;
use PHPUnit\Framework\TestCase;

class UserControllerImplTest extends TestCase
{
    private UserService $userService;
    private UserContoller $userController;

    protected function setUp():void
    {
        $userRepository = new UserRepositoryImpl(Database::getConnectionTest());
        $this->userService = new UserServiceImpl($userRepository);
        $this->userContoller = new UserControllerImpl();

        $userRepository->deleteAll();
    }

    public function testLoginSuccess()
    {
        $request = new UserRegisterRequest();
        $request->name = "Pram";
        $request->username = "pram";
        $request->password = "123";
        $this->userService->register($request);

        $_POST["username"] = $request->username;
        $_POST["password"] = $request->password;

        $this->userController->postLogin();


    }


}
