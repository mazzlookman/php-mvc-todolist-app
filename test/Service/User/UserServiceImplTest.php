<?php

namespace Aqibmoh\PHP\MVC\Service\User;

use Aqibmoh\PHP\MVC\Config\Database;
use Aqibmoh\PHP\MVC\Domain\User;
use Aqibmoh\PHP\MVC\Exception\ValidationException;
use Aqibmoh\PHP\MVC\Model\UserLoginRequest;
use Aqibmoh\PHP\MVC\Model\UserRegisterRequest;
use Aqibmoh\PHP\MVC\Repository\User\UserRepository;
use Aqibmoh\PHP\MVC\Repository\User\UserRepositoryImpl;
use PHPUnit\Framework\TestCase;

class UserServiceImplTest extends TestCase
{
    private UserService $userService;
    private UserRepository $userRepository;

    protected function setUp():void
    {
        $this->userRepository = new UserRepositoryImpl(Database::getConnectionTest());
        $this->userService = new UserServiceImpl($this->userRepository);
        $this->userRepository->deleteAll();
    }

    public function testRegisterSuccess()
    {
        $request = new UserRegisterRequest();
        $request->name = "Pram";
        $request->username = "pram";
        $request->password = "123";

        $response = $this->userService->register($request);

        self::assertEquals("Pram",$response->user->name);
        self::assertEquals("pram",$response->user->username);
        self::assertEquals(true,password_verify("123",$response->user->password));
    }

    public function testRegisterAlreadyExist()
    {
        $user = new User();
        $user->name = "Lookman";
        $user->username = "lookman";
        $user->password = password_hash("123",PASSWORD_BCRYPT);
        $this->userRepository->save($user);

        self::expectException(ValidationException::class);
        $request = new UserRegisterRequest();
        $request->name = "Lookman";
        $request->username = "lookman";
        $request->password = password_hash("123",PASSWORD_BCRYPT);
        $this->userService->register($request);
        self::expectOutputRegex("[User is already exist]");
    }

    public function testRegisterValidationError()
    {
        self::expectException(ValidationException::class);
        $request = new UserRegisterRequest();
        $request->name = "";
        $request->username = "";
        $request->password = password_hash("123",PASSWORD_BCRYPT);
        $this->userService->register($request);
        self::expectOutputRegex("[Your input is blank, please fill that]");
    }

    public function testLoginSuccess()
    {
        $user = new UserRegisterRequest();
        $user->name = "Lookman";
        $user->username = "lookman";
        $user->password = "password";
        $this->userService->register($user);
//        var_dump($userRegisterResponse);

        $login = new UserLoginRequest();
        $login->username = "lookman";
        $login->password = "password";

        $userLoginResponse = $this->userService->login($login);

        self::assertEquals($user->name , $userLoginResponse->user->name);
        self::assertEquals($user->username , $userLoginResponse->user->username);
        self::assertTrue(password_verify($user->password, $userLoginResponse->user->password));
    }

    public function testLoginWrong()
    {
        $user = new UserRegisterRequest();
        $user->name = "Lookman";
        $user->username = "lookman";
        $user->password = "password";
        $this->userService->register($user);

        self::expectException(ValidationException::class);
        $login = new UserLoginRequest();
        $login->username = "lookman";
        $login->password = "passwordd";
        $this->userService->login($login);
        self::expectOutputRegex("[Username or password is wrong]");
    }

    public function testLoginNotFound()
    {
        $user = new UserRegisterRequest();
        $user->name = "Lookman";
        $user->username = "lookman";
        $user->password = "password";
        $this->userService->register($user);

        self::expectException(ValidationException::class);
        $login = new UserLoginRequest();
        $login->username = "asasas";
        $login->password = "passwordd";
        $this->userService->login($login);
        self::expectOutputRegex("[User is not found]");
    }

    public function testLoginValidationError()
    {
        self::expectException(ValidationException::class);
        $login = new UserLoginRequest();
        $login->username = "";
        $login->password = "passwordd";
        $this->userService->login($login);
        self::expectOutputRegex("[Your input is blank, please fill that]");
    }
}
