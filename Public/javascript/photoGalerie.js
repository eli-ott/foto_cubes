/**
 * Permet de supprimer une photo
 */
const deletePhoto = () => {
	if (confirm('Etes vous sur de vouloir supprimer votre photo ?')) {
		document.getElementById('delete-form').submit();
	}
};
