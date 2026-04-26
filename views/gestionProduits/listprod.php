<?php require '../views/partials/header.php'; ?>

<div class="admin-container">
    <div class="admin-header">
        <h1>Gestion des Produits</h1>
        <a href="products.php?action=create" class="btn-add">+ Ajouter un produit</a>
    </div>

    <!-- Message de succès -->
    <?php if (isset($_GET['success'])): ?>
        <p class="alert-success">Action effectuée avec succès ✅</p>
    <?php endif; ?>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td>
                    <img src="../uploads/<?= $product['image'] ?>"
                         alt="<?= $product['nom'] ?>"
                         width="60">
                </td>
                <td><?= $product['nom'] ?></td>
                <td><?= $product['categorie_nom'] ?></td>
                <td><?= number_format($product['prix'], 0, ',', ' ') ?> FCFA</td>
                <td><?= $product['stock'] ?></td>
                <td>
                    <a href="products.php?action=edit&id=<?= $product['id'] ?>"
                       class="btn-edit">✏️ Modifier</a>
                    <a href="products.php?action=delete&id=<?= $product['id'] ?>"
                       class="btn-delete"
                       onclick="return confirm('Supprimer ce produit ?')">🗑️ Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require '../views/partials/footer.php'; ?>