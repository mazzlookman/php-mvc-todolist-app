<?php

namespace Aqibmoh\PHP\MVC\Service\Session;

use Aqibmoh\PHP\MVC\Domain\Session;
use Aqibmoh\PHP\MVC\Domain\User;
use Aqibmoh\PHP\MVC\Repository\Session\SessionRepository;
use Aqibmoh\PHP\MVC\Repository\User\UserRepository;
use Aqibmoh\PHP\MVC\Repository\User\UserRepositoryImpl;

class SessionServiceImpl implements SessionService
{
    public static string $COOKIE_NAME = "I-BELL-A";
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    public function create(string $userID): Session
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userId = $userID;

        $this->sessionRepository->save($session);

        setcookie(self::$COOKIE_NAME,$session->id,time()+60*60*24*30,"/");

        return $session;
    }

    public function destroy(): void
    {
        $sessionID = $_COOKIE[self::$COOKIE_NAME]??"";
        $this->sessionRepository->deleteByID($sessionID);

        setcookie(self::$COOKIE_NAME,"",1,"/");
    }

    public function currentUser(): ?User
    {
        $sessionID = $_COOKIE[self::$COOKIE_NAME]??"";
        $session = $this->sessionRepository->findByID($sessionID);

        if ($session==null){
            return null;
        }

        return $this->userRepository->findByID($session->userId);
    }
}