<?php

// Récupérer le panier d'un utilisateur
function getCartByUser($user_id) {
    $pdo = getDB();
    $stmt = $pdo->prepare("
        SELECT c.id, c.quantite, p.nom, p.prix, p.image,
               (c.quantite * p.prix) AS sous_total
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = :user_id
    ");
    $stmt->execute([':user_id' => $user_id]);
    return $stmt->fetchAll();
}

// Ajouter un produit au panier
function ajouterAuPanier($user_id, $product_id, $quantite) {
    $pdo = getDB();

    // Si le produit est déjà dans le panier, on augmente la quantité
    $stmt = $pdo->prepare("SELECT id FROM cart WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute([':user_id' => $user_id, ':product_id' => $product_id]);
    $existant = $stmt->fetch();

    if ($existant) {
        $stmt = $pdo->prepare("UPDATE cart SET quantite = quantite + :quantite WHERE id = :id");
        $stmt->execute([':quantite' => $quantite, ':id' => $existant['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantite) VALUES (:user_id, :product_id, :quantite)");
        $stmt->execute([':user_id' => $user_id, ':product_id' => $product_id, ':quantite' => $quantite]);
    }
}

// Modifier la quantité d'un article
function modifierQuantite($cart_id, $quantite) {
    $pdo = getDB();
    $stmt = $pdo->prepare("UPDATE cart SET quantite = :quantite WHERE id = :id");
    $stmt->execute([':quantite' => $quantite, ':id' => $cart_id]);
}

// Supprimer un article du panier
function supprimerDuPanier($cart_id) {
    $pdo = getDB();
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = :id");
    $stmt->execute([':id' => $cart_id]);
}