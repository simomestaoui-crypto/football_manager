<?php include '../app/Views/layout/header.php'; ?>

<h1>Contactez-nous</h1>

<div class="card" style="max-width: 600px; margin: 0 auto; padding: 20px;">
    <?php if ($msg_sent): ?>
        <div
            style="background: rgba(0, 150, 64, 0.2); color: #00ff00; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
            <i class="fa-solid fa-check-circle"></i> Message envoyé avec succès ! Nous vous répondrons bientôt.
        </div>
    <?php endif; ?>

    <p style="color: #ccc; margin-bottom: 20px;">
        Une question ? Un problème technique ? Remplissez ce formulaire.
    </p>

    <form method="POST">
        <label style="color: #fff;">Nom complet :</label>
        <input type="text" name="name" required
            style="width: 100%; padding: 10px; margin: 5px 0 15px; background: #333; border: 1px solid #555; color: white; border-radius: 4px;">

        <label style="color: #fff;">Email :</label>
        <input type="email" name="email" required
            style="width: 100%; padding: 10px; margin: 5px 0 15px; background: #333; border: 1px solid #555; color: white; border-radius: 4px;">

        <label style="color: #fff;">Message :</label>
        <textarea name="message" rows="5" required
            style="width: 100%; padding: 10px; margin: 5px 0 15px; background: #333; border: 1px solid #555; color: white; border-radius: 4px;"></textarea>

        <button type="submit" class="btn-buy" style="border-radius: 5px; width: 100%;">
            <i class="fa-solid fa-paper-plane"></i> Envoyer
        </button>
    </form>
</div>

<?php include '../app/Views/layout/footer.php'; ?>