/**
 * Permet d'afficher le nom du fichier ajouté
 */
const showFile = () => {
    const file = document.querySelector('[type="file"]').value;

    const imagePlaceholder = document.querySelector('.drop-area img');
    if (imagePlaceholder) {
        imagePlaceholder.remove();
    }

    const oldFileName = document.querySelector('.drop-area p');
    if (oldFileName) {
        oldFileName.remove()
    }

    let p = document.createElement('p');
    p.innerText = file.split('\\').at(-1);

    document.querySelector('.drop-area').appendChild(p);
}