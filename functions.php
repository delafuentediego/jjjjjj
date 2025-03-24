<?php
/**
 * Fichier : functions.php
 * Description : Fonctions utilitaires pour la gestion du projet (Phase #2)
 */

/**
 * Charger un fichier JSON et le convertir en tableau associatif
 *
 * @param string $filename Le chemin complet vers le fichier JSON
 * @return array|null      Le tableau associatif, ou null si fichier inexistant
 */
function loadJSON($filename) {
    if (!file_exists($filename)) {
        return null;
    }
    $json = file_get_contents($filename);
    return json_decode($json, true);
}

/**
 * Sauvegarder un tableau associatif dans un fichier JSON
 *
 * @param string $filename Le chemin complet vers le fichier JSON
 * @param array  $data     Les données à encoder en JSON
 * @return void
 */
function saveJSON($filename, $data) {
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents($filename, $json);
}

/**
 * Trouver un utilisateur par login
 *
 * @param string $login  Le login à chercher
 * @param array  $users  Le tableau d’utilisateurs (ex. $data['users'])
 * @return array|null    L’utilisateur trouvé ou null
 */
function findUserByLogin($login, $users) {
    foreach ($users as $u) {
        if (isset($u['login']) && $u['login'] === $login) {
            return $u;
        }
    }
    return null;
}

/**
 * Trouver un utilisateur par email
 *
 * @param string $email  L’email à chercher
 * @param array  $users  Le tableau d’utilisateurs
 * @return array|null    L’utilisateur trouvé ou null
 */
function findUserByEmail($email, $users) {
    foreach ($users as $u) {
        if (isset($u['email']) && $u['email'] === $email) {
            return $u;
        }
    }
    return null;
}

/**
 * Vérifier les identifiants (login ou email) + password
 *
 * @param string $loginOrEmail  Le login ou l’email entré par l’utilisateur
 * @param string $password      Le mot de passe entré
 * @param array  $users         Le tableau d’utilisateurs
 * @return array|null           L’utilisateur trouvé, ou null si échec
 */
function checkCredentials($loginOrEmail, $password, $users) {
    foreach ($users as $u) {
        // Ici on suppose que l’utilisateur peut se connecter
        // soit par "login", soit par "email"
        if (
            (isset($u['login']) && $u['login'] === $loginOrEmail) ||
            (isset($u['email']) && $u['email'] === $loginOrEmail)
        ) {
            // Vérifier mot de passe (ici en clair, sinon password_verify)
            if (isset($u['password']) && $u['password'] === $password) {
                return $u;
            }
        }
    }
    return null;
}

/**
 * Vérifier si l’utilisateur est connecté (session)
 *
 * @return bool
 */
function isLoggedIn() {
    return (isset($_SESSION['user']) && !empty($_SESSION['user']));
}

/**
 * Vérifier si l’utilisateur connecté est admin
 *
 * @return bool
 */
function isAdmin() {
    return (isLoggedIn() && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin');
}

