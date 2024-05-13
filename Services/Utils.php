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

    /**
     * permet d'envoyer un mail de verification
     * 
     * @param string $mail le mail du receveur
     */
    public function verifMail(string $mail)
    {
        $objet = 'votre code de verification';
        $_SESSION['codeVerif'] = $message = rand(1000, 9999);
        SendMail::sendMail($mail, $objet, $message);
    }

    /**
     * verifie si le code envoyer par mail est le bon
     * 
     * @param int $code code de verification
     * @return int le code status de la fonction
     */
    public function verifCode(int $code): int
    {
        if (intval($_SESSION['codeVerif']) === $code) {
            return 200;
        } else {
            throw new Exception('Ce n\'est pas le bon code', 500);
        };
    }
}
