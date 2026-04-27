<?php
// ============================================
// Logique du panier d'achat
// ============================================

require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Product.php';

/**
 * Gère toutes les actions du panier
 */
function gererPanier() {

    // Vérifie que l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        header('Location: /ShopESA/?page=connexion');
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $action  = $_POST['action'] ?? $_GET['action'] ?? 'afficher';
    $message = '';
    $erreur  = '';

    switch ($action) {

        // ── Ajouter un produit au panier ──
        case 'ajouter':
            $product_id = (int)($_POST['product_id'] ?? 0);
            $quantite   = (int)($_POST['quantite'] ?? 1);

            // Vérifie que le produit existe et est en stock
            $produit = getProductById($product_id);

            if (!$produit) {
                $erreur = "Produit introuvable.";
                break;
            }

            if ($produit['stock'] < $quantite) {
                $erreur = "Stock insuffisant.";
                break;
            }

            if (ajouterAuPanier($user_id, $product_id, $quantite)) {
                // Met à jour le compteur dans la session
                $_SESSION['panier_count'] = compterArticlesPanier($user_id);
                $message = "Produit ajouté au panier !";
            } else {
                $erreur = "Erreur lors de l'ajout au panier.";
            }
            break;

        // ── Modifier la quantité ──
        case 'modifier':
            $cart_id  = (int)($_POST['cart_id'] ?? 0);
            $quantite = (int)($_POST['quantite'] ?? 1);

            if ($quantite < 1) {
                // Quantité = 0 → on supprime
                supprimerDuPanier($cart_id, $user_id);
                $message = "Article supprimé du panier.";
            } else {
                modifierQuantite($cart_id, $user_id, $quantite);
                $message = "Quantité mise à jour.";
            }

            $_SESSION['panier_count'] = compterArticlesPanier($user_id);
            break;

        // ── Supprimer un article ──
        case 'supprimer':
            $cart_id = (int)($_GET['cart_id'] ?? 0);
            supprimerDuPanier($cart_id, $user_id);
            $_SESSION['panier_count'] = compterArticlesPanier($user_id);
            $message = "Article supprimé du panier.";
            break;

        // ── Vider le panier ──
        case 'vider':
            viderPanier($user_id);
            $_SESSION['panier_count'] = 0;
            $message = "Panier vidé.";
            break;
    }

    // Récupère les articles du panier pour la vue
    $items   = getCartItems($user_id);

    // Calcul du total HT et TTC (TVA 18%)
    $total_ht  = array_sum(array_column($items, 'sous_total'));
    $tva       = $total_ht * 0.18;
    $total_ttc = $total_ht + $tva;

    // Charge la vue
    require_once 'views/partials/header.php';
    require_once 'views/panier.php';
    require_once 'views/partials/footer.php';
}
