<?php
require_once __DIR__ . '/inc/config.inc.php';
require_once __DIR__ . '/inc/functions.inc.php';

// Redirection si non connecté
if (empty($_SESSION['user']['id'])) {
    setFlashMessage("Vous devez être connecté pour accéder à cette page.", "danger");
    header("Location: connexion.php");
    exit;
}

// Récupère les infos de l'utilisateur connecté
$user = getUserById($_SESSION['user']['id']);
$info = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['pseudo'] ?? '');

    if (empty($newUsername)) {
        $info = alert("Le pseudo ne peut pas être vide", "danger");
    } else {
        $avatarFilename = $user['profile_picture'] ?? 'default.jpg';

        // Gestion upload avatar si fourni
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
            // Mise à jour en BDD
            $stmt = $pdo->prepare("UPDATE users SET username = :username, profile_picture = :profile_picture WHERE id = :id");
            $stmt->execute([
                'username' => $newUsername,
                'profile_picture' => $avatarFilename,
                'id' => $user['id'],
            ]);

            // Mettre à jour la session
            $_SESSION['user']['username'] = $newUsername;
            $_SESSION['user']['profile_picture'] = $avatarFilename;

            setFlashMessage("Profil mis à jour avec succès", "success");
            header('Location: profil.php');
            exit;
        }
    }
}

require_once __DIR__ . '/inc/header.inc.php';
?>

<h2 class="text-center text-white mb-4">Mon profil</h2>

<div class="card bg-dark text-white mx-auto" style="max-width: 400px;">
    <div class="card-body text-center d-flex flex-column align-items-center justify-content-center p-4">
        <img src="assets/img/avatars/<?= htmlspecialchars($user['profile_picture'] ?? 'default.jpg') ?>"  class="rounded-circle me-2" width="102" height="100" style="object-fit: cover;" <?= htmlspecialchars($user['username']) ?>">
        
        <?= $info ?>

        <form method="POST" enctype="multipart/form-data" class="w-100">
            <div class="mb-3 text-start">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>

            <div class="mb-3 text-start">
                <label for="avatar" class="form-label">Changer la photo de profil</label>
                <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
        </form>

        <form method="post" action="logout.php" class="mt-3 w-100">
            <button type="submit" class="btn btn-danger w-100">Se déconnecter</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/inc/footer.inc.php'; ?>
