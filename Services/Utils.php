<?php

/**
 * Toutes les fonctions utilitaires
 */
class Utils
{
    /**
     * Permet de générer un token aléatoire
     *
     * @return string Le token
     * @throws Exception
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
     * Permet de rediriger de manière efficiente
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
     * @param string $type Le type de message
     */
    public static function newAlert(string $message, string $type): void
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
     * Permet de vérifier si un utilisateur est connecté
     */
    public static function userConnected(): bool
    {
        return isset($_COOKIE['token']);
    }

    /**
     * Vérifie si l'utilisateur est admin ou non
     */
    public static function userAdmin(): bool
    {
        if (!isset($_COOKIE['isAdmin'])) {
            return false;
        }

        return (bool)$_COOKIE['isAdmin'];
    }

    /**
     * Permet d'ajouter un fichier
     *
     * @param mixed $file Le fichier à ajouter
     * @return ?string Le nom du fichier upload
     * @throws Exception
     */
    public static function uploadFile(mixed $file): ?string
    {
        if (empty($file['name'])) {
            throw new Exception('Vous devez choisir une image' . $file, 400);
        }
        if (!file_exists(Constants::URL_DOCUMENT)) {
            mkdir(Constants::URL_DOCUMENT);
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $uniqueName = bin2hex(random_bytes(4));
        $targetFile = Constants::URL_DOCUMENT . $uniqueName . '_' . $file['name'];

        if (!getimagesize($file['tmp_name'])) {
            throw new Exception('Le fichier n\'est pas une image', 400);
        }

        if (!in_array($extension, Constants::EXTENSIONS_ACCEPTEES)) {
            throw new Exception('L\'extension choisi n\'est pas autorisé', 400);
        }
        if (file_exists($targetFile)) {
            throw new Exception('Le fichier existe déjà', 400);
        }

        if ($file['size'] > 2000000) {
            throw new Exception('Fichier trop volumineux', 400);
        }

        if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
            throw new Exception('Erreur lors de l\'ajout de l\'image', 400);
        } else {
            return $targetFile;
        }
    }

    /**
     * Permet de supprimer un fichier du serveur
     *
     * @param string $fileName Le nom du fichier à supprimer
     * @return int Le code status
     * @throws Exception
     */
    public static function deleteFile(string $fileName): int
    {
        if (unlink($fileName)) {
            return 200;
        } else {
            throw new Exception('Erreur lors de la suppression du fichier', 500);
        }
    }

    /**
     * Permet d'envoyer un mail de verification
     *
     * @param string $mail le mail du receveur
     * @throws Exception
     */
    public static function verifMail(string $mail): void
    {
        $objet = 'Votre code de vérification';
        $_SESSION['codeVerif'] = $message = rand(1000, 9999);
        SendMail::sendMail($mail, $objet, $message);
    }

    /**
     * Vérifie si le code envoyé par mail est le bon
     *
     * @param int $code code de verification
     * @return int le code status de la fonction
     * @throws Exception
     */
    public static function verifCode(int $code): int
    {
        if (intval($_SESSION['codeVerif']) === $code) {
            unset($_SESSION['codeVerif']);
            return 200;
        } else {
            throw new Exception('Ce n\'est pas le bon code', 500);
        }
    }

    /**
     * Permets de vérifier que les champs d'un formulaire sont remplis
     *
     * @param array $champs Les champs à vérifier
     * @returns array Retourne les champs sécurisés
     * @throws Exception
     */
    public static function verifFields(array $champs): array
    {
        $champsSecurises = [];

        foreach ($champs as $champ) {
            if (!empty($_POST[$champ])) {
                $champsSecurises[] = [
                    $champ => Securite::secureHTML($_POST[$champ])
                ];
            } else {
                throw new Exception('Le champs ' . $champ . ' n\'est pas rempli', 405);
            }
        }

        return $champsSecurises;
    }
}
