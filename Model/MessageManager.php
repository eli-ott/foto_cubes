<?php
require_once('Services/Model.php');

/**
 * Le manager pour gérer les messages envoyé
 */
class MessageManager extends Model
{
    /**
     * Ajoute le message à la base de donnée
     * 
     * @param string $message Le message envoyer
     * @param int $idReceveur récupère l'id_receveur
     * @param int $idEnvoyeur récupère l'id_envoyeur
     * @return int Le code statut de la requête
     * @throws Exception
     */
    public function saveMail(string $message, int $idReceveur, int $idEnvoyeur): int
    {
        $sql = "INSERT INTO envoyer (id_envoyeur, id_receveur, `message`) VALUES (:id_envoyeur, :id_receveur, :msg)";

        $req = $this->getBDD()->prepare($sql, [
            "id_envoyeur" => $idEnvoyeur,
            "id_receveur" => $idReceveur,
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
