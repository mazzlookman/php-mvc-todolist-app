<?php

namespace Aqibmoh\PHP\MVC\Service\User;

use Aqibmoh\PHP\MVC\Model\UserLoginRequest;
use Aqibmoh\PHP\MVC\Model\UserLoginResponse;
use Aqibmoh\PHP\MVC\Model\UserRegisterRequest;
use Aqibmoh\PHP\MVC\Model\UserRegisterResponse;

interface UserService
{
    public function register(UserRegisterRequest $request):UserRegisterResponse;
    public function login(UserLoginRequest $request):UserLoginResponse;
}