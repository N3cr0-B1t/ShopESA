
# ShopESA — Plateforme E-Commerce PHP
Projet réalisé dans le cadre du TP de Licence 2 Informatique — ESA-AGOE 2024-2025.

##  Binôme
- **Dev 1** — [LAWSON] — Lead Backend/Frontend
- **Dev 2** — [HODIKOU] — Lead Frontend/Backend

##  Prérequis
- XAMPP 8.x (PHP 8.1+, MySQL 8.0, Apache)
- Git 2.x

##  Installation
1. Clone le projet : `git clone https://github.com/N3cr0-B1t/ShopESA.git`
2. Place le dossier dans `/opt/lampp/htdocs/`
3. Importe `database.sql` dans phpMyAdmin
4. Configure `config/db.php` avec tes identifiants BDD
5. Démarre XAMPP : `sudo /opt/lampp/lampp start`
6. Ouvre `http://localhost/ShopESA`

##  Structure
- `controllers/` — logique métier
- `models/` — accès aux données (PDO)
- `views/` — templates HTML/PHP
- `admin/` — interface administrateur
- `public/` — CSS, JS, images statiques
