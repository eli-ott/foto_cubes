<?php
require_once('./Model/Model.php');

class PasswordManager extends Model
{
    /**
     * Update le mot de passe de l'utiliateur
     * 
     * @param string $hash Le mot de passe
     * @param int $nb_essais Référence le nombre de fois que le mot de passe a été changé
     * @param int $id_user Récupère l'id de l'utiliateur qui souhaite changer son password
     * @return int Le code status de la requete
     */
    public function updatePassword(string $hash, int $nb_essais, int $id_user): int
    {
        $sql = "UPDATE mot_de_passe JOIN utilisateur ON id_mot_de_passe = id_mot_de_passe SET `hash` = :mdp, nb_essais = :nb_essais WHERE id_user = :id_user";

        $req = $this->getBDD()->prepare($sql, [
            "mdp" => $hash,
            "nb_essais" => $nb_essais,
            "id_user" => $id_user
        ]);
        $req->execute();

        if (!$req) {
            $status = 500;
        } else {
            $status = 200;
        }

        return $status;
    }

    /**
     * Supprime le compte de l'utiliateur
     * 
     * @param int $id_user Récupère l'id de l'utiliateur qui souhaite supprimer son compte
     * @return int Le code status de la requete
     */
    public function deletePassword(int $id_user): int
    {
        $sql = "DELETE FROM mot_de_passe INNER JOIN utilisateur ON id_mot_de_passe = id_mot_de_passe WHERE id_user = :id_user";

        $req = $this->getBDD()->prepare($sql, [
            "id_user" => $id_user
        ]);
        $req->execute();

        if (!$req) {
            $status = 500;
        } else {
            $status = 200;
        }

        return $status;
    }

    /**
     * Récuperer le password de l'utiliateur
     * 
     * @param int $id_user Récupère l'id de l'utilisateur 
     * @return int Le code status dela requete
     */
    public function getPassword(int $id_user): int
    {
        $sql = "SELECT mot_de_passe.id_mot_de_passe, `hash`, date_reinitialisation, utilisateur.id_user, pseudo FROM mot_de_passe INNER JOIN utilisateur ON mot_de_passe.id_mot_de_passe = utilisateur.id_mot_de_passe WHERE id_mot_de_passe = :id_mot_de_passe";

        $req = $this->getBDD()->prepare($sql, [
            "id_user" => $id_user
        ]);
        $req->execute();

        if (!$req) {
            $status = 500;
        } else {
            $status = 200;
        }

        return $status;
    }

    /**
     * Crée un password pour un nouvelle utilisateur
     * 
     * @param int $id_mot_de_passe Crée un id pour le mdp
     * @param int $id_user Lie le mdp a l'utilisateur
     * @param string $hash Stock le mdp hasher
     * @return int Le code status de la requete
     */
    public function createPassword(int $id_mot_de_passe, int $id_user, string $hash): int
    {
        $sql = "INSERT INTO mot_de_passe ( id_mot_de_passe, `hash`) VALUE (:id_mdp, :mdp)";

        $req = $this->getBDD()->prepare($sql, [
            "id_mdp" => $id_mot_de_passe,
            "mdp" => $hash
        ]);
        $req->execute();

        if (!$req) {
            $status = 500;
        } else {
            $status = 200;
        }

        return $status;
    }
}
