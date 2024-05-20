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
