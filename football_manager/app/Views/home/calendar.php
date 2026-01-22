<?php include '../app/Views/layout/header.php'; ?>

<h1><i class="fa-regular fa-calendar-days" style="color: var(--accent);"></i> Calendrier & Résultats</h1>

<div class="card">
    <div class="card-header">Matchs à venir</div>
    <div class="match-grid" style="padding: 20px;">
        <?php if ($upcoming && mysqli_num_rows($upcoming) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($upcoming)): ?>
                <div class="match-card">
                    <div class="match-header">
                        <span class="date"><i class="fa-regular fa-calendar"></i>
                            <?php echo date('d/m/Y', strtotime($row['match_date'])); ?>
                        </span>
                        <span class="time"><i class="fa-regular fa-clock"></i>
                            <?php echo date('H:i', strtotime($row['match_date'])); ?>
                        </span>
                    </div>
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
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; color: #888;">Aucun match programmé.</p>
        <?php endif; ?>
    </div>
</div>

<div class="card">
    <div class="card-header">Derniers Résultats</div>
    <div class="match-grid" style="padding: 20px;">
        <?php if ($played && mysqli_num_rows($played) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($played)): ?>
                <div class="match-card" style="border-left: 5px solid #444;">
                    <div class="match-header">
                        <span class="date">
                            <?php echo date('d/m/Y', strtotime($row['match_date'])); ?>
                        </span>
                        <span class="time">Terminé</span>
                    </div>
                    <div class="match-content">
                        <div class="team home">
                            <img src="<?php echo $row['home_logo']; ?>" alt="Logo" class="team-logo-md">
                            <span class="team-name">
                                <?php echo htmlspecialchars($row['home_team']); ?>
                            </span>
                        </div>
                        <div class="versus">
                            <?php echo $row['home_score']; ?> -
                            <?php echo $row['away_score']; ?>
                        </div>
                        <div class="team away">
                            <span class="team-name">
                                <?php echo htmlspecialchars($row['away_team']); ?>
                            </span>
                            <img src="<?php echo $row['away_logo']; ?>" alt="Logo" class="team-logo-md">
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; color: #888;">Aucun match joué récemment.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../app/Views/layout/footer.php'; ?>