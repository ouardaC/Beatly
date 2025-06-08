<?php
$pageTitle = "Connexion - BEATLY";

require_once __DIR__ . '/inc/config.inc.php';
require_once __DIR__ . '/inc/functions.inc.php';

// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$info = "";

// Redirection si déjà connecté (avec user_id)
if (!empty($_SESSION['user_id'])) {
    header('Location: profil.php');
    exit;
}

$email = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $info = alert("Veuillez remplir tous les champs", "danger");

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $info = alert("Adresse e-mail invalide", "danger");

    } else {
        // Requête sécurisée
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Connexion réussie
            unset($user['password']);

            // Stockage en session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user;

            setFlashMessage("Bienvenue " . htmlspecialchars($user['username']) . " !", "success");
            header('Location: profil.php');
            exit;
        } else {
            $info = alert("Email ou mot de passe incorrect", "danger");
        }
    }
}

require_once __DIR__ . '/inc/header.inc.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h1 class="card-title text-center mb-4">Connexion</h1>

                    <?= $info ?>

                    <form method="POST" action="" class="p-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input 
                                type="email" 
                                class="form-control" 
                                id="email" 
                                name="email" 
                                value="<?= htmlspecialchars($email) ?>" 
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password" 
                                name="password" 
                                required
                            >
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Se connecter
                            </button>
                        </div>

                        <p class="text-center mt-3">
                            Pas encore de compte ? <a href="<?= RACINE_SITE ?>register.php">Inscrivez-vous ici</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/inc/footer.inc.php'; ?>
