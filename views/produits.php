<?php
// ============================================
// Liste des produits avec filtre catégorie
// ============================================
$titre_page = 'Produits';
?>

<div class="container">

    <h2 style="margin-bottom:20px;">Nos Produits</h2>

    <!-- Filtres par catégorie -->
    <div class="filtres">
        <a href="/ShopESA/?page=produits"
           class="btn-filtre <?= !$categorie_active ? 'actif' : '' ?>">
            Tous
        </a>
        <?php foreach ($categories as $cat): ?>
            <a href="/ShopESA/?page=produits&cat=<?= $cat['id'] ?>"
               class="btn-filtre <?= $categorie_active == $cat['id'] ? 'actif' : '' ?>">
                <?= htmlspecialchars($cat['nom']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Grille de produits -->
    <?php if (empty($produits)): ?>
        <div class="alert alert-info">
            Aucun produit dans cette catégorie.
        </div>
    <?php else: ?>
        <div class="produits-grid">
            <?php foreach ($produits as $produit): ?>
                <div class="produit-card">

                    <!-- Image produit -->
                    <div class="produit-image">
                        <?php if ($produit['image']): ?>
                            <img src="/ShopESA/uploads/<?= htmlspecialchars($produit['image']) ?>"
                                 alt="<?= htmlspecialchars($produit['nom']) ?>">
                        <?php else: ?>
                            <div class="no-image">📦</div>
                        <?php endif; ?>
                    </div>

                    <!-- Infos produit -->
                    <div class="produit-info">
                        <span class="produit-categorie">
                            <?= htmlspecialchars($produit['categorie_nom'] ?? 'Sans catégorie') ?>
                        </span>
                        <h3 class="produit-nom">
                            <?= htmlspecialchars($produit['nom']) ?>
                        </h3>
                        <p class="produit-prix">
                            <?= number_format($produit['prix'], 0, ',', ' ') ?> FCFA
                        </p>

                        <!-- Stock -->
                        <?php if ($produit['stock'] > 0): ?>
                            <span class="badge-stock">✅ En stock</span>
                        <?php else: ?>
                            <span class="badge-rupture">❌ Rupture</span>
                        <?php endif; ?>
                    </div>

                    <!-- Actions -->
                    <div class="produit-actions">
                        <a href="/ShopESA/?page=produit_detail&id=<?= $produit['id'] ?>"
                           class="btn btn-primary" style="width:100%">
                            Voir le produit
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
