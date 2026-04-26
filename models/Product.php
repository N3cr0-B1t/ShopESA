<?php

function getAllProducts() {
    $pdo = getDB();
    $stmt = $pdo->query("
        SELECT p.*, c.nom AS categorie_nom
        FROM products p
        LEFT JOIN categories c ON p.cat_id = c.id
        ORDER BY p.created_at DESC
    ");
    return $stmt->fetchAll();
}

function getProductsByCategorie($cat_id) {
    $pdo = getDB();
    $stmt = $pdo->prepare("
        SELECT p.*, c.nom AS categorie_nom
        FROM products p
        LEFT JOIN categories c ON p.cat_id = c.id
        WHERE p.cat_id = :cat_id
        ORDER BY p.created_at DESC
    ");
    $stmt->execute([':cat_id' => $cat_id]);
    return $stmt->fetchAll();
}

function getProductById($id) {
    $pdo = getDB();
    $stmt = $pdo->prepare("
        SELECT p.*, c.nom AS categorie_nom
        FROM products p
        LEFT JOIN categories c ON p.cat_id = c.id
        WHERE p.id = :id
        LIMIT 1
    ");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function getAllCategories() {
    $pdo = getDB();
    return $pdo->query("SELECT * FROM categories ORDER BY nom")->fetchAll();
}
function createProduct($data) {
    $pdo = getDB();
    $stmt = $pdo->prepare("
        INSERT INTO products (nom, description, prix, stock, cat_id, image)
        VALUES (:nom, :description, :prix, :stock, :cat_id, :image)
    ");
    $stmt->execute($data);
}

function updateProduct($id, $data) {
    $pdo = getDB();
    $stmt = $pdo->prepare("
        UPDATE products
        SET nom = :nom,
            description = :description,
            prix = :prix,
            stock = :stock,
            cat_id = :cat_id,
            image = :image
        WHERE id = :id
    ");
    $data[':id'] = $id;
    $stmt->execute($data);
}

function deleteProduct($id) {
    $pdo = getDB();
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
    $stmt->execute([':id' => $id]);
}