<?php

/**
 * Les fonctions liées à l'envoi de mail
 */
class SendMail
{
    /**
     * Envoi un mail à un utilisateur donné avec le message et l'objet donné
     *
     * @param string $receiver Le receveur du mail
     * @param string $object L'objet du mail
     * @param string $message Le message du mail
     * @return int Le code statut
     * @throws Exception
     */
    public static function sendMail(string $receiver, string $object, string $message): int
    {
        if (mail($receiver, $object, $message)) {
            $status = 200;
        } else {
            throw new Exception('Erreur lors de l\'envois du mail', 500);
        }

        return $status;
    }
}
