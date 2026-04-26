<?php require '../views/partials/header.php'; ?>

<div class="admin-container">
    <h1>Modifier le produit</h1>

    <form action="products.php?action=update&id=<?= $product['id'] ?>"
          method="POST"
          enctype="multipart/form-data">

        <div class="form-group">
            <label>Nom du produit</label>
            <input type="text" name="nom" required value="<?= $product['nom'] ?>">
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4"><?= $product['description'] ?></textarea>
        </div>

        <div class="form-group">
            <label>Prix (FCFA)</label>
            <input type="number" name="prix" step="0.01"
                   required value="<?= $product['prix'] ?>">
        </div>

        <div class="form-group">
            <label>Stock</label>
            <input type="number" name="stock" required value="<?= $product['stock'] ?>">
        </div>

        <div class="form-group">
            <label>Catégorie</label>
            <select name="cat_id" required>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"
                        <?= $cat['id'] == $product['cat_id'] ? 'selected' : '' ?>>
                        <?= $cat['nom'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Image actuelle</label><br>
            <img src="../uploads/<?= $product['image'] ?>"
                 width="100" style="margin-bottom:10px"><br>
            <label>Changer l'image (optionnel)</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn-submit">Enregistrer les modifications</button>
        <a href="products.php" class="btn-cancel">Annuler</a>
    </form>
</div>

<?php require '../views/partials/footer.php'; ?>