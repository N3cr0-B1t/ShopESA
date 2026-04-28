<?php
// ============================================
// views/accueil.php
// Page d'accueil de ShopESA
// ============================================
$titre_page = 'Accueil';

require_once 'models/Product.php';
$produits_vedette = getAllProducts();
$produits_vedette = array_slice($produits_vedette, 0, 4);
?>

<!-- Hero Section -->
<div class="hero">
    <div class="container">
        <h1>🛒 Bienvenue sur ShopESA</h1>
        <p>Votre boutique en ligne </p>
        <a href="/ShopESA/?page=produits" class="btn btn-primary" style="font-size:1.1rem; padding:12px 30px;">
            Découvrir nos produits →
        </a>
    </div>
</div>

<!-- Produits en vedette -->
<div class="container" style="margin-top:40px;">
    <h2 style="margin-bottom:20px;">🌟 Produits en vedette</h2>

    <div class="produits-grid">
        <?php foreach ($produits_vedette as $produit): ?>
            <div class="produit-card">
                <div class="produit-image">
                    <?php if ($produit['image']): ?>
                        <img src="/ShopESA/uploads/<?= htmlspecialchars($produit['image']) ?>"
                             alt="<?= htmlspecialchars($produit['nom']) ?>">
                    <?php else: ?>
                        <div class="no-image">📦</div>
                    <?php endif; ?>
                </div>
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
                    <?php if ($produit['stock'] > 0): ?>
                        <span class="badge-stock">✅ En stock</span>
                    <?php else: ?>
                        <span class="badge-rupture">❌ Rupture</span>
                    <?php endif; ?>
                </div>
                <div class="produit-actions">
                    <a href="/ShopESA/?page=produit_detail&id=<?= $produit['id'] ?>"
                       class="btn btn-primary" style="width:100%">
                        Voir le produit
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="text-align:center; margin-top:30px;">
        <a href="/ShopESA/?page=produits" class="btn btn-warning">
            Voir tous les produits →
        </a>
    </div>
</div>

<!-- Avantages -->
<div class="avantages">
    <div class="container">
        <div class="avantages-grid">
            <div class="avantage-card">
                <div class="avantage-icon">🚚</div>
                <h3>Livraison rapide</h3>
                <p>Livraison dans tout le Togo</p>
            </div>
            <div class="avantage-card">
                <div class="avantage-icon">🔒</div>
                <h3>Paiement sécurisé</h3>
                <p>Vos données sont protégées</p>
            </div>
            <div class="avantage-card">
                <div class="avantage-icon">⭐</div>
                <h3>Qualité garantie</h3>
                <p>Produits sélectionnés avec soin</p>
            </div>
            <div class="avantage-card">
                <div class="avantage-icon">📞</div>
                <h3>Support client</h3>
                <p>Disponible 7j/7</p>
            </div>
        </div>
    </div>
</div>
