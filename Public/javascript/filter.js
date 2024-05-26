/**
 * Permet de vérifier si une date est comprise entre deux dates
 *
 * @param {Date} date La date à vérifier
 * @param {[Date, Date]} dateRange Les dates de début et fin
 * @return {boolean} Si la date est comprise entre les deux ou non
 */
const dateOverlap = (date, dateRange) => {
    const dateToCheck = date.getTime();
    const start = dateRange[0].getTime();
    const end = dateRange[1].getTime();

    return dateToCheck >= start && dateToCheck <= end;
}

/**
 * Permet de filtrer les photos
 *
 * @return {boolean} False
 */
const filterPhotos = () => {

    const photos = JSON.parse(sessionStorage.getItem('photos'));

    const startDate = document.querySelector('#startDate').value;
    const endDate = document.querySelector('#endDate').value;
    const category = document.querySelector('#category').value;
    const title = document.querySelector('#title').value;

    photos.forEach(photo => {
        //default condition
        let condition = photo.titre.includes(title) && photo.tag === category;

        //condition if the user chose start and end dates
        if (!isNaN(new Date(startDate).getTime()) && !isNaN(new Date(endDate).getTime())) {
            condition = photo.titre.includes(title) && photo.tag === category && dateOverlap(new Date(photo.datePublication), [new Date(startDate), new Date(endDate)])
        }

        if (condition) {
            document.querySelector('#photo-' + photo.id).style.display = 'flex';
        } else {
            document.querySelector('#photo-' + photo.id).style.display = 'none';
        }
    });

    return false;
}