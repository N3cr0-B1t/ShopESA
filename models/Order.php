<?php
// ============================================
// Gestion des commandes en base de données
// ============================================

/**
 * Créer une nouvelle commande en BDD
 * @param int $user_id
 * @param float $total
 * @param string $adresse
 * @return int|false — ID de la commande créée
 */
function creerCommande($user_id, $total, $adresse) {
    $pdo  = getDB();
    $stmt = $pdo->prepare("
        INSERT INTO orders (user_id, total, adresse, statut)
        VALUES (:user_id, :total, :adresse, 'en_attente')
    ");
    $stmt->execute([
        ':user_id' => $user_id,
        ':total'   => $total,
        ':adresse' => $adresse
    ]);
    return $pdo->lastInsertId();
}

/**
 * ajouter les articles d'une commande
 * @param int $order_id
 * @param array $items
 * @return bool
 */
function ajouterItemsCommande($order_id, $items) {
    $pdo  = getDB();
    $stmt = $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, quantite, prix_unit)
        VALUES (:order_id, :product_id, :quantite, :prix_unit)
    ");

    foreach ($items as $item) {
        $stmt->execute([
            ':order_id'   => $order_id,
            ':product_id' => $item['product_id'],
            ':quantite'   => $item['quantite'],
            ':prix_unit'  => $item['prix']
        ]);
    }
    return true;
}

/**
 * Récupèrer toutes les commandes d'un utilisateur
 * @param int $user_id
 * @return array
 */
function getCommandesUtilisateur($user_id) {
    $pdo  = getDB();
    $stmt = $pdo->prepare("
        SELECT * FROM orders
        WHERE user_id = :user_id
        ORDER BY created_at DESC
    ");
    $stmt->execute([':user_id' => $user_id]);
    return $stmt->fetchAll();
}

/**
 * Récupèrer le détail d'une commande
 * @param int $order_id
 * @param int $user_id
 * @return array|false
 */
function getCommandeDetail($order_id, $user_id) {
    $pdo  = getDB();
    $stmt = $pdo->prepare("
        SELECT o.*, oi.quantite, oi.prix_unit,
               p.nom AS produit_nom, p.image
        FROM orders o
        JOIN order_items oi ON oi.order_id = o.id
        JOIN products p ON p.id = oi.product_id
        WHERE o.id = :order_id AND o.user_id = :user_id
    ");
    $stmt->execute([
        ':order_id' => $order_id,
        ':user_id'  => $user_id
    ]);
    return $stmt->fetchAll();
}

/**
 * Récupère toutes les commandes (admin)
 * @return array
 */
function getAllCommandes() {
    $pdo  = getDB();
    $stmt = $pdo->query("
        SELECT o.*, u.nom AS client_nom, u.email AS client_email
        FROM orders o
        JOIN users u ON u.id = o.user_id
        ORDER BY o.created_at DESC
    ");
    return $stmt->fetchAll();
}

/**
 * Mettre à jour le statut d'une commande (admin)
 * @param int $order_id
 * @param string $statut
 * @return bool
 */
function updateStatutCommande($order_id, $statut) {
    $pdo  = getDB();
    $stmt = $pdo->prepare("
        UPDATE orders SET statut = :statut WHERE id = :id
    ");
    return $stmt->execute([
        ':statut' => $statut,
        ':id'     => $order_id
    ]);
}