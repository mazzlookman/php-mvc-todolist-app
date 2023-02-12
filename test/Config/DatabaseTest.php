<?php

namespace Aqibmoh\PHP\MVC\Config;

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private Database $db;

    public function testConnectionsTest()
    {
        $this->db = new Database();
        $connection = $this->db->getConnectionTest();
        self::assertNotNull($connection);
    }

    public function testConnections()
    {
        $this->db = new Database();
        $connection = $this->db->getConnection();
        self::assertNotNull($connection);
    }
}
