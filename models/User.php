<?php

/**
 * Créer un nouvel utilisateur en BDD
 */
function creerUtilisateur($nom, $email, $password) {
    $pdo = getDB();

    // Hashage sécurisé du mot de passe avec bcrypt
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("
        INSERT INTO users (nom, email, password, role)
        VALUES (:nom, :email, :password, 'client')
    ");

    return $stmt->execute([
        ':nom'      => $nom,
        ':email'    => $email,
        ':password' => $password_hash
    ]);
}

/**
 * Trouver un utilisateur par son email
 */
function trouverUtilisateurParEmail($email) {
    $pdo = getDB();

    $stmt = $pdo->prepare("
        SELECT * FROM users WHERE email = :email LIMIT 1
    ");

    $stmt->execute([':email' => $email]);
    return $stmt->fetch();
}

/**
 * Vérifier si un email existe déjà en BDD
 */
function emailExiste($email) {
    $pdo = getDB();

    $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM users WHERE email = :email
    ");

    $stmt->execute([':email' => $email]);
    return $stmt->fetchColumn() > 0;
}
