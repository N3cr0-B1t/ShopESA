<?php require '../views/partials/header.php'; ?>

<div class="admin-container">
    <h1>Ajouter un produit</h1>

    <form action="products.php?action=store" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nom du produit</label>
            <input type="text" name="nom" required placeholder="Ex: Chemise bleue">
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4" placeholder="Décrivez le produit..."></textarea>
        </div>

        <div class="form-group">
            <label>Prix (FCFA)</label>
            <input type="number" name="prix" step="0.01" required placeholder="Ex: 5000">
        </div>

        <div class="form-group">
            <label>Stock</label>
            <input type="number" name="stock" required placeholder="Ex: 10">
        </div>

        <div class="form-group">
            <label>Catégorie</label>
            <select name="cat_id" required>
                <option value="">-- Choisir une catégorie --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= $cat['nom'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Image du produit</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn-submit">Ajouter le produit</button>
        <a href="products.php" class="btn-cancel">Annuler</a>
    </form>
</div>

<?php require '../views/partials/footer.php'; ?>