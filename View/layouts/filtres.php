<aside class="flex column start">
    <div class="input-container flex column start">
        <h4>Date de publication :</h4>
        <div class="input-container dates flex column start">
            <div class="flex center">
                <label for="startDate" style="height: fit-content;">Du</label>
                <input type="date" id="startDate" placeholder="10/10/2024">
            </div>
            <div class="flex center">
                <label for="endDate" class="flex center">Au</label>
                <input type="date" id="endDate" placeholder="12/10/2024">
            </div>
        </div>
    </div>
    <div class="input-container flex column start">
        <h4>Catégories :</h4>
        <select id="category">
            <option value="tout">Aucune catégories</option>
            <?php foreach (Constants::TYPE_PHOTOS as $typePhoto) : ?>
                <option value="<?= $typePhoto ?>"><?= $typePhoto ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="input-container flex column start">
        <h4>Titre : </h4>
        <input type="text" placeholder="Mer" id="title">
    </div>
    <button type="button" onclick="filterPhotos()">Filtrer</button>
</aside>