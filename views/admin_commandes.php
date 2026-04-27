<?php $titre_page = 'Dashboard Commandes'; ?>

<div class="admin-container">

    <div class="admin-header">
        <h1>📦 Gestion des Commandes</h1>
        <div style="display:flex; gap:10px;">
            <a href="/ShopESA/controllers/products.php" class="btn btn-success">
                🛍️ Gérer les produits
            </a>
            <a href="/ShopESA/?page=accueil" class="btn btn-primary">
                ← Accueil
            </a>
        </div>
    </div>

    <!-- Message succès -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Statut mis à jour avec succès ✅</div>
    <?php endif; ?>

    <?php if (empty($commandes)): ?>
        <div class="alert alert-info">Aucune commande pour l'instant.</div>
    <?php else: ?>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Email</th>
                    <th>Total TTC</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Changer statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commandes as $commande): ?>
                <tr>
                    <td>#<?= $commande['id'] ?></td>
                    <td><?= htmlspecialchars($commande['client_nom']) ?></td>
                    <td><?= htmlspecialchars($commande['client_email']) ?></td>
                    <td><?= number_format($commande['total'], 0, ',', ' ') ?> FCFA</td>
                    <td><?= date('d/m/Y H:i', strtotime($commande['created_at'])) ?></td>

                    <!-- Statut actuel -->
                    <td>
                        <?php
                        $statuts = [
                            'en_attente' => ['label' => '⏳ En attente', 'class' => 'statut-attente'],
                            'expediee'   => ['label' => '🚚 Expédiée',   'class' => 'statut-expediee'],
                            'livree'     => ['label' => '✅ Livrée',      'class' => 'statut-livree']
                        ];
                        $s = $statuts[$commande['statut']] ?? ['label' => $commande['statut'], 'class' => ''];
                        ?>
                        <span class="badge-statut <?= $s['class'] ?>">
                            <?= $s['label'] ?>
                        </span>
                    </td>

                    <!-- Formulaire changement statut -->
                    <td>
                        <form method="POST" action="/ShopESA/?page=admin_commandes">
                            <input type="hidden" name="order_id" value="<?= $commande['id'] ?>">
                            <select name="statut" style="padding:5px; border-radius:5px; border:1px solid #ddd;">
                                <option value="en_attente" <?= $commande['statut'] === 'en_attente' ? 'selected' : '' ?>>⏳ En attente</option>
                                <option value="expediee"   <?= $commande['statut'] === 'expediee'   ? 'selected' : '' ?>>🚚 Expédiée</option>
                                <option value="livree"     <?= $commande['statut'] === 'livree'     ? 'selected' : '' ?>>✅ Livrée</option>
                            </select>
                            <button type="submit" class="btn btn-warning" style="padding:5px 10px; margin-left:5px;">
                                ✏️
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

</div>