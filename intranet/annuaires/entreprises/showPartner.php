<?php
$jsonFile = 'data/annuaire_fournisseurs.json';
$logoFile = 'partnerLogo/';
$jsonData = file_get_contents($jsonFile);
$utilisateurs = json_decode($jsonData, true);
?>
<table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Descrition</th>
                    <th>Logo</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach ($utilisateurs as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['Nom']); ?></td>
                    <td><?php echo htmlspecialchars($user['Description']); ?></td>
                    <td><?php echo htmlspecialchars($user['Logo']); ?></td>
                    <td>
            </tr>
<?php endforeach; ?>