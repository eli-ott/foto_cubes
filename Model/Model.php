<?php

abstract class Model
{
    private static $pdo;

    private static function setBDD()
    {
        self::$pdo = new PDO("mysql:host=localhost;dbname=foto;charset=utf8", "root", "toor");
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    protected function getBDD(): PDO
    {
        if (self::$pdo === null) {
            self::setBDD();
        }

        return self::$pdo;
    }
}
