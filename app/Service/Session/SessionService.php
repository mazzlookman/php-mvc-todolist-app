<?php

namespace Aqibmoh\PHP\MVC\Service\Session;

use Aqibmoh\PHP\MVC\Domain\Session;
use Aqibmoh\PHP\MVC\Domain\User;

interface SessionService
{
    public function create(string $userID):Session;

    public function destroy():void;

    public function currentUser():?User;
}