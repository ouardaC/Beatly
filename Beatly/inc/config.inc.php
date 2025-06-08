<?php
// -------------------------
// Chargement automatique des classes si besoin (ex: avec Composer)
// -------------------------
// require 'vendor/autoload.php'; // si tu utilises un autoloader

// -------------------------
// Démarrage de la session
// -------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// -------------------------
// Constantes de configuration
// -------------------------
define("SITE_NAME", "BEATLY");
define("RACINE_SITE", "http://localhost/beatly/");
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DBNAME", "Beatly");

// -------------------------
// Fonction d'alerte Bootstrap
// -------------------------
function alert(string $contenu, string $class = 'info'): string
{
    return <<<HTML
<div class="alert alert-{$class} alert-dismissible fade show text-center w-50 m-auto mb-5" role="alert">
    {$contenu}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
HTML;
}

// // -------------------------
// // Fonction de debug
// // -------------------------
// function debug(mixed $var): void
// {
//     echo '<pre class="border border-dark bg-light text-danger fw-bold w-50 p-5 mt-5">';
//     var_dump($var);
//     echo '</pre>';
// }

// -------------------------
// Déconnexion utilisateur
// -------------------------
if (!empty($_GET['action']) && $_GET['action'] === 'deconnexion') {
    unset($_SESSION['user_id']);
    header('Location: ' . RACINE_SITE . 'index.php');
    exit;
}



function connexionBdd(): PDO
{
    $dsn = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME . ';charset=utf8mb4';
    try {
        $pdo = new PDO($dsn, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        die('Erreur de connexion : ' . $e->getMessage());
    }
}

// -------------------------
// Connexion globale
// -------------------------
$pdo = connexionBdd();
