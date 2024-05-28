/**
 * Permet de valider la suppression du compte
 *
 * @param {string} URL La constante URL récupéré depuis le php
 */
const validateDeletion = async URL => {
	if (confirm('Êtes vous sur de vouloir supprimer votre compte ?')) {
		const res = await fetch(URL + 'form/delete-account', {
			method: 'POST'
		});
		const ret = await res.text();

		if (ret) {
			window.location = URL;
		}
	}
};

/**
 * Permet d'afficher/cacher le formulaire pour modifier saes infos
 *
 * @param {boolean} visible If the form is visible or not
 */
const toggleUpdateInfo = (visible, element) => {
	const formDisplay = visible ? 'flex' : 'none';
	document.getElementById('update-' + element).style.display = formDisplay;
	const valeurDisplay = !visible ? 'flex' : 'none';
	document.getElementById('valeur-' + element).style.display = valeurDisplay;
};
