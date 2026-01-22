<?php include '../app/Views/layout/header.php'; ?>

<div class="card">
    <div class="card-header">Classement Général</div>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Équipe</th>
                    <th width="60">Pts</th>
                    <th width="50">J</th>
                    <th width="50">Diff</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($standings && mysqli_num_rows($standings) > 0) {
                    $rank = 1;
                    while ($row = mysqli_fetch_assoc($standings)): ?>
                        <tr>
                            <td>
                                <?php echo $rank++; ?>
                            </td>
                            <td>
                                <div class="team-cell">
                                    <?php if (!empty($row['logo_url'])): ?>
                                        <img src="<?php echo $row['logo_url']; ?>" class="team-logo-sm" alt="Logo">
                                    <?php endif; ?>
                                    <?php echo htmlspecialchars($row['name']); ?>
                                </div>
                            </td>
                            <td><strong style="color: #fff;">
                                    <?php echo $row['points']; ?>
                                </strong></td>
                            <td style="color: #888;">
                                <?php echo $row['played']; ?>
                            </td>
                            <td>
                                <?php echo ($row['goal_diff'] > 0 ? '+' : '') . $row['goal_diff']; ?>
                            </td>
                        </tr>
                    <?php endwhile;
                } else {
                    echo "<tr><td colspan='5'>Aucune donnée disponible.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../app/Views/layout/footer.php'; ?>