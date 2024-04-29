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

    /**
     * Permet de redirigé de manière efficiente
     * 
     * @param string $url L'url pour la redirection
     */
    public static function redirect(string $url): void
    {
        header("Location: " . $url);
        exit();
    }

    /**
     * Permet d'ajouter un message pour l'utilisateur
     * 
     * @param string $message Le message à afficher
     * @param int $type Le type de message
     */
    public static function newAlert(string $message, int $type): void
    {
        $_SESSION['alert']['message'] = $message;
        $_SESSION['alert']['type'] = $type;
    }

    /**
     * Permet de hash un mot de passe
     * 
     * @param string $password Le mot de passe
     * @return string Le mot de passe hash
     */
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
