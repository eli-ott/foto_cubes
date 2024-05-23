/**
 * Permet d'enlever les alerts
 *
 * @param {string} URL L'url récupérer depuis les constantes php
 */
const removeAlert = URL => {
    document.querySelector('.snack-alert').style.display = 'none';

    fetch(URL + 'form/remove-alert');
}