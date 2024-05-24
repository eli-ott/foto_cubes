<?php

require_once('Services/SendMail.php');
require_once('Model/MessageManager.php');

/**
 * Le controller pour les messages
 */
class MessageController
{
    /**
     * @var MessageManager $messageManager Le manager pour les messages
     */
    private MessageManager $messageManager;
    /**
     * @var CompteManager $compteManager Le manager pour les comptes
     */
    private CompteManager $compteManager;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->messageManager = new MessageManager;
        $this->compteManager = new CompteManager();
    }

    /**
     * Permet d'envoyer le mail et de l'ajouter à la base de donnée
     */
    public function sendMail(): void
    {
        $objet = Securite::secureHTML($_POST['subject']);
        $message = Securite::secureHTML($_POST['message']);
        $receiver = Securite::secureHTML($_POST['receiver']);

        try {
            SendMail::sendMail($receiver, $objet, $message);

            $sender = $this->compteManager->getUserEmail($_COOKIE['id']);
            $this->messageManager->saveMail($message, $receiver, $sender);

            Utils::newAlert('Mail envoyé avec succès', Constants::TYPES_MESSAGES['success']);
            Utils::redirect(URL . 'galerie');
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'galerie');
        }
    }
}
