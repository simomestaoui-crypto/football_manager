<?php include '../app/Views/layout/header.php'; ?>

<div class="card" style="max-width: 400px; margin: 50px auto; padding: 30px;">
    <h2 style="text-align: center; margin-bottom: 20px;">Inscription</h2>

    <?php if ($success): ?>
        <div
            style="background: rgba(0, 150, 64, 0.2); color: #00ff00; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center;">
            Compte créé avec succès ! <a href="index.php?controller=auth&action=login"
                style="color: #fff; font-weight: bold;">Connectez-vous</a>.
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div
            style="background: rgba(227, 27, 35, 0.2); color: #ff6b6b; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label style="color: #ccc;">Nom d'utilisateur :</label>
        <input type="text" name="username" required
            style="width: 100%; padding: 10px; margin: 5px 0 15px; background: #333; border: 1px solid #555; color: white; border-radius: 4px;">

        <label style="color: #ccc;">Email :</label>
        <input type="email" name="email" required
            style="width: 100%; padding: 10px; margin: 5px 0 15px; background: #333; border: 1px solid #555; color: white; border-radius: 4px;">

        <label style="color: #ccc;">Mot de passe :</label>
        <input type="password" name="password" required
            style="width: 100%; padding: 10px; margin: 5px 0 15px; background: #333; border: 1px solid #555; color: white; border-radius: 4px;">

        <label style="color: #ccc;">Confirmer le mot de passe :</label>
        <input type="password" name="confirm_password" required
            style="width: 100%; padding: 10px; margin: 5px 0 15px; background: #333; border: 1px solid #555; color: white; border-radius: 4px;">

        <button type="submit" class="btn-buy" style="width: 100%; border-radius: 5px;">S'inscrire</button>
    </form>

    <p style="text-align: center; margin-top: 15px; font-size: 0.9rem;">
        Déjà un compte ? <a href="index.php?controller=auth&action=login" style="color: var(--accent);">Se connecter</a>
    </p>
</div>

<?php include '../app/Views/layout/footer.php'; ?>