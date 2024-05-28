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
const toggleModifyForm = visible => {
	const formDisplay = visible ? 'flex' : 'none';
	document.getElementById('modify-form').style.display = formDisplay;
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

	document.querySelector('.popup .image').src = photo;
	document.querySelector('.titre').innerHTML = titre;
	document.querySelector('.pseudo').innerHTML = pseudo;
	document.querySelector('.pseudo-warn').value = pseudo;
	document.querySelector('.tag').innerHTML = tag;
	document.querySelector('.mail-receveur').value = email;
};

/**
 * Permet d'enlever la modale
 */
const hideModal = () => {
	document.querySelector('.popup').style.display = 'none';
};
