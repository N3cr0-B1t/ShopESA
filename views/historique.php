<?php
// ============================================
// Historique des commandes client
// ============================================
$titre_page = 'Mes commandes';
?>

<div class="container">

    <h2 style="margin-bottom:20px;">🧾 Mes commandes</h2>

    <!-- Message succès après commande -->
    <?php if ($succes && $commande_id): ?>
        <div class="alert alert-success">
            ✅ <strong>Commande #<?= $commande_id ?> confirmée !</strong>
            Merci pour votre achat. Nous traitons votre commande.
        </div>
    <?php endif; ?>

    <?php if (empty($commandes)): ?>

        <!-- Aucune commande -->
        <div class="panier-vide">
            <div style="font-size:4rem;">🧾</div>
            <h3>Aucune commande pour l'instant</h3>
            <p>Découvre nos produits et passe ta première commande !</p>
            <a href="/ShopESA/?page=produits" class="btn btn-primary">
                Voir les produits
            </a>
        </div>

    <?php else: ?>

        <!-- Détail commande récente -->
        <?php if ($detail_commande): ?>
            <div class="commande-detail">
                <h3>
                    📦 Détail commande #<?= $commande_id ?>
                    <a href="/ShopESA/?page=historique"
                       style="font-size:0.8rem; margin-left:10px;">
                        ← Retour
                    </a>
                </h3>
                <div class="table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                                <th>Sous-total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detail_commande as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['produit_nom']) ?></td>
                                    <td><?= $item['quantite'] ?></td>
                                    <td><?= number_format($item['prix_unit'], 0, ',', ' ') ?> FCFA</td>
                                    <td><?= number_format($item['quantite'] * $item['prix_unit'], 0, ',', ' ') ?> FCFA</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Adresse livraison -->
                <div class="commande-adresse">
                    <h4>📍 Adresse de livraison</h4>
                    <p><?= nl2br(htmlspecialchars($detail_commande[0]['adresse'])) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Liste des commandes -->
        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Total TTC</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($commandes as $commande): ?>
                        <tr>
                            <td>#<?= $commande['id'] ?></td>
                            <td>
                                <?= date('d/m/Y H:i', strtotime($commande['created_at'])) ?>
                            </td>
                            <td>
                                <?= number_format($commande['total'], 0, ',', ' ') ?> FCFA
                            </td>
                            <td>
                                <?php
                                $statuts = [
                                    'en_attente' => ['label' => '⏳ En attente', 'class' => 'statut-attente'],
                                    'expediee'   => ['label' => '🚚 Expédiée',   'class' => 'statut-expediee'],
                                    'livree'     => ['label' => '✅ Livrée',      'class' => 'statut-livree']
                                ];
                                $statut = $statuts[$commande['statut']] ?? ['label' => $commande['statut'], 'class' => ''];
                                ?>
                                <span class="badge-statut <?= $statut['class'] ?>">
                                    <?= $statut['label'] ?>
                                </span>
                            </td>
                            <td>
                                <a href="/ShopESA/?page=historique&commande_id=<?= $commande['id'] ?>"
                                   class="btn btn-primary"
                                   style="padding:5px 10px; font-size:0.85rem;">
                                    👁️ Détail

                                </a>

                                <a href="/ShopESA/?page=facture_pdf&id=<?= $commande['id'] ?>"
                                   class="btn btn-success"
                                   style="padding:5px 10px; font-size:0.85rem;">
                                   📄 PDF
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>

</div>
