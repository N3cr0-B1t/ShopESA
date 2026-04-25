<?php
// ============================================
// index.php — Point d'entrée principal
// Routeur simple de ShopESA
// ============================================

session_start();
require_once 'config/db.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

$pages_autorisees = [
    'accueil',
    'produits',
    'produit_detail',
    'connexion',
    'inscription',
    'deconnexion',
    'panier',
    'commande',
    'historique',
    'profil'
];

if (!in_array($page, $pages_autorisees)) {
    $page = 'accueil';
}

// Charge le header
require_once 'views/partials/header.php';

// Charge la vue correspondante à la page
$vue = 'views/' . $page . '.php';

if (file_exists($vue)) {
    require_once $vue;
} else {
    require_once 'views/404.php';
}

// Charge le footer
require_once 'views/partials/footer.php';