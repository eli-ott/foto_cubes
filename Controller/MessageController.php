<?php

require_once('Services/SendMail.php');
require_once('Model/MessageManager.php');

class MessageController
{
    /**
     * @var MessageManager $messageManager Le manager pour les messages
     */
    private $messageManager;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->messageManager = new MessageManager;
    }

    /**
     * Permet d'envoyer le mail et de l'ajouter à la base de donnée
     */
    public function sendMail(): void
    {
        $objet = Securite::secureHTML($_POST['subject']);
        $message = Securite::secureHTML($_POST['message']);
        $sender = Securite::secureHTML($_POST['sender']);
        $receiver = Securite::secureHTML($_POST['receiver']);

        try {
            SendMail::sendMail($sender, $objet, $message);
            $this->messageManager->saveMail($message, $receiver, $sender);

            Utils::newAlert('Mail envoyé avec succès', Constants::TYPES_MESSAGES['success']);
            Utils::redirect(URL . 'galerie');
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'galerie');
        }
    }
}
