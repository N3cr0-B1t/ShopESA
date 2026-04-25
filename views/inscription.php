<?php

$titre_page = 'Inscription';
require_once 'views/partials/header.php';
?>

<div class="container">
    <div class="form-card">
        <h2>Créer un compte</h2>

        <?php if (!empty($erreurs)): ?>
            <div class="alert alert-danger">
                <?php foreach ($erreurs as $erreur): ?>
                    <p>❌ <?= htmlspecialchars($erreur) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($succes)): ?>
            <div class="alert alert-success">
                ✅ <?= htmlspecialchars($succes) ?>
                <a href="/ShopESA/?page=connexion">Se connecter</a>
            </div>
        <?php endif; ?>

        <form method="POST" action="/ShopESA/?page=inscription">

            <div class="form-group">
                <label for="nom">Nom complet</label>
                <input
                    type="text"
                    id="nom"
                    name="nom"
                    placeholder="Ton nom complet"
                    value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
                    required
                >
            </div>

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
                    placeholder="Minimum 6 caractères"
                    required
                >
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    placeholder="Répète ton mot de passe"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%">
                Créer mon compte
            </button>

        </form>

        <p style="text-align:center; margin-top:15px;">
            Déjà un compte ?
            <a href="/ShopESA/?page=connexion">Se connecter</a>
        </p>
    </div>
</div>

<?php require_once 'views/partials/footer.php'; ?>
