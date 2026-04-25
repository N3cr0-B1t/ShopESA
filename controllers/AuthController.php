<?php

require_once 'models/User.php';

/**
 * Gèrer l'inscription d'un nouvel utilisateur
 */
function gererInscription() {
    $erreurs = [];
    $succes  = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Récupération et nettoyage des données
        $nom      = trim($_POST['nom'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm  = trim($_POST['confirm_password'] ?? '');

        if (empty($nom)) {
            $erreurs[] = "Le nom est obligatoire.";
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreurs[] = "L'email est invalide.";
        }

        if (strlen($password) < 6) {
            $erreurs[] = "Le mot de passe doit faire au moins 6 caractères.";
        }

        if ($password !== $confirm) {
            $erreurs[] = "Les mots de passe ne correspondent pas.";
        }

        if (emailExiste($email)) {
            $erreurs[] = "Cet email est déjà utilisé.";
        }

        if (empty($erreurs)) {
            if (creerUtilisateur($nom, $email, $password)) {
                $succes = "Compte créé avec succès ! Tu peux maintenant te connecter.";
            } else {
                $erreurs[] = "Une erreur est survenue. Réessaie.";
            }
        }
    }

    // Charge la vue inscription avec les données
    require_once 'views/inscription.php';
}

/**
 * Gère la connexion d'un utilisateur
 */
function gererConnexion() {
    $erreurs = [];

    // Si déjà connecté on redirige vers l'accueil
    if (isset($_SESSION['user_id'])) {
        header('Location: /ShopESA/?page=accueil');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            $erreurs[] = "Email et mot de passe obligatoires.";
        } else {

            $user = trouverUtilisateurParEmail($email);

            // Vérifier le mot de passe avec bcrypt
            if ($user && password_verify($password, $user['password'])) {

                $_SESSION['user_id']   = $user['id'];
                $_SESSION['user_nom']  = $user['nom'];
                $_SESSION['user_role'] = $user['role'];

                // Rediriger selon le rôle
                if ($user['role'] === 'admin') {
                    header('Location: /ShopESA/admin/');
                } else {
                    header('Location: /ShopESA/?page=accueil');
                }
                exit;

            } else {
                $erreurs[] = "Email ou mot de passe incorrect.";
            }
        }
    }


    require_once 'views/connexion.php';
}

/**
 * Déconnecter l'utilisateur
 */
function gererDeconnexion() {

    session_destroy();
    header('Location: /ShopESA/?page=connexion');
    exit;
}
