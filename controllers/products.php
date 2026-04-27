<?php
session_start();
require_once '../config/db.php';
require_once '../models/Product.php';

// Protection admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../views/connexion.php');
    exit;
}

$action = $_GET['action'] ?? 'list';
$id     = isset($_GET['id']) ? intval($_GET['id']) : null;

// ── AJOUT ──────────────────────────────────────────────────
if ($action === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = uploadImage($_FILES['image']);
    createProduct(
        htmlspecialchars($_POST['nom']),
        htmlspecialchars($_POST['description']),
        floatval($_POST['prix']),
        intval($_POST['stock']),
        intval($_POST['cat_id']),
        $image
    );
    header('Location: products.php');
    exit;
}

// ── MODIFICATION ───────────────────────────────────────────
if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
    $product = getProductById($id);
    $image   = !empty($_FILES['image']['name'])
               ? uploadImage($_FILES['image'])
               : $product['image'];
    updateProduct(
        $id,
        htmlspecialchars($_POST['nom']),
        htmlspecialchars($_POST['description']),
        floatval($_POST['prix']),
        intval($_POST['stock']),
        intval($_POST['cat_id']),
        $image
    );
    header('Location: products.php');
    exit;
}

// ── SUPPRESSION ────────────────────────────────────────────
if ($action === 'delete' && $id) {
    deleteProduct($id);
    header('Location: products.php');
    exit;
}

// ── UPLOAD IMAGE ───────────────────────────────────────────
function uploadImage($file) {
    if (empty($file['name'])) return 'default.png';

    // Vérification du type de fichier
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($file['type'], $allowedTypes)) {
        die('Format non autorisé. Utilisez jpg, png ou webp.');
    }

    $ext  = pathinfo($file['name'], PATHINFO_EXTENSION);
    $name = uniqid('prod_') . '.' . $ext;

    // Chemin absolu pour éviter les erreurs
    $destination = dirname(__DIR__) . '/uploads/' . $name;
    move_uploaded_file($file['tmp_name'], $destination);

    return $name;
}

// ── CHARGEMENT DES VUES ────────────────────────────────────
$categories = getAllCategories();

if ($action === 'create') {
    require '../views/gestionProduits/createprod.php';
} elseif ($action === 'edit' && $id) {
    $product = getProductById($id);
    require '../views/gestionProduits/ModfProd.php';
} else {
    $products = getAllProducts();
    require '../views/gestionProduits/listprod.php';
}
