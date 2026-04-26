<?php $titre_page = 'Mon Panier'; ?>

<div class="container">

    <h2 style="margin-bottom:20px;">🛒 Mon Panier</h2>

    <?php if (empty($articles)): ?>
        <!-- Panier vide -->
        <div class="alert alert-info">
            Votre panier est vide.
            <a href="/ShopESA/?page=produits">Voir les produits</a>
        </div>

    <?php else: ?>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                <tr>
                    <!-- Image -->
                    <td>
                        <?php if ($article['image']): ?>
                            <img src="/ShopESA/uploads/<?= $article['image'] ?>"
                                 width="60" style="border-radius:5px">
                        <?php else: ?>
                            📦
                        <?php endif; ?>
                    </td>

                    <!-- Nom produit -->
                    <td><?= htmlspecialchars($article['nom']) ?></td>

                    <!-- Prix unitaire -->
                    <td><?= number_format($article['prix'], 0, ',', ' ') ?> FCFA</td>

                    <!-- Modifier quantité -->
                    <td>
                        <form action="/ShopESA/?page=modifier_panier" method="POST">
                            <input type="hidden" name="cart_id" value="<?= $article['id'] ?>">
                            <input type="number" name="quantite"
                                   value="<?= $article['quantite'] ?>"
                                   min="0" style="width:60px; padding:5px; border:1px solid #ddd; border-radius:5px">
                            <button type="submit" class="btn btn-warning" style="padding:5px 10px">
                                ✏️
                            </button>
                        </form>
                    </td>

                    <!-- Sous-total -->
                    <td><?= number_format($article['sous_total'], 0, ',', ' ') ?> FCFA</td>

                    <!-- Supprimer -->
                    <td>
                        <form action="/ShopESA/?page=supprimer_panier" method="POST">
                            <input type="hidden" name="cart_id" value="<?= $article['id'] ?>">
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Retirer cet article ?')"
                                    style="padding:5px 10px">
                                🗑️
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Total -->
        <div style="text-align:right; margin-top:20px; font-size:1.2rem; font-weight:bold;">
            Total : <?= number_format($total, 0, ',', ' ') ?> FCFA
        </div>

        <!-- Bouton commander -->
        <div style="text-align:right; margin-top:15px;">
            <a href="/ShopESA/?page=commande" class="btn btn-success">
                ✅ Passer la commande
            </a>
        </div>

    <?php endif; ?>

</div>