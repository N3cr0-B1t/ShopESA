<?php
// ============================================
// views/commande.php
// Formulaire de validation de commande
// ============================================
$titre_page = 'Passer la commande';
?>

<div class="container">

    <h2 style="margin-bottom:20px;">✅ Passer la commande</h2>

    <?php if (!empty($erreurs)): ?>
        <div class="alert alert-danger">
            <?php foreach ($erreurs as $e): ?>
                <p>❌ <?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="commande-wrapper">

        <!-- Formulaire livraison -->
        <div class="commande-form">
            <h3>📦 Informations de livraison</h3>

            <form method="POST" action="/ShopESA/?page=commande">

                <div class="form-group">
                    <label>Nom complet *</label>
                    <input type="text" name="nom"
                           value="<?= htmlspecialchars($_POST['nom'] ?? $_SESSION['user_nom']) ?>"
                           required>
                </div>

                <div class="form-group">
                    <label>Téléphone *</label>
                    <input type="tel" name="telephone"
                           value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>"
                           placeholder="Ex: +228 90 00 00 00"
                           required>
                </div>

                <div class="form-group">
                    <label>Adresse de livraison *</label>
                    <textarea name="adresse" rows="3"
                              placeholder="Quartier, rue, numéro..."
                              required><?= htmlspecialchars($_POST['adresse'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label>Ville *</label>
                    <input type="text" name="ville"
                           value="<?= htmlspecialchars($_POST['ville'] ?? '') ?>"
                           placeholder="Ex: Lomé"
                           required>
                </div>

                <button type="submit" class="btn btn-success" style="width:100%">
                    ✅ Confirmer la commande
                </button>

            </form>
        </div>

        <!-- Récapitulatif commande -->
        <div class="commande-recap">
            <h3>🧾 Récapitulatif</h3>

            <?php foreach ($items as $item): ?>
                <div class="recap-item">
                    <span>
                        <?= htmlspecialchars($item['nom']) ?>
                        <small>x<?= $item['quantite'] ?></small>
                    </span>
                    <span><?= number_format($item['sous_total'], 0, ',', ' ') ?> FCFA</span>
                </div>
            <?php endforeach; ?>

            <div class="recap-separateur"></div>

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

            <a href="/ShopESA/?page=panier"
               class="btn btn-warning"
               style="width:100%; margin-top:15px; text-align:center;">
                ← Modifier le panier
            </a>
        </div>

    </div>
</div>
