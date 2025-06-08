<?php
$pageTitle = "Inscription - BEATLY";

require_once __DIR__ . '/inc/config.inc.php';
require_once __DIR__ . '/inc/functions.inc.php';

$info = "";

// Redirection si déjà connecté
if (!empty($_SESSION['user'])) {
    header('Location: profil.php');
    exit;
}

$username = $email = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['pseudo'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    // Validation des champs obligatoires
    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $info = alert("Tous les champs sont obligatoires", "danger");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $info = alert("Adresse e-mail invalide", "danger");
    } elseif ($password !== $confirm) {
        $info = alert("Les mots de passe ne correspondent pas", "danger");
    } else {
        // Vérifie si email ou username déjà utilisé
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email OR username = :username");
        $stmt->execute([
            'email' => $email,
            'username' => $username,
        ]);

        if ($stmt->fetch()) {
            $info = alert("Email ou pseudo déjà utilisé", "danger");
        } else {
            // Traitement upload avatar (optionnel)
            $avatarFilename = 'default.jpg'; // image par défaut

            if (!empty($_FILES['avatar']['name'])) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileTmpPath = $_FILES['avatar']['tmp_name'];
                $fileType = mime_content_type($fileTmpPath);

                if (in_array($fileType, $allowedTypes)) {
                    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                    $avatarFilename = uniqid() . '.' . $ext;
                    move_uploaded_file($fileTmpPath, __DIR__ . '/assets/img/avatars/' . $avatarFilename);
                } else {
                    $info = alert("Le format de la photo doit être jpg, png ou gif.", "danger");
                }
            }

            if (!$info) {
                // Hasher le mot de passe
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insertion en BDD
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, profile_picture) VALUES (:username, :email, :password, :profile_picture)");
                $success = $stmt->execute([
                    'username' => $username,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'profile_picture' => $avatarFilename,
                ]);

                if ($success) {
                    setFlashMessage("Inscription réussie ! Vous pouvez maintenant vous connecter.", "success");
                    header('Location: connexion.php');
                    exit;
                } else {
                    $info = alert("Erreur lors de l'inscription", "danger");
                }
            }
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
                    <h1 class="card-title text-center mb-4">Inscription</h1>

                    <?= $info ?>

                    <form method="POST" action="" enctype="multipart/form-data" class="p-4">
                        <div class="mb-3">
                            <label for="pseudo" class="form-label">Pseudo</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="pseudo" 
                                name="pseudo" 
                                value="<?= htmlspecialchars($username) ?>" 
                                required
                            >
                        </div>

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

                        <div class="mb-3">
                            <label for="confirm" class="form-label">Confirmer le mot de passe</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="confirm" 
                                name="confirm" 
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="avatar" class="form-label">Photo de profil</label>
                            <input 
                                type="file" 
                                class="form-control" 
                                id="avatar" 
                                name="avatar" 
                                accept="image/*"
                                required
                            >
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-user-plus"></i> S'inscrire
                            </button>
                        </div>

                        <p class="text-center mt-3">
                            Déjà inscrit ? <a href="<?= RACINE_SITE ?>connexion.php">Connectez-vous ici</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/inc/footer.inc.php'; ?>

