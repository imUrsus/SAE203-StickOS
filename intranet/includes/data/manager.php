<?php
class DataStorage {
    // Correction du chemin - pointant vers le dossier data à la racine
    private static $userFile = __DIR__ . '/../data/users.json';

    private static function readJson($file) {
        if (!file_exists($file)) {
            // Debug: afficher le chemin pour vérifier
            error_log("Fichier non trouvé: " . $file);
            return [];
        }
        $json = file_get_contents($file);
        $decoded = json_decode($json, true);
        if ($decoded === null) {
            error_log("Erreur JSON decode: " . json_last_error_msg());
            return [];
        }
        return $decoded;
    }

    private static function writeJson($file, $data) {
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public static function getUsers() {
        return self::readJson(self::$userFile);
    }

    public static function saveUsers($users) {
        self::writeJson(self::$userFile, $users);
    }

    // Méthode pour débugger
    public static function debugPath() {
        return self::$userFile;
    }
}