<?php
require_once('./Services/Model.php');

class PasswordManager extends Model
{
    /**
     * Update le mot de passe de l’utilisateur
     * 
     * @param string $hash Le mot de passe
     * @param int $id_user Récupère l'id de l'utilisateur qui souhaite changer son password
     * @return int Le code status de la requête
     */
    public function updatePassword(string $hash, int $id_user): int
    {
        $sql = "UPDATE mot_de_passe mdp JOIN utilisateur user ON mdp.id_mot_de_passe = user.id_mot_de_passe 
            SET `hash` = :mdp, date_reinitialisation = NOW() WHERE user.id_user = :id_user";

        $req = $this->getBDD()->prepare($sql, [
            "mdp" => $hash,
            "id_user" => $id_user
        ]);
        $req->execute();

        if ($req) {
            return 200;
        } else {
            throw new Exception('Erreur lors de la mise à jour du mot de passe', 500);
        }
    }

    /**
     * Supprime le compte de l'utilisateur
     * 
     * @param int $id_user Récupère l'id de l'utilisateur qui souhaite supprimer son compte
     * @return int Le code status de la requête
     */
    public function deletePassword(int $id_user): int
    {
        $sql = "DELETE mot_de_passe FROM mot_de_passe INNER JOIN utilisateur ON mot_de_passe.id_mot_de_passe = utilisateur.id_mot_de_passe WHERE utilisateur.id_user = :id_user";

        $req = $this->getBDD()->prepare($sql, [
            "id_user" => $id_user
        ]);
        $req->execute();

        if ($req) {
            return 200;
        } else {
            throw new Exception('Erreur lors de la suppression du mot de passe', 500);
        }
    }

    /**
     * Récupérer le password de l'utilisateur en fonction de son pseudo
     * 
     * @param int $idUser L'identifiant du user
     * @return MotDePasse Les données du mot de passe
     */
    public function getPassword(int $idUser): MotDePasse
    {
        $sql = "SELECT mot_de_passe.id_mot_de_passe, `hash`, ng_essais, date_reinitialisation, utilisateur.id_user, utilisateur.pseudo 
            FROM mot_de_passe 
            INNER JOIN utilisateur ON mot_de_passe.id_mot_de_passe = utilisateur.id_mot_de_passe 
            WHERE utilisateur.id_user = :idUser";

        $req = $this->getBDD()->prepare($sql, [
            "idUser" => $idUser
        ]);
        $req->execute();

        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $data = new MotDePasse(
                $row->id_mot_de_passe,
                $row->hash,
                $row->nb_essais,
                $row->date_reinitialisation
            );
        }

        return $data;
    }

    /**
     * Crée un password pour un nouvelle utilisateur
     * 
     * @param string $hash Stock le mdp hashée
     * @return int Le code status de la requête
     */
    public function createPassword(string $hash): int
    {
        $sql = "INSERT INTO mot_de_passe (`hash`) VALUE (:mdp)";

        $req = $this->getBDD()->prepare($sql);
        $req->bindValue('mdp', $hash, PDO::PARAM_STR);
        $req->execute();

        if ($req) {
            return $this->getBDD()->lastInsertId();
        } else {
            throw new Exception('Erreur lors de la création du mot de passe', 500);
        }
    }
}
