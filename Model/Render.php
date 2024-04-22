<?php

class Render
{
    /**
     * Constructeur
     */
    public function __construct()
    {
    }

    /**
     * Affiche une page spécifique en fonction d'une template et d'une vue spéciale
     * 
     * @param array $data Les données nécessaire pour afficher la page
     */
    protected function render(array $data): void
    {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        require_once($view);
        $page_content = ob_get_clean();
        require_once($template);
    }
}
