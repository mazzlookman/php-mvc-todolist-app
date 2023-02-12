<?php

namespace Aqibmoh\PHP\MVC\Config;

class Database
{
    private static ?\PDO $pdo = null;

    public static function getConnection():\PDO{
        if (self::$pdo == null){
            self::$pdo = new \PDO(
                "mysql:host=localhost:3306;dbname=php_todolist_app","root",""
            );
        }
        return self::$pdo;
    }

    public static function getConnectionTest():\PDO{
        if (self::$pdo == null){
            self::$pdo = new \PDO(
                "mysql:host=sql307.epizy.com;dbname=epiz_33570762_php_todolist_app","epiz_33570762","TNvchB3PzZwoe2"
            );
        }
        return self::$pdo;
    }

    public static function begin():void{
        self::$pdo->beginTransaction();
    }

    public static function commit():void{
        self::$pdo->commit();
    }

    public static function rollback():void{
        self::$pdo->rollBack();
    }
}