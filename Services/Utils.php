<?php

class Utils
{
    /**
     * Permet de générer un token aléatoire
     * 
     * @return string Le token
     */
    public static function generateToken(): string
    {
        return bin2hex(random_bytes(64));
    }

    /**
     * Converti des heures en secondes
     * 
     * @param int $hours Les heures à convertir
     * @return int Les secondes
     */
    public static function hoursToSeconds(int $hours): int
    {
        return $hours * 3600;
    }
}
