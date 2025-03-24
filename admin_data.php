<?php
// php/admin_data.php
session_start();
require_once __DIR__ . '/includes/functions.php';

if (!isAdmin()) {
    // Pas admin => renvoie un JSON avec erreur
    echo json_encode(["error" => "Accès refusé, vous n'êtes pas admin"]);
    exit;
}

// Charger la liste des utilisateurs
$pathUsers = __DIR__ . '/../data/users.json';
$data = loadJSON($pathUsers);
$users = $data['users'] ?? [];

// On renvoie en JSON
echo json_encode(["users" => $users], JSON_UNESCAPED_UNICODE);
