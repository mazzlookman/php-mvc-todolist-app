<?php

namespace Aqibmoh\PHP\MVC\Repository\Session;

use Aqibmoh\PHP\MVC\Config\Database;
use Aqibmoh\PHP\MVC\Domain\Session;
use Aqibmoh\PHP\MVC\Domain\User;
use Aqibmoh\PHP\MVC\Repository\User\UserRepository;
use Aqibmoh\PHP\MVC\Repository\User\UserRepositoryImpl;
use PHPUnit\Framework\TestCase;

class SessionRepositoryImplTest extends TestCase
{
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    private function saveUser():User{
        $user = new User();
        $user->name = "Lookman";
        $user->username = "lookman";
        $user->password = "123";
        return $this->userRepository->save($user);
    }

    protected function setUp():void
    {
        $this->sessionRepository = new SessionRepositoryImpl(Database::getConnectionTest());
        $this->userRepository = new UserRepositoryImpl(Database::getConnectionTest());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testSave()
    {
        $saveUser = $this->saveUser();

        $sess = new Session();
        $sess->id = uniqid();
        $sess->userId = $saveUser->id;
        $save = $this->sessionRepository->save($sess);

        self::assertEquals($sess->id, $save->id);
        self::assertEquals($sess->userId, $save->userId);
    }

    public function testFindByID()
    {
        $saveUser = $this->saveUser();

        $sess = new Session();
        $sess->id = uniqid();
        $sess->userId = $saveUser->id;
        $save = $this->sessionRepository->save($sess);

        $byID = $this->sessionRepository->findByID($save->id);
        self::assertEquals($sess->id, $byID->id);
        self::assertEquals($sess->userId, $byID->userId);
    }

    public function testDeleteByID()
    {
        $saveUser = $this->saveUser();

        $sess = new Session();
        $sess->id = uniqid();
        $sess->userId = $saveUser->id;
        $this->sessionRepository->save($sess);

        $this->sessionRepository->deleteByID($sess->id);

        $byID = $this->sessionRepository->findByID($sess->id);

        self::assertNull($byID);
    }

}
