<?php
require_once('Services/Model.php');

class MessageManager extends Model
{
    /**
     * Ajoute le message a la base de donnée
     * 
     * @param string $message Le message envoyer
     * @param int $id_receveur récupère l'id_receveur
     * @param int $id_envoyeur récupère l'id_envoyeur
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

        if ($req) {
            return 200;
        } else {
            throw new Exception('Erreur lors de la sauvegarde du message', 500);
        }
    }
};
