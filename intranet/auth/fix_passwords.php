<?php
// Script pour corriger les mots de passe dans users.json

// Chemin vers le fichier users.json
$userFile = __DIR__ . '/data/users.json';

// Vérifier si le fichier existe
if (!file_exists($userFile)) {
    die("Erreur: Le fichier users.json n'existe pas dans le dossier data/\n");
}

// Lire le fichier JSON
$json = file_get_contents($userFile);
$users = json_decode($json, true);

if ($users === null) {
    die("Erreur: Impossible de lire le fichier JSON\n");
}

// Mot de passe par défaut pour tous les comptes de test
$defaultPassword = 'password';

// Régénérer les mots de passe hachés
foreach ($users as &$user) {
    $user['password'] = password_hash($defaultPassword, PASSWORD_DEFAULT);
    echo "Mot de passe mis à jour pour: " . $user['username'] . "\n";
}

// Sauvegarder le fichier
$newJson = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
file_put_contents($userFile, $newJson);

echo "\n✅ Tous les mots de passe ont été mis à jour!\n";
echo "Vous pouvez maintenant vous connecter avec:\n";
echo "- admin / password\n";
echo "- test / password\n";
echo "- manager / password\n";
echo "- direction / password\n";

// Test de vérification
echo "\n--- Test de vérification ---\n";
foreach ($users as $user) {
    $isValid = password_verify($defaultPassword, $user['password']);
    echo $user['username'] . ": " . ($isValid ? "✅ OK" : "❌ ERREUR") . "\n";
}
?>