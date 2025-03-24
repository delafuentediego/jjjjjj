<?php
// php/profile_data.php
session_start();
require_once __DIR__ . '/includes/functions.php';

// Vérifier si connecté
if (!isLoggedIn()) {
    echo json_encode(["error" => "Non connecté"]);
    exit;
}

// Renvoyer les infos du user
echo json_encode(["user" => $_SESSION['user']], JSON_UNESCAPED_UNICODE);
