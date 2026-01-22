<?php include '../app/Views/layout/header.php'; ?>

<h1><i class="fa-solid fa-ticket" style="color: var(--accent);"></i> Billetterie Officielle</h1>

<div class="calendar-container">
    <?php if ($upcoming_matches && mysqli_num_rows($upcoming_matches) > 0): ?>
        <div class="match-grid">
            <?php while ($row = mysqli_fetch_assoc($upcoming_matches)): ?>
                <div class="match-card">
                    <!-- Header -->
                    <div class="match-header">
                        <span class="date"><i class="fa-regular fa-calendar"></i>
                            <?php echo date('d/m/Y', strtotime($row['match_date'])); ?>
                        </span>
                        <span class="time"><i class="fa-regular fa-clock"></i>
                            <?php echo date('H:i', strtotime($row['match_date'])); ?>
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="match-content">
                        <div class="team home">
                            <img src="<?php echo $row['home_logo']; ?>" alt="<?php echo htmlspecialchars($row['home_team']); ?>"
                                class="team-logo-md">
                            <span class="team-name">
                                <?php echo htmlspecialchars($row['home_team']); ?>
                            </span>
                        </div>
                        <div class="versus">VS</div>
                        <div class="team away">
                            <span class="team-name">
                                <?php echo htmlspecialchars($row['away_team']); ?>
                            </span>
                            <img src="<?php echo $row['away_logo']; ?>" alt="<?php echo htmlspecialchars($row['away_team']); ?>"
                                class="team-logo-md">
                        </div>
                    </div>

                    <!-- Action Form -->
                    <div class="ticket-action">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form action="index.php?controller=ticket&action=buy" method="POST" style="width: 100%;">
                                <input type="hidden" name="match_id" value="<?php echo $row['id']; ?>">

                                <!-- Sélection Zone -->
                                <div style="margin-bottom: 10px; text-align: left;">
                                    <label style="color: #ccc; font-size: 0.9rem;">Zone :</label>
                                    <select name="zone"
                                        style="width: 100%; padding: 8px; border-radius: 4px; background: #333; color: white; border: 1px solid #555;">
                                        <option value="1">Zone 1 - Virage (30 DH)</option>
                                        <option value="2">Zone 2 - Tribune (50 DH)</option>
                                        <option value="3">Zone 3 - Premium (100 DH)</option>
                                        <option value="4">Zone 4 - VIP (200 DH)</option>
                                    </select>
                                </div>

                                <!-- Sélection Quantité -->
                                <div style="margin-bottom: 15px; text-align: left;">
                                    <label style="color: #ccc; font-size: 0.9rem;">Quantité :</label>
                                    <input type="number" name="quantity" min="1" max="4" value="1"
                                        style="width: 100%; padding: 8px; border-radius: 4px; background: #333; color: white; border: 1px solid #555;">
                                </div>

                                <button type="submit" class="btn-buy">
                                    <i class="fa-solid fa-cart-shopping"></i> Réserver
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="index.php?controller=auth&action=login" class="btn-connect">
                                <i class="fa-solid fa-lock"></i> Connectez-vous pour réserver
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 50px; color: #666;">
            <i class="fa-solid fa-calendar-xmark" style="font-size: 3rem; margin-bottom: 20px;"></i>
            <p>Aucun match disponible à la vente pour le moment.</p>
        </div>
    <?php endif; ?>
</div>

<?php include '../app/Views/layout/footer.php'; ?>