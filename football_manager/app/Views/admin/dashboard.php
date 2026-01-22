<?php include '../app/Views/layout/header.php'; ?>

<h1>Administration</h1>

<?php if ($message): ?>
    <div
        style="padding: 15px; background: rgba(0,255,0,0.1); border: 1px solid green; color: green; border-radius: 8px; margin-bottom: 20px;">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<div class="dashboard-grid">

    <!-- Section 1: Ajouter une équipe -->
    <div class="card">
        <div class="card-header">Ajouter une Équipe</div>
        <div style="padding: 20px;">
            <form method="POST">
                <label style="color: #ccc;">Nom de l'équipe :</label>
                <input type="text" name="team_name" required
                    style="width: 100%; padding: 10px; margin: 10px 0; background: #333; border: 1px solid #555; color: white; border-radius: 4px;">
                <button type="submit" name="add_team" class="btn-buy" style="border-radius: 5px;">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- Section 2: Programmer un Match -->
    <div class="card">
        <div class="card-header">Programmer un Match</div>
        <div style="padding: 20px;">
            <form method="POST">
                <label style="color: #ccc;">Domicile :</label>
                <select name="home_team"
                    style="width: 100%; padding: 10px; margin: 5px 0; background: #333; color: white;">
                    <?php
                    if ($teams) {
                        mysqli_data_seek($teams, 0);
                        while ($t = mysqli_fetch_assoc($teams)): ?>
                            <option value="<?php echo $t['id']; ?>">
                                <?php echo $t['name']; ?>
                            </option>
                        <?php endwhile;
                    } ?>
                </select>

                <label style="color: #ccc; display:block; margin-top: 10px;">Extérieur :</label>
                <select name="away_team"
                    style="width: 100%; padding: 10px; margin: 5px 0; background: #333; color: white;">
                    <?php
                    if ($teams) {
                        mysqli_data_seek($teams, 0);
                        while ($t = mysqli_fetch_assoc($teams)): ?>
                            <option value="<?php echo $t['id']; ?>">
                                <?php echo $t['name']; ?>
                            </option>
                        <?php endwhile;
                    } ?>
                </select>

                <label style="color: #ccc; display:block; margin-top: 10px;">Date & Heure :</label>
                <input type="datetime-local" name="match_date" required
                    style="width: 100%; padding: 10px; margin: 5px 0; background: #333; border: 1px solid #555; color: white;">

                <button type="submit" name="add_match" class="btn-buy"
                    style="border-radius: 5px; margin-top: 15px;">Programmer</button>
            </form>
        </div>
    </div>

</div>

<!-- Liste des matchs prévus -->
<div class="card" style="margin-top: 30px;">
    <div class="card-header">Matchs à venir</div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Domicile</th>
                <th>Extérieur</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($matchs):
                while ($m = mysqli_fetch_assoc($matchs)): ?>
                    <tr>
                        <td>
                            <?php echo date('d/m/Y H:i', strtotime($m['match_date'])); ?>
                        </td>
                        <td>
                            <?php echo $m['home_team']; ?>
                        </td>
                        <td>
                            <?php echo $m['away_team']; ?>
                        </td>
                        <td><span class="badge">Prévu</span></td>
                    </tr>
                <?php endwhile; endif; ?>
        </tbody>
    </table>
</div>

<?php include '../app/Views/layout/footer.php'; ?>