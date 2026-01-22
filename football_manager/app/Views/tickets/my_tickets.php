<?php include '../app/Views/layout/header.php'; ?>

<h1>Mes Tickets</h1>

<?php if (isset($_GET['success'])): ?>
    <div
        style="background: rgba(0, 150, 64, 0.2); color: #00ff00; padding: 15px; border-radius: 8px; margin-bottom: 30px; text-align: center; border: 1px solid #009640;">
        <i class="fa-solid fa-check-circle"></i> Félicitations ! Votre réservation <strong>
            <?php echo htmlspecialchars($_GET['success']); ?>
        </strong> est confirmée.
    </div>
<?php endif; ?>

<?php if (isset($_GET['deleted'])): ?>
    <div
        style="background: rgba(227, 27, 35, 0.2); color: #ff6b6b; padding: 15px; border-radius: 8px; margin-bottom: 30px; text-align: center; border: 1px solid #e31b23;">
        <i class="fa-solid fa-trash"></i> Le ticket a été supprimé avec succès.
    </div>
<?php endif; ?>

<div class="match-grid">
    <?php if ($tickets && mysqli_num_rows($tickets) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($tickets)): ?>
            <div class="match-card" style="border-left: 5px solid #009640;">
                <div class="match-header" style="background: #009640; color: #fff;">
                    <span class="date">CODE:
                        <?php echo $row['ticket_code']; ?>
                    </span>
                    <span class="time">Zone
                        <?php echo isset($row['zone']) ? $row['zone'] : 'Standard'; ?>
                    </span>
                </div>
                <div class="match-content">
                    <div class="team home">
                        <img src="<?php echo $row['home_logo']; ?>" alt="Logo" class="team-logo-md">
                    </div>
                    <div class="versus" style="font-size: 1rem;">
                        <?php echo date('d/m/Y H:i', strtotime($row['match_date'])); ?>
                    </div>
                    <div class="team away">
                        <img src="<?php echo $row['away_logo']; ?>" alt="Logo" class="team-logo-md">
                    </div>
                </div>
                <div
                    style="text-align: center; padding: 10px; font-family: monospace; color: #888; border-bottom: 1px solid #333;">
                    Quantité : <strong>
                        <?php echo $row['quantity']; ?>
                    </strong> place(s)<br>
                    Achat le
                    <?php echo date('d/m/Y à H:i', strtotime($row['purchase_date'])); ?>
                </div>

                <!-- Bouton Supprimer -->
                <div style="padding: 15px; text-align: center;">
                    <form action="index.php?controller=ticket&action=delete" method="POST"
                        onsubmit="return confirm('Voulez-vous vraiment annuler ce ticket ?');">
                        <input type="hidden" name="ticket_id" value="<?php echo $row['id']; ?>">
                        <button type="submit"
                            style="background: #e31b23; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 0.9rem;">
                            <i class="fa-solid fa-trash"></i> Annuler la réservation
                        </button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="grid-column: 1 / -1; text-align: center; color: #888; margin-top: 50px;">
            Vous n'avez acheté aucun ticket pour le moment.
            <br><br>
            <a href="index.php?controller=ticket&action=index" style="color: var(--accent);">Aller à la billetterie</a>
        </p>
    <?php endif; ?>
</div>

<?php include '../app/Views/layout/footer.php'; ?>