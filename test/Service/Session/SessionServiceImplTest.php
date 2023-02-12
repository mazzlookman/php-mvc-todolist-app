<?php
namespace Aqibmoh\PHP\MVC\Service\Session;

function setcookie(string $name, string $value){
    echo "$name:$value";
}

use Aqibmoh\PHP\MVC\Config\Database;
use Aqibmoh\PHP\MVC\Domain\User;
use Aqibmoh\PHP\MVC\Repository\Session\SessionRepository;
use Aqibmoh\PHP\MVC\Repository\Session\SessionRepositoryImpl;
use Aqibmoh\PHP\MVC\Repository\User\UserRepository;
use Aqibmoh\PHP\MVC\Repository\User\UserRepositoryImpl;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;


class SessionServiceImplTest extends TestCase
{
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;
    private SessionService $sessionService;

    private function saveUser():?User{
        $user = new User();
        $user->name = "Lookman";
        $user->username = "lookman";
        $user->password = "123";
        return $this->userRepository->save($user);
    }

    protected function setUp():void
    {
        $this->userRepository = new UserRepositoryImpl(Database::getConnectionTest());
        $this->sessionRepository = new SessionRepositoryImpl(Database::getConnectionTest());
        $this->sessionService = new SessionServiceImpl($this->sessionRepository,$this->userRepository);

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

    }

    public function testCreateSession()
    {
        $saveUser = $this->saveUser();
        $session = $this->sessionService->create($saveUser->id);
        self::expectOutputRegex("[I-BELL-A:$session->id]");

        $byID = $this->sessionRepository->findByID($session->id);
        self::assertEquals($byID->userId, $saveUser->id);
    }

    public function testDestroy()
    {
        $saveUser = $this->saveUser();
        $session = $this->sessionService->create($saveUser->id);
        $_COOKIE[SessionServiceImpl::$COOKIE_NAME] = $session->id;

        $this->sessionService->destroy();
        self::expectOutputRegex("[I-BELL-A:]");

        $byID = $this->sessionRepository->findByID($session->id);
        self::assertNull($byID);
    }

    public function testCurrentUser()
    {
        $saveUser = $this->saveUser();
        $session = $this->sessionService->create($saveUser->id);
        $_COOKIE[SessionServiceImpl::$COOKIE_NAME] = $session->id;

        $currentUser = $this->sessionService->currentUser();
        self::assertEquals($saveUser->name, $currentUser->name);
        self::assertEquals($saveUser->username, $currentUser->username);
        self::assertEquals($saveUser->password, $currentUser->password);
    }
}
