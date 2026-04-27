<?php
// ============================================
// Affichage du panier d'achat
// ============================================
$titre_page = 'Mon Panier';
?>

<div class="container">

    <h2 style="margin-bottom:20px;">🛒 Mon Panier</h2>

    <!-- Messages -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-success">✅ <?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!empty($erreur)): ?>
        <div class="alert alert-danger">❌ <?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <?php if (empty($items)): ?>

        <!-- Panier vide -->
        <div class="panier-vide">
            <div style="font-size:4rem;">🛒</div>
            <h3>Ton panier est vide</h3>
            <p>Découvre nos produits et commence tes achats !</p>
            <a href="/ShopESA/?page=produits" class="btn btn-primary">
                Voir les produits
            </a>
        </div>

    <?php else: ?>

        <div class="panier-wrapper">

            <!-- Liste des articles -->
            <div class="panier-items">
                <?php foreach ($items as $item): ?>
                    <div class="panier-item">

                        <!-- Image -->
                        <div class="panier-item-image">
                            <?php if ($item['image']): ?>
                                <img src="/ShopESA/uploads/<?= htmlspecialchars($item['image']) ?>"
                                     alt="<?= htmlspecialchars($item['nom']) ?>">
                            <?php else: ?>
                                <div class="no-image">📦</div>
                            <?php endif; ?>
                        </div>

                        <!-- Infos -->
                        <div class="panier-item-info">
                            <h4><?= htmlspecialchars($item['nom']) ?></h4>
                            <p class="panier-item-prix">
                                <?= number_format($item['prix'], 0, ',', ' ') ?> FCFA / unité
                            </p>
                        </div>

                        <!-- Quantité -->
                        <div class="panier-item-quantite">
                            <form method="POST" action="/ShopESA/?page=panier">
                                <input type="hidden" name="action" value="modifier">
                                <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <input
                                        type="number"
                                        name="quantite"
                                        value="<?= $item['quantite'] ?>"
                                        min="0"
                                        max="<?= $item['stock'] ?>"
                                        style="width:65px; padding:6px; border:1px solid #ddd;
                                               border-radius:5px; text-align:center;"
                                        onchange="this.form.submit()"
                                    >
                                </div>
                            </form>
                        </div>

                        <!-- Sous-total -->
                        <div class="panier-item-subtotal">
                            <?= number_format($item['sous_total'], 0, ',', ' ') ?> FCFA
                        </div>

                        <!-- Supprimer -->
                        <div class="panier-item-delete">
                            <a href="/ShopESA/?page=panier&action=supprimer&cart_id=<?= $item['id'] ?>"
                               onclick="return confirm('Supprimer cet article ?')"
                               class="btn btn-danger"
                               style="padding:6px 12px;">
                                🗑️
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>

                <!-- Bouton vider panier -->
                <div style="margin-top:15px; text-align:right;">
                    <a href="/ShopESA/?page=panier&action=vider"
                       onclick="return confirm('Vider tout le panier ?')"
                       class="btn btn-danger">
                        🗑️ Vider le panier
                    </a>
                </div>
            </div>

            <!-- Récapitulatif -->
            <div class="panier-recap">
                <h3>Récapitulatif</h3>

                <div class="recap-ligne">
                    <span>Sous-total HT</span>
                    <span><?= number_format($total_ht, 0, ',', ' ') ?> FCFA</span>
                </div>
                <div class="recap-ligne">
                    <span>TVA (18%)</span>
                    <span><?= number_format($tva, 0, ',', ' ') ?> FCFA</span>
                </div>
                <div class="recap-ligne recap-total">
                    <span>Total TTC</span>
                    <span><?= number_format($total_ttc, 0, ',', ' ') ?> FCFA</span>
                </div>

                <a href="/ShopESA/?page=commande"
                   class="btn btn-success"
                   style="width:100%; margin-top:20px; text-align:center;">
                    ✅ Passer la commande
                </a>

                <a href="/ShopESA/?page=produits"
                   class="btn btn-warning"
                   style="width:100%; margin-top:10px; text-align:center;">
                    ← Continuer les achats
                </a>
            </div>

        </div>

    <?php endif; ?>

</div>
