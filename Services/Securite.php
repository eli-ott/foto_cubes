<?php

/**
 * Les fonctions liées à la sécurité
 */
class Securite
{
    /**
     * Permet de sécuriser une chaîne de caractère
     * 
     * @param string $text Le texte à sécuriser
     */
    public static function secureHTML(string $text): string
    {
        return htmlentities($text);
    }
}
