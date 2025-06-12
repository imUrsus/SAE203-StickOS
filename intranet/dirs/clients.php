<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../includes/clients/functions.php';
$clients = getAllClients();

include_once "../includes/template.php";
settings("Annuaire clients");
head();
?>
<div class="container mt-5">
    <h1 class="mb-4">Annuaire des clients</h1>
    <div class="mb-3 text-end">
        <a href="../includes/clients/manage_client.php" class="btn btn-success">Ajouter un client</a>
    </div>
    <table class="table table-striped table-hover table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>Adresse</th>
                <th>Supprimer/Modifier</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($clients) === 0): ?>
            <tr><td colspan="7" class="text-center">Aucun client enregistré.</td></tr>
        <?php else: ?>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= htmlspecialchars($client['id']) ?></td>
                    <td><?= htmlspecialchars($client['nom']) ?></td>
                    <td><?= htmlspecialchars($client['prenom']) ?></td>
                    <td><?= htmlspecialchars($client['email']) ?></td>
                    <td><?= htmlspecialchars($client['tel']) ?></td>
                    <td><?= htmlspecialchars($client['adresse']) ?></td>
                    <td>
                        <a href="../includes/clients/manage_client.php?id=<?= $client['id'] ?>" class="btn btn-sm btn-primary">Modifier</a>
                        <a href="../includes/clients/manage_client.php?action=delete&id=<?= $client['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce client ?');">Supprimer</a>
                        <a href="../includes/clients/download.php?id=<?= $client['id'] ?>" class="btn btn-sm btn-secondary">Fiche</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php foot(); ?>
</body>
</html>
