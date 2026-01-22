<?php include '../app/Views/layout/header.php'; ?>

<div class="card" style="max-width: 400px; margin: 50px auto; padding: 30px;">
    <h2 style="text-align: center; margin-bottom: 20px;">Connexion</h2>

    <?php if ($error): ?>
        <div
            style="background: rgba(227, 27, 35, 0.2); color: #ff6b6b; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label style="color: #ccc;">Email :</label>
        <input type="email" name="email" required
            style="width: 100%; padding: 10px; margin: 5px 0 15px; background: #333; border: 1px solid #555; color: white; border-radius: 4px;">

        <label style="color: #ccc;">Mot de passe :</label>
        <input type="password" name="password" required
            style="width: 100%; padding: 10px; margin: 5px 0 15px; background: #333; border: 1px solid #555; color: white; border-radius: 4px;">

        <button type="submit" class="btn-buy" style="width: 100%; border-radius: 5px;">Se connecter</button>
    </form>

    <p style="text-align: center; margin-top: 15px; font-size: 0.9rem;">
        Pas encore de compte ? <a href="index.php?controller=auth&action=register" style="color: var(--accent);">Créer
            un compte</a>
    </p>
</div>

<?php include '../app/Views/layout/footer.php'; ?>