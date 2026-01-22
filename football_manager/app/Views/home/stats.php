<?php include '../app/Views/layout/header.php'; ?>

<h1><i class="fa-solid fa-chart-line" style="color: var(--accent);"></i> Statistiques</h1>

<div class="dashboard-grid">
    <!-- Top Buteurs -->
    <div class="card">
        <div class="card-header">Meilleurs Buteurs</div>
        <div class="scorers-list">
            <?php
            $rank = 1;
            while ($scorer = mysqli_fetch_assoc($topScorers)):
                ?>
                <div class="scorer-item">
                    <span class="scorer-rank">
                        <?php echo $rank++; ?>
                    </span>
                    <img src="<?php echo $scorer['logo_url']; ?>" alt="Team" class="team-logo-sm">
                    <div class="scorer-info">
                        <span class="scorer-name">
                            <?php echo htmlspecialchars($scorer['name']); ?>
                        </span>
                        <span class="scorer-team">
                            <?php echo htmlspecialchars($scorer['team_name']); ?>
                        </span>
                    </div>
                    <span class="scorer-goals">
                        <?php echo $scorer['goals']; ?>
                    </span>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Stats Équipes -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        <?php if ($bestAttack): ?>
            <div class="card">
                <div class="card-header"><i class="fa-solid fa-fire"></i> Meilleure Attaque</div>
                <div style="padding: 20px; text-align: center;">
                    <img src="<?php echo $bestAttack['logo_url']; ?>" alt="Logo"
                        style="width: 80px; height: 80px; object-fit: contain; margin-bottom: 10px;">
                    <h3 style="margin: 0; font-size: 1.2rem;">
                        <?php echo htmlspecialchars($bestAttack['name']); ?>
                    </h3>
                    <p style="margin: 10px 0 0; color: var(--accent); font-weight: bold; font-size: 1.5rem;">
                        <?php echo $bestAttack['total_goals']; ?> Buts
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($bestDefense): ?>
            <div class="card">
                <div class="card-header"><i class="fa-solid fa-shield-halved"></i> Meilleure Défense</div>
                <div style="padding: 20px; text-align: center;">
                    <img src="<?php echo $bestDefense['logo_url']; ?>" alt="Logo"
                        style="width: 80px; height: 80px; object-fit: contain; margin-bottom: 10px;">
                    <h3 style="margin: 0; font-size: 1.2rem;">
                        <?php echo htmlspecialchars($bestDefense['name']); ?>
                    </h3>
                    <p style="margin: 10px 0 0; color: #00ff00; font-weight: bold; font-size: 1.5rem;">
                        <?php echo $bestDefense['total_conceded']; ?> Buts encaissés
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../app/Views/layout/footer.php'; ?>