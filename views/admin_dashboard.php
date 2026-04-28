<?php
// ============================================
// views/admin_dashboard.php
// Dashboard administrateur avec statistiques
// ============================================
$titre_page = 'Dashboard Admin';

$pdo          = getDB();
$nb_produits  = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$nb_users     = $pdo->query("SELECT COUNT(*) FROM users WHERE role='client'")->fetchColumn();
$nb_commandes = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$ca_total     = $pdo->query("SELECT SUM(total) FROM orders")->fetchColumn();
$nb_attente   = $pdo->query("SELECT COUNT(*) FROM orders WHERE statut='en_attente'")->fetchColumn();
?>

<?php
$titre_page = 'Dashboard Admin';
$pdo          = getDB();
$nb_produits  = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$nb_users     = $pdo->query("SELECT COUNT(*) FROM users WHERE role='client'")->fetchColumn();
$nb_commandes = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$ca_total     = $pdo->query("SELECT SUM(total) FROM orders")->fetchColumn();
$nb_attente   = $pdo->query("SELECT COUNT(*) FROM orders WHERE statut='en_attente'")->fetchColumn();
?>

<div class="container">
    <h2 style="margin-bottom:25px;">📊 Dashboard Administrateur</h2>

    <div class="dashboard-grid">
        <div class="dashboard-card card-blue">
            <div class="dashboard-icon">📦</div>
            <div class="dashboard-number"><?= $nb_produits ?></div>
            <div class="dashboard-label">Produits</div>
            <a href="/ShopESA/controllers/products.php" class="dashboard-link" style="color:white;">
                Gérer →
            </a>
        </div>
        <div class="dashboard-card card-green">
            <div class="dashboard-icon">👥</div>
            <div class="dashboard-number"><?= $nb_users ?></div>
            <div class="dashboard-label">Clients</div>
        </div>
        <div class="dashboard-card card-orange">
            <div class="dashboard-icon">🧾</div>
            <div class="dashboard-number"><?= $nb_commandes ?></div>
            <div class="dashboard-label">Commandes</div>
            <a href="/ShopESA/?page=admin_commandes" class="dashboard-link" style="color:white;">
                Voir →
            </a>
        </div>
        <div class="dashboard-card card-red">
            <div class="dashboard-icon">⏳</div>
            <div class="dashboard-number"><?= $nb_attente ?></div>
            <div class="dashboard-label">En attente</div>
        </div>
    </div>

    <div class="ca-card">
        <div class="ca-icon"></div>
        <div>
            <div class="ca-label">Chiffre d'affaires total</div>
            <div class="ca-number">
                <?= number_format($ca_total ?? 0, 0, ',', ' ') ?> FCFA
            </div>
        </div>
    </div>

    <div class="actions-rapides">
        <h3>⚡ Actions rapides</h3>
        <div class="actions-grid">
            <a href="/ShopESA/controllers/products.php?action=create" class="btn btn-success">
                Ajouter un produit
            </a>
            <a href="/ShopESA/?page=admin_commandes" class="btn btn-primary">
                Gérer les commandes
            </a>
            <a href="/ShopESA/?page=accueil" class="btn btn-warning">
                Voir le site
            </a>
        </div>
    </div>
</div>