<?php

namespace Aqibmoh\PHP\MVC\Service\User;

use Aqibmoh\PHP\MVC\Config\Database;
use Aqibmoh\PHP\MVC\Domain\User;
use Aqibmoh\PHP\MVC\Exception\ValidationException;
use Aqibmoh\PHP\MVC\Model\UserLoginRequest;
use Aqibmoh\PHP\MVC\Model\UserLoginResponse;
use Aqibmoh\PHP\MVC\Model\UserRegisterRequest;
use Aqibmoh\PHP\MVC\Model\UserRegisterResponse;
use Aqibmoh\PHP\MVC\Repository\User\UserRepository;

class UserServiceImpl implements UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request): UserRegisterResponse
    {
        $this->validateUserRegisterRequest($request);
        try {
            Database::begin();
            $byUsername = $this->userRepository->findByUsername($request->username);

            if ($byUsername != null){
                throw new ValidationException("Username is already exist, please type some else");
            }

            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = password_hash($request->password,PASSWORD_BCRYPT);

            $save = $this->userRepository->save($user);

            $response = new UserRegisterResponse();
            $response->user = $save;

            Database::commit();
            return $response;
        }catch (\Exception $exception){
            Database::rollback();
            throw $exception;
        }
    }

    private function validateUserRegisterRequest(UserRegisterRequest $request):void{
        if (($request->name==null || trim($request->name)=="") ||
            ($request->username==null || trim($request->username)=="") ||
            ($request->password==null || trim($request->password)=="")){
            throw new ValidationException("Your input is blank, please fill that");
        }
    }

    public function login(UserLoginRequest $request): UserLoginResponse
    {
        $user = new User();
        $user->username = $request->username;
        $user->password = $request->password;
        $this->validateUserLoginRequest($request);
        try {
            $byUsername = $this->userRepository->findByUsername($user->username);
            if ($byUsername == null){
                throw new ValidationException("Username or password is wrong");
            }

            if (password_verify($request->password,$byUsername->password)){
                $response = new UserLoginResponse();
                $response->user = $byUsername;
                return $response;
            }else{
                throw new ValidationException("Username or password is wrong");
            }
        }catch (ValidationException $exception){
            throw $exception;
        }
    }

    private function validateUserLoginRequest(UserLoginRequest $request):void{
        if (($request->username==null || trim($request->username)=="") ||
            ($request->password==null || trim($request->password)=="")){
            throw new ValidationException("Your input is blank, please fill that");
        }
    }
}