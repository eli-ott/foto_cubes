/**
 * Permet de valider la suppression du compte
 */
const validateDeletion = () => {
	if (confirm('Êtes vous sur de vouloir supprimer votre compte ?')) {
		fetch('form/delete-account', {
			method: 'POST'
		});
	}
};
