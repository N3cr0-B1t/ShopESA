<?php
// ============================================
// Logique des commandes
// ============================================

// Requires
require_once 'models/Order.php';
require_once 'models/Cart.php';

/**
 * Gèrer le formulaire et la validation de commande
 */
function gererCommande() {

    // Vérifie que l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        header('Location: /ShopESA/?page=connexion');
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $erreurs = [];
    $succes  = false;

    // Récupère les articles du panier
    $items = getCartItems($user_id);

    // Panier vide — redirige
    if (empty($items)) {
        header('Location: /ShopESA/?page=panier');
        exit;
    }

    // Calcul des totaux
    $total_ht  = array_sum(array_column($items, 'sous_total'));
    $tva       = $total_ht * 0.18;
    $total_ttc = $total_ht + $tva;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Récupération des données du formulaire
        $nom       = trim($_POST['nom'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $adresse   = trim($_POST['adresse'] ?? '');
        $ville     = trim($_POST['ville'] ?? '');

        // Validations
        if (empty($nom))       $erreurs[] = "Le nom est obligatoire.";
        if (empty($telephone)) $erreurs[] = "Le téléphone est obligatoire.";
        if (empty($adresse))   $erreurs[] = "L'adresse est obligatoire.";
        if (empty($ville))     $erreurs[] = "La ville est obligatoire.";

        // Vérifie les stocks une dernière fois
        $alertes_stock = verifierStockPanier($user_id);
        if (!empty($alertes_stock)) {
            $erreurs = array_merge($erreurs, $alertes_stock);
        }

        if (empty($erreurs)) {

            // Formate l'adresse complète
            $adresse_complete = "$nom\n$telephone\n$adresse\n$ville";

            // Crée la commande en BDD
            $order_id = creerCommande($user_id, $total_ttc, $adresse_complete);

            if ($order_id) {
                // Ajoute les articles de la commande
                ajouterItemsCommande($order_id, $items);

                // Vide le panier
                viderPanier($user_id);
                $_SESSION['panier_count'] = 0;

                // Redirige vers confirmation
                header('Location: /ShopESA/?page=historique&commande_id=' . $order_id . '&succes=1');
                exit;
            } else {
                $erreurs[] = "Erreur lors de la création de la commande.";
            }
        }
    }

    // Charge la vue
    require_once 'views/partials/header.php';
    require_once 'views/commande.php';
    require_once 'views/partials/footer.php';
}

/**
 * Affiche l'historique des commandes du client
 */
function afficherHistorique() {

    // Vérifie que l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        header('Location: /ShopESA/?page=connexion');
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Message de succès après une commande
    $succes      = isset($_GET['succes']) ? true : false;
    $commande_id = isset($_GET['commande_id']) ? (int)$_GET['commande_id'] : null;

    // Récupère toutes les commandes de l'utilisateur
    $commandes = getCommandesUtilisateur($user_id);

    // Récupère le détail de la commande si demandé
    $detail_commande = null;
    if ($commande_id) {
        $detail_commande = getCommandeDetail($commande_id, $user_id);
    }

    require_once 'views/partials/header.php';
    require_once 'views/historique.php';
    require_once 'views/partials/footer.php';
}

// Dashboard admin — gestion des commandes
function afficherDashboardAdmin() {

    // Protection admin
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
        header('Location: /ShopESA/?page=connexion');
        exit;
    }

    // Changer le statut si formulaire soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $order_id = intval($_POST['order_id']);
        $statut   = $_POST['statut'];
        updateStatutCommande($order_id, $statut);
        header('Location: /ShopESA/?page=admin_commandes&success=1');
        exit;
    }

    // Récupérer toutes les commandes
    $commandes = getAllCommandes();

    require_once 'views/partials/header.php';
    require_once 'views/admin_commandes.php';
    require_once 'views/partials/footer.php';
}
