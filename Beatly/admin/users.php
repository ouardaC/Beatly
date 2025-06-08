<?php
require_once '../inc/config.inc.php';
require_once '../inc/functions.inc.php';

// Verify admin access
if (!isAdmin()) {
    setFlashMessage("Accès non autorisé.", "danger");
    header('Location: ' . RACINE_SITE . 'index.php');
    exit;
}

// Handle user actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['user_id'])) {
        $userId = (int)$_POST['user_id'];
        
        switch ($_POST['action']) {
            case 'toggle_admin':
                $currentRole = $_POST['current_role'] ?? '';
                $newRole = ($currentRole === 'admin') ? 'user' : 'admin';
                
                $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
                if ($stmt->execute([$newRole, $userId])) {
                    $info = alert("Rôle mis à jour avec succès.", "success");
                } else {
                    $info = alert("Erreur lors de la mise à jour du rôle.", "danger");
                }
                break;
                
            case 'delete':
                if ($userId !== $_SESSION['user']['id']) {
                    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
                    if ($stmt->execute([$userId])) {
                        $info = alert("Utilisateur supprimé avec succès.", "success");
                    } else {
                        $info = alert("Erreur lors de la suppression.", "danger");
                    }
                } else {
                    $info = alert("Vous ne pouvez pas supprimer votre propre compte.", "danger");
                }
                break;
        }
    }
}

// Get all users
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Gestion des utilisateurs - " . SITE_NAME;
require_once '../inc/header.inc.php';
?>

<div class="container mt-4">
    <h1 class="mb-4">
        <i class="fas fa-users-cog"></i>
        Gestion des utilisateurs
    </h1>

    <?php if (isset($info)) echo $info; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Avatar</th>
                            <th>Pseudo</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td>
                                <img src="<?= RACINE_SITE ?>assets/img/avatars/<?= htmlspecialchars($user['profile_picture'] ?? 'default.jpg') ?>" 
                                     alt="Avatar" 
                                     class="rounded-circle"
                                     width="40" 
                                     height="40"
                                     style="object-fit: cover;">
                            </td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'primary' ?>">
                                    <?= htmlspecialchars($user['role']) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                            <td>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <input type="hidden" name="current_role" value="<?= $user['role'] ?>">
                                    
                                    <?php if ($user['id'] !== $_SESSION['user']['id']): ?>
                                        <button type="submit" 
                                                name="action" 
                                                value="toggle_admin" 
                                                class="btn btn-sm btn-warning">
                                            <i class="fas fa-user-shield"></i>
                                            <?= $user['role'] === 'admin' ? 'Rétrograder' : 'Promouvoir admin' ?>
                                        </button>
                                        
                                        <button type="submit" 
                                                name="action" 
                                                value="delete" 
                                                class="btn btn-sm btn-danger">
                                            <i class="fas fa-user-times"></i>
                                            Supprimer
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require '../inc/footer.inc.php'; ?>
