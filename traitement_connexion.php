<?php
// php/traitement_connexion.php
session_start();
require_once __DIR__ . '/includes/functions.php';

$pathUsers = __DIR__ . '/../data/users.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email']    ?? '';
    $password = $_POST['password'] ?? '';

    // Charger la liste des users
    $data = loadJSON($pathUsers);
    if (!$data) {
        header('Location: ../connexion.html?error=no_data');
        exit;
    }

    // Vérifier si un user correspond
    $foundUser = null;
    foreach ($data['users'] as $u) {
        if ($u['email'] === $email && $u['password'] === $password) {
            $foundUser = $u;
            break;
        }
    }

    if ($foundUser) {
        // OK
        $_SESSION['user'] = $foundUser;
        // Redirection : si c’est un admin, on peut rediriger vers admin.html ou profil.html
        if ($foundUser['role'] === 'admin') {
            header('Location: ../admin.html');
        } else {
            header('Location: ../profil.html');
        }
        exit;
    } else {
        // Mauvais identifiants
        header('Location: ../connexion.html?error=bad_creds');
        exit;
    }

} else {
    echo "Méthode invalide.";
}
