CREATE DATABASE IF NOT EXISTS Foto;
USE Foto;

CREATE TABLE IF NOT EXISTS `mot_de_passe` (
    id_mot_de_passe INT PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'L''identifiant du mot de passe',
    `hash` TEXT NOT NULL COMMENT 'Le hash du mot de passe',
    nb_essais INT NOT NULL DEFAULT 0 COMMENT 'Le nombre d''essais de connexion, remis à zéro à chaque connexion réussi',
    date_reinitialisation DATETIME DEFAULT NULL COMMENT 'La dernière date de réinitialisation'
);

CREATE TABLE IF NOT EXISTS `utilisateur` (
    id_user INT PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'L''id du user',
    id_mot_de_passe INT NOT NULL COMMENT 'L''id du mot de passe',
    pseudo varchar(30) NOT NULL UNIQUE COMMENT 'Son pseudo',
    nom varchar(50) NOT NULL COMMENT 'Son nom',
    prenom varchar(50) NOT NULL COMMENT 'Son prénom',
    email varchar(100) NOT NULL COMMENT 'Son email',
    age INT NOT NULL COMMENT 'Son age',
    type_photo_pref varchar(50) NOT NULL COMMENT 'Son type de photo préféré',
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'La date de création de son compte',
    warn BOOLEAN NOT NULL DEFAULT 0 COMMENT 'Si le compte a été warn ou non',
    is_admin BOOLEAN NOT NULL DEFAULT 0 COMMENT 'Si l''utilisateur est admin ou non',
    compte_valide BOOLEAN NOT NULL DEFAULT 0 COMMENT 'Si l''utilisateur a validé son compte par email ou non',
    CONSTRAINT id_mot_de_passe_fk FOREIGN KEY (id_mot_de_passe) REFERENCES mot_de_passe(id_mot_de_passe)
);

CREATE TABLE IF NOT EXISTS `photo` (
    id_photo INT PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'L''id de la photo',
    id_user INT NOT NULL COMMENT 'L''id du user',
    titre varchar(50) NOT NULL COMMENT 'Le titre de la photo',
    date_prise_vue DATETIME NOT NULL COMMENT 'La date de prise de vue',
    source MEDIUMBLOB NOT NULL COMMENT 'La source de la photo',
    tag varchar(50) NOT NULL COMMENT 'Le tag de la photo',
    date_publication DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'La date de publication de la photo sur le site',
    CONSTRAINT id_user_FK FOREIGN KEY (id_user) REFERENCES utilisateur(id_user)
);

CREATE TABLE IF NOT EXISTS `envoyer` (
    id_envoyeur INT NOT NULL COMMENT 'L''id de l''utilisateur qui l''a envoyé',
    id_receveur INT NOT NULL COMMENT 'L''id de l''utilisateur qui l''a reçu',
    message text NOT NULL COMMENT 'Le message',
    CONSTRAINT id_envoyeur_FK FOREIGN KEY (id_envoyeur) REFERENCES utilisateur(id_user),
    CONSTRAINT id_receveur_FK FOREIGN KEY (id_receveur) REFERENCES utilisateur(id_user)
);