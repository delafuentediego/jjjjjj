<?php
// php/includes/functions.php

function loadJSON($path) {
    if (!file_exists($path)) {
        return null;
    }
    $json = file_get_contents($path);
    return json_decode($json, true);
}

function saveJSON($path, $data) {
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents($path, $json);
}

// Vérifier login/password
function checkCredentials($login, $password, $users) {
    foreach ($users as $user) {
        if ($user['login'] === $login && $user['password'] === $password) {
            return $user;
        }
    }
    return null;
}

// Savoir si on est connecté
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Savoir si on est admin
function isAdmin() {
    return (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin');
}
