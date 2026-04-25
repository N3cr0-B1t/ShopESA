<?php

require_once 'models/Product.php';

/**
 * Afficher la liste des produits
 */
function afficherCatalogue() {

    $categories = getAllCategories();

    $cat_id = isset($_GET['cat']) ? (int)$_GET['cat'] : null;

    if ($cat_id) {
        $produits = getProductsByCategorie($cat_id);
        $categorie_active = $cat_id;
    } else {
        $produits = getAllProducts();
        $categorie_active = null;
    }


    require_once 'views/partials/header.php';
    require_once 'views/produits.php';
    require_once 'views/partials/footer.php';
}

/**
 * Afficher les détails d'un produit
 */
function afficherDetailProduit() {

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    $produit = getProductById($id);


    if (!$produit) {
        require_once 'views/partials/header.php';
        require_once 'views/404.php';
        require_once 'views/partials/footer.php';
        return;
    }

    require_once 'views/partials/header.php';
    require_once 'views/produit_detail.php';
    require_once 'views/partials/footer.php';
}
