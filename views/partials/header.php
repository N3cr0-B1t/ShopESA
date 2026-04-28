<?php



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopESA <?= isset($titre_page) ? '— ' . $titre_page : '' ?></title>
    <link rel="stylesheet" href="/ShopESA/public/css/style.css">
</head>
<body>

<header class="header">
    <div class="container">

        <!-- Logo -->
        <a href="/ShopESA/?page=accueil" class="logo">
            🛒 ShopESA
        </a>

        <!-- Navigation -->
        <nav class="nav">
            <a href="/ShopESA/?page=accueil">Accueil</a>
            <a href="/ShopESA/?page=produits">Produits</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Menu utilisateur connecté -->
                <a href="/ShopESA/?page=panier">
                    🛒 Panier
                    <?php if (isset($_SESSION['panier_count']) && $_SESSION['panier_count'] > 0): ?>
                        <span class="badge"><?= $_SESSION['panier_count'] ?></span>
                    <?php endif; ?>
                </a>
                <a href="/ShopESA/?page=historique">Mes commandes</a>

                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin'): ?>
                            <a href="/ShopESA/?page=admin_dashboard" class="btn-admin">Admin</a>
                <?php endif; ?>
                
                <a href="/ShopESA/?page=deconnexion" class="btn-connexion">
                    Déconnexion (<?= htmlspecialchars($_SESSION['user_nom']) ?>)
                </a>

            <?php else: ?>
                <!-- Menu visiteur -->
                <a href="/ShopESA/?page=connexion" class="btn-connexion">Connexion</a>
                <a href="/ShopESA/?page=inscription" class="btn-inscription">Inscription</a>
            <?php endif; ?>
        </nav>

    </div>
</header>

<main class="main-content">
