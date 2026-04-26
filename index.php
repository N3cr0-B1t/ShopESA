<?php

session_start();
require_once 'config/db.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/CartController.php';
// Récupère la page demandée dans l'URL
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

// Sécurité :
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
    'profil',
    'ajouter_panier',
    'modifier_panier',
    'supprimer_panier'
];

if (!in_array($page, $pages_autorisees)) {
    $page = 'accueil';
}

// Routing — appelle le bon contrôleur
switch ($page) {
    case 'inscription':
        gererInscription();
        break;

    case 'connexion':
        gererConnexion();
        break;

    case 'deconnexion':
        gererDeconnexion();
        break;

    case 'produits':
        afficherCatalogue();
        break;

    case 'produit_detail':
        afficherDetailProduit();
        break;
    case 'panier':
    afficherPanier();
    break;

case 'ajouter_panier':
    ajouterPanier();
    break;

case 'modifier_panier':
    modifierPanier();
    break;

case 'supprimer_panier':
    supprimerPanier();
    break;

    default:

        require_once 'views/partials/header.php';

        $vue = 'views/' . $page . '.php';
        if (file_exists($vue)) {
            require_once $vue;
        } else {
            require_once 'views/404.php';
        }


        require_once 'views/partials/footer.php';
        break;
}
