/**
 * Permet de supprimer une photo
 */
const deletePhoto = () => {
	if (confirm('Etes vous sur de vouloir supprimer votre photo ?')) {
		document.getElementById('delete-form').submit();
	}
};

/**
 * Permet d'afficher/cacher le formulaire pour modifier sa photo
 *
 * @param {boolean} visible If the form is visible or not
 */
const toggleModifyForm = (visible) => {
	const formDisplay = visible ? 'flex' : 'none';
	document.getElementById('modify-form').style.display = formDisplay;
};
