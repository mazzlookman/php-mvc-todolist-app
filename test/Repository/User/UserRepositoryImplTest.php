<?php

namespace Aqibmoh\PHP\MVC\Repository\User;

use Aqibmoh\PHP\MVC\Config\Database;
use Aqibmoh\PHP\MVC\Domain\User;
use PHPUnit\Framework\TestCase;

class UserRepositoryImplTest extends TestCase
{
    private UserRepository $userRepository;

    protected function setUp():void
    {
        $this->userRepository = new UserRepositoryImpl(Database::getConnectionTest());
        $this->userRepository->deleteAll();
    }

    public function testSave()
    {
        $user = new User();
        $user->name = "Lookman";
        $user->username = "lookman";
        $user->password = password_hash("123",PASSWORD_BCRYPT);
        $save = $this->userRepository->save($user);

        var_dump($save->id);
        self::assertEquals($user->name, $save->name);
        self::assertTrue(password_verify("123",$save->password));
    }

    public function testFindByUserName()
    {
        $user = new User();
        $user->name = "Lookman";
        $user->username = "lookman";
        $user->password = password_hash("123",PASSWORD_BCRYPT);
        $this->userRepository->save($user);

        $byID = $this->userRepository->findByUsername("lookman");

        self::assertEquals("Lookman", $byID->name);
        self::assertEquals("lookman", $byID->username);
        self::assertTrue(password_verify("123",$byID->password));
    }

    public function testFindByIDNotFound()
    {
        $byID = $this->userRepository->findByID(2);
        self::assertNull($byID);

    }

    public function testDeleteByID()
    {
        $user = new User();
        $user->name = "Lookman";
        $user->username = "lookman";
        $user->password = password_hash("123",PASSWORD_BCRYPT);
        $this->userRepository->save($user);

        $byUsername = $this->userRepository->findByUsername($user->username);

        $this->userRepository->deleteByID($byUsername->id);

        $byID = $this->userRepository->findByID($byUsername->id);
        self::assertNull($byID);
    }


}
