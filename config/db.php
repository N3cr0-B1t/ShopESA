<?php
// ============================================
// config/db.php
// Connexion PDO à la base de données ShopESA
// ============================================

define('DB_HOST', 'localhost');
define('DB_NAME', 'shopesa');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

/**
 * Retourne une connexion PDO à la base de données
 * @return PDO
 */
function getDB() {
    static $pdo = null;


    if ($pdo !== null) {
        return $pdo;
    }

    try {
        $dsn = "mysql:host=" . DB_HOST . 
               ";dbname=" . DB_NAME . 
               ";charset=" . DB_CHARSET;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

    } catch (PDOException $e) {
 
       die("Erreur de connexion à la base de données.");
    }

    return $pdo;
}
