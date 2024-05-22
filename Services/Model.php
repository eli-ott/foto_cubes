<?php

abstract class Model
{
    /**
     * @var ?PDO $pdo le PDO de la base
     */
    private static ?PDO $pdo = null;

    /**
     * Set la connexion à la base de donnée
     */
    private static function setBDD()
    {
        self::$pdo = new PDO("mysql:host=localhost;dbname=foto;charset=utf8", "root", "");
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    /**
     * Créer une connexion à la base de donnée
     * 
     * @return PDO Le PDO de la base
     */
    protected function getBDD(): PDO
    {
        if (self::$pdo === null) {
            self::setBDD();
        }

        return self::$pdo;
    }
}
