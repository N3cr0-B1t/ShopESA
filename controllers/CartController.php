<?php

require_once 'models/cart.php';

// Afficher le panier
function afficherPanier() {
    // Vérifier que l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        header('Location: /ShopESA/?page=connexion');
        exit;
    }

    $articles = getCartByUser($_SESSION['user_id']);

    // Calculer le total
    $total = 0;
    foreach ($articles as $article) {
        $total += $article['sous_total'];
    }

    require_once 'views/partials/header.php';
    require_once 'views/panier.php';
    require_once 'views/partials/footer.php';
}

// Ajouter au panier
function ajouterPanier() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /ShopESA/?page=connexion');
        exit;
    }

    $product_id = intval($_POST['product_id']);
    $quantite   = intval($_POST['quantite']) ?? 1;

    ajouterAuPanier($_SESSION['user_id'], $product_id, $quantite);

    header('Location: /ShopESA/?page=panier');
    exit;
}

// Modifier la quantité
function modifierPanier() {
    $cart_id  = intval($_POST['cart_id']);
    $quantite = intval($_POST['quantite']);

    // Si quantité = 0 on supprime l'article
    if ($quantite <= 0) {
        supprimerDuPanier($cart_id);
    } else {
        modifierQuantite($cart_id, $quantite);
    }

    header('Location: /ShopESA/?page=panier');
    exit;
}

// Supprimer un article
function supprimerPanier() {
    $cart_id = intval($_POST['cart_id']);
    supprimerDuPanier($cart_id);

    header('Location: /ShopESA/?page=panier');
    exit;
}