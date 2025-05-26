<?php
define('CLIENTS_FILE', __DIR__ . '/clients_data.json');
// Charger tous les clients
function getAllClients() {
    if (!file_exists(CLIENTS_FILE)) {
        return [];
    }
    $json = file_get_contents(CLIENTS_FILE);
    return json_decode($json, true);
}
// Sauvegarder les clients
function saveClients($clients) {
    $json = json_encode($clients, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents(CLIENTS_FILE, $json);
}
// Récupérer un client par ID
function getClientById($id) {
    $clients = getAllClients();
    foreach ($clients as $client) {
        if ($client['id'] == $id) {
            return $client;
        }
    }
    return null;
}
// Ajouter un nouveau client
function addClient($data) {
    $clients = getAllClients();
    $lastId = 0;
    foreach ($clients as $c) {
        if ($c['id'] > $lastId) {
            $lastId = $c['id'];
        }
    }
    $data['id'] = $lastId + 1;
    // Si on fournit un mot de passe, on le hash
    if (!empty($data['mot_de_passe'])) {
        $data['mot_de_passe'] = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
    }
    $clients[] = $data;
    saveClients($clients);
}
// Modifier un client existant
function updateClient($id, $newData) {
    $clients = getAllClients();
    foreach ($clients as &$client) {
        if ($client['id'] == $id) {
            $client = array_merge($client, $newData);
            // Si mot de passe fourni, on le hash
            if (!empty($newData['mot_de_passe'])) {
                $client['mot_de_passe'] = password_hash($newData['mot_de_passe'], PASSWORD_DEFAULT);
            }
            break;
        }
    }
    saveClients($clients);
}
// Supprimer un client
function deleteClient($id) {
    $clients = getAllClients();
    $clients = array_filter($clients, function($c) use ($id) {
        return $c['id'] != $id;
    });
    saveClients(array_values($clients));
}
