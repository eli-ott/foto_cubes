<?php
require_once('./Model/Model.php');

class MessageManager extends Model
{
    /**
     * Ajoute le message a la base de donnée
     * 
     * @param string $message Le message envoyer
     * @param int $id_receveur recupère l'id_receveur
     * @param int $id_envoyeur recupère l'id_envoyeur
     * @return int Le code statut de la requête
     */
    public function saveMail(string $message, int $id_receveur, int $id_envoyeur): int
    {
        $sql = "INSERT INTO envoyer (id_envoyeur, id_receveur, `message`) VALUES (:id_envoyeur, :id_receveur, :msg)";

        $req = $this->getBDD()->prepare($sql, [
            "id_envoyeur" => $id_envoyeur,
            "id_receveur" => $id_receveur,
            "msg" => $message
        ]);
        $req->execute();

        if (!$req) {
            $status = 500;
        } else {
            $status = 200;
        }

        return $status;
    }
};
