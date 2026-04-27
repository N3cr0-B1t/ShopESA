<?php
// ============================================
// models/Cart.php
// Gestion du panier en base de données
// ============================================

function getCartItems($user_id) {
    $pdo  = getDB();
    $stmt = $pdo->prepare("
        SELECT c.*, p.nom, p.prix, p.image, p.stock,
               (p.prix * c.quantite) AS sous_total
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = :user_id
    ");
    $stmt->execute([':user_id' => $user_id]);
    return $stmt->fetchAll();
}

function ajouterAuPanier($user_id, $product_id, $quantite = 1) {
    $pdo  = getDB();
    $stmt = $pdo->prepare("
        SELECT id, quantite FROM cart
        WHERE user_id = :user_id AND product_id = :product_id
    ");
    $stmt->execute([':user_id' => $user_id, ':product_id' => $product_id]);
    $existant = $stmt->fetch();

    if ($existant) {
        $stmt = $pdo->prepare("
            UPDATE cart SET quantite = quantite + :quantite WHERE id = :id
        ");
        return $stmt->execute([':quantite' => $quantite, ':id' => $existant['id']]);
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO cart (user_id, product_id, quantite)
            VALUES (:user_id, :product_id, :quantite)
        ");
        return $stmt->execute([
            ':user_id'    => $user_id,
            ':product_id' => $product_id,
            ':quantite'   => $quantite
        ]);
    }
}

function modifierQuantite($cart_id, $user_id, $quantite) {
    $pdo  = getDB();
    $stmt = $pdo->prepare("
        UPDATE cart SET quantite = :quantite
        WHERE id = :id AND user_id = :user_id
    ");
    return $stmt->execute([
        ':quantite' => $quantite,
        ':id'       => $cart_id,
        ':user_id'  => $user_id
    ]);
}

function supprimerDuPanier($cart_id, $user_id) {
    $pdo  = getDB();
    $stmt = $pdo->prepare("
        DELETE FROM cart WHERE id = :id AND user_id = :user_id
    ");
    return $stmt->execute([':id' => $cart_id, ':user_id' => $user_id]);
}

function viderPanier($user_id) {
    $pdo  = getDB();
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = :user_id");
    return $stmt->execute([':user_id' => $user_id]);
}

function compterArticlesPanier($user_id) {
    $pdo  = getDB();
    $stmt = $pdo->prepare("
        SELECT SUM(quantite) FROM cart WHERE user_id = :user_id
    ");
    $stmt->execute([':user_id' => $user_id]);
    return (int) $stmt->fetchColumn();
}

function verifierStockPanier($user_id) {
    $pdo  = getDB();
    $stmt = $pdo->prepare("
        SELECT c.id, c.quantite, p.nom, p.stock
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = :user_id
    ");
    $stmt->execute([':user_id' => $user_id]);
    $items = $stmt->fetchAll();

    $problemes = [];
    foreach ($items as $item) {
        if ($item['stock'] === 0) {
            $problemes[] = "« {$item['nom']} » n'est plus en stock.";
        } elseif ($item['quantite'] > $item['stock']) {
            $problemes[] = "« {$item['nom']} » — seulement {$item['stock']} disponible(s).";
        }
    }
    return $problemes;
}

function getTotalPanier($user_id) {
    $pdo  = getDB();
    $stmt = $pdo->prepare("
        SELECT SUM(p.prix * c.quantite) AS total
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = :user_id
    ");
    $stmt->execute([':user_id' => $user_id]);
    return (float) $stmt->fetchColumn();
}
