/**
 * Permet de supprimer une photo
 *
 * @param {number} idPhoto L'id de la photo
 */
const deletePhoto = idPhoto => {
	if (confirm('Etes vous sur de vouloir supprimer votre photo ?')) {
		document.getElementById('delete-form-' + idPhoto).submit();
	}
};

/**
 * Permet d'afficher/cacher le formulaire pour modifier sa photo
 *
 * @param {boolean} visible If the form is visible or not
 * @param {string} idForm If the form is visible or not
 */
const toggleModifyForm = (visible, idForm) => {
	console.log(idForm);
	const formDisplay = visible ? 'flex' : 'none';
	document.querySelector('#modify-form-' + idForm).style.display = formDisplay;
};

/**
 * Permet d'afficher la modale avec les bonnes valeurs
 *
 * @param {string} photo La photo à afficher
 * @param {string} titre Le titre de la photo
 * @param {string} pseudo Le pseudo du photographe
 * @param {string} tag Le tag de la photo
 * @param {string} email L'email du photographe
 */
const showModal = (photo, titre, pseudo, tag, email) => {
	document.querySelector('.popup').style.display = 'flex';

	console.log(tag, document.querySelector('.pseudo-warn'));

	document.querySelector('.popup .image').src = photo;
	document.querySelector('.titre').innerHTML = titre;
	document.querySelector('.pseudo').innerHTML = pseudo;
	document.querySelector('.pseudo-warn') ? document.querySelector('.pseudo-warn').value = pseudo: '';
	document.querySelector('.tag').innerHTML = tag;
	document.querySelector('.mail-receveur').value = email;
};

/**
 * Permet d'enlever la modale
 */
const hideModal = () => {
	document.querySelector('.popup').style.display = 'none';
};
