<?php
// ============================================
// Fiche détail d'un produit
// ============================================
$titre_page = htmlspecialchars($produit['nom']);
?>

<div class="container">


    <nav class="breadcrumb">
        <a href="/ShopESA/?page=accueil">Accueil</a> &rsaquo;
        <a href="/ShopESA/?page=produits">Produits</a> &rsaquo;
        <span><?= htmlspecialchars($produit['nom']) ?></span>
    </nav>

    <div class="detail-wrapper">

        <!-- Image -->
        <div class="detail-image">
            <?php if ($produit['image']): ?>
                <img src="/ShopESA/uploads/<?= htmlspecialchars($produit['image']) ?>"
                     alt="<?= htmlspecialchars($produit['nom']) ?>">
            <?php else: ?>
                <div class="no-image-large">📦</div>
            <?php endif; ?>
        </div>

        <!-- Informations -->
        <div class="detail-info">

            <span class="produit-categorie">
                <?= htmlspecialchars($produit['categorie_nom'] ?? 'Sans catégorie') ?>
            </span>

            <h1><?= htmlspecialchars($produit['nom']) ?></h1>

            <p class="detail-prix">
                <?= number_format($produit['prix'], 0, ',', ' ') ?> FCFA
            </p>

            <p class="detail-description">
                <?= htmlspecialchars($produit['description']) ?>
            </p>

            <!-- Stock -->
            <?php if ($produit['stock'] > 0): ?>
                <p class="badge-stock">✅ En stock (<?= $produit['stock'] ?> disponibles)</p>
            <?php else: ?>
                <p class="badge-rupture">❌ Rupture de stock</p>
            <?php endif; ?>

            <!-- Bouton ajout panier -->
            <?php if ($produit['stock'] > 0): ?>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form method="POST" action="/ShopESA/?page=panier">
                        <input type="hidden" name="action" value="ajouter">
                        <input type="hidden" name="product_id" value="<?= $produit['id'] ?>">
                        <div class="quantite-group">
                            <label for="quantite">Quantité :</label>
                            <input type="number" id="quantite" name="quantite"
                                   value="1" min="1" max="<?= $produit['stock'] ?>">
                        </div>
                        <button type="submit" class="btn btn-success" style="width:100%">
                            🛒 Ajouter au panier
                        </button>
                    </form>
                <?php else: ?>
                    <a href="/ShopESA/?page=connexion" class="btn btn-primary" style="width:100%">
                        🔒 Connecte-toi pour acheter
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <a href="/ShopESA/?page=produits" class="btn btn-warning" style="width:100%; margin-top:10px;">
                ← Retour aux produits
            </a>

        </div>
    </div>
</div>
