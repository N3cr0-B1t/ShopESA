<?php

$titre_page = 'Connexion';
require_once 'partials/header.php';
?>

<div class="container">
    <div class="form-card">
        <h2>Se connecter</h2>

        <?php if (!empty($erreurs)): ?>
            <div class="alert alert-danger">
                <?php foreach ($erreurs as $erreur): ?>
                    <p>❌ <?= htmlspecialchars($erreur) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/ShopESA/?page=connexion">

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="ton@email.com"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Ton mot de passe"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%">
                Se connecter
            </button>

        </form>

        <p style="text-align:center; margin-top:15px;">
            Pas encore de compte ?
            <a href="/ShopESA/?page=inscription">S'inscrire</a>
        </p>

        <!-- Compte de test -->
        <div class="alert alert-info" style="margin-top:20px; font-size:0.85rem;">
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>
