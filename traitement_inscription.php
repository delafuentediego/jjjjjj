<?php
// php/traitement_inscription.php
session_start();
require_once __DIR__ . '/includes/functions.php';

$pathUsers = __DIR__ . '/../data/users.json';

// 1. Vérifier la méthode
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2. Récupérer les champs
    $nom      = $_POST['nom']      ?? '';
    $prenom   = $_POST['prenom']   ?? '';
    $email    = $_POST['email']    ?? '';
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm-password'] ?? '';

    // 3. Vérifier password == confirm
    if ($password !== $confirm) {
        header('Location: ../inscription.html?error=pwd_mismatch');
        exit;
    }

    // 4. Charger users.json
    $data = loadJSON($pathUsers);
    if (!$data) {
        $data = ["users" => []];
    }

    // 5. Vérifier si l'email ou le login existent déjà
    foreach ($data['users'] as $u) {
        if ($u['email'] === $email) {
            header('Location: ../inscription.html?error=email_used');
            exit;
        }
    }

    // 6. Créer un login simple (ex. "prenom+id") ou champ "login" distinct
    $newId = count($data['users']) + 1;
    $newLogin = "user$newId"; // par ex. (tu peux demander un champ "login" dans le form)
    
    // 7. Ajouter l’utilisateur
    $nouvelUser = [
        "id" => $newId,
        "login" => $newLogin,
        "password" => $password,
        "role" => "user",  // par défaut "user"
        "nom" => $nom,
        "prenom" => $prenom,
        "email" => $email,
        "dateInscription" => date('Y-m-d')
    ];
    $data['users'][] = $nouvelUser;

    // 8. Sauvegarder
    saveJSON($pathUsers, $data);

    // 9. (Optionnel) Connecter l’utilisateur directement
    $_SESSION['user'] = $nouvelUser;

    // 10. Rediriger
    header('Location: ../profil.html');
    exit;

} else {
    echo "Méthode invalide.";
}
