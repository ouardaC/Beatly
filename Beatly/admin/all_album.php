<?php
// On récupère les fichiers dont on a besoin
require_once '../inc/functions.inc.php';
require_once '../inc/header.inc.php';

// Si pas admin, on accède pas à cette page ( réservé aux admins seulement)
if (!isAdmin()) {
    header('Location: ../index.php');
    exit;
}

// Variables pour stocker les messages et l'id de modif
$message = '';     // Pour afficher les messages succès/erreur
$editId = null;    // Pour savoir quel album on modifie ( elle est nul car on a selectionné aucun album 
// par contre si on selectionne un album pour le modifier alors il y aura un id et on le modifie  )

// 🔧 GESTION DE L'ÉDITION D'ALBUM
if (isset($_GET['edit_id'])) {
    $editId = (int)$_GET['edit_id'];
}

// On check si on a envoyé le formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    // On récupère toutes les données du form et on nettoie
    $editId = (int)$_POST['edit_id'];
    $title = trim($_POST['title'] ?? ''); 
    $artist = trim($_POST['artist'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    $year = (int)($_POST['year'] ?? 0); // le 0 c'est car convertit l'année en nombre et les "" c'est si c'est vide
    $description = trim($_POST['description'] ?? '');
    $spotify_link = trim($_POST['spotify_link'] ?? '');
    $youtube_link = trim($_POST['youtube_link'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');
    
    // On vérifie que titre et (&& = ET ) artiste sont bien remplis
    if ($title && $artist) {
        // On essaie de mettre à jour l'album
        if (updateAlbum($editId, $title, $artist, $genre, $year, $description, $spotify_link, $youtube_link, $image_url)) {
            $message = "<div class='alert alert-success'>Album mis à jour avec succès.</div>";// Si oui, on affiche ça 
            $editId = null;  // là on sort de l'edition ( enfin de la modif)
        } else {
            $message = "<div class='alert alert-danger'>Erreur lors de la mise à jour de l'album.</div>";// Sinon on affiche ça 
        }
    } else {
        $message = "<div class='alert alert-warning'>Le titre et l'artiste sont obligatoires.</div>";//  si on manque des infos ()
    }
}

// Si on veut supprimer un album
if (isset($_GET['delete_id'])) { // SI la variable 'delete_id' EXISTE dans l'URL
    // DONC quelqu'un a cliqué sur un lien de suppression
    // alors on peut traiter la demande de suppression
    $deleteId = (int)$_GET['delete_id'];
    if ($deleteId > 0) { // on vérifie que l'id est valide ( 0 c'est le min )
        if (deleteAlbum($deleteId)) {
            $message = "<div class='alert alert-success'>Album supprimé avec succès.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Erreur lors de la suppression de l'album.</div>";
        }
    }
}

// On récupère tous les albums pour les afficher
$albums = getAllAlbums();
?>

<div class="container py-5">
    <h1 class="mb-4 text-center">Gestion des albums</h1>
    <?= $message ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Artiste</th>
                    <th>Genre</th>
                    <th>Année</th>
                    <th>Description</th>
                    <th>Spotify</th>
                    <th>YouTube</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($albums as $album): ?>
                <?php if ($editId === (int)$album['id']): ?>
                    <!-- 🔧 MODE ÉDITION -->
                    <tr class="table-warning">
                        <form method="POST" action="">
                            <td>
                                <strong><?= (int)$album['id'] ?></strong>
                                <input type="hidden" name="edit_id" value="<?= (int)$album['id'] ?>">
                            </td>
                            <td><input type="text" name="title" value="<?= htmlspecialchars($album['title']) ?>" class="form-control form-control-sm" required></td>
                            <td><input type="text" name="artist" value="<?= htmlspecialchars($album['artist']) ?>" class="form-control form-control-sm" required></td>
                            <td><input type="text" name="genre" value="<?= htmlspecialchars($album['genre']) ?>" class="form-control form-control-sm"></td>
                            <td><input type="number" name="year" value="<?= htmlspecialchars($album['year']) ?>" class="form-control form-control-sm" min="1900" max="<?= date('Y') ?>"></td>
                            <td><textarea name="description" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($album['description'] ?? '') ?></textarea></td>
                            <td><input type="text" name="spotify_link" value="<?= htmlspecialchars($album['spotify_link'] ?? '') ?>" class="form-control form-control-sm" placeholder="https://open.spotify.com/..."></td>
                            <td><input type="text" name="youtube_link" value="<?= htmlspecialchars($album['youtube_link'] ?? '') ?>" class="form-control form-control-sm" placeholder="https://youtube.com/..."></td>
                            <td>
                                <input type="text" name="image_url" value="<?= htmlspecialchars($album['image_url'] ?? '') ?>" class="form-control form-control-sm mb-2" placeholder="URL de l'image">
                                <img src="<?= RACINE_SITE ?><?= htmlspecialchars($album['image_url'] ?: 'assets/img/default.jpg') ?>" 
                                     alt="Image de <?= htmlspecialchars($album['title']) ?>" 
                                     class="img-thumbnail"
                                     style="height: 60px; width: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success btn-sm mb-1 w-100">
                                    <i class="fas fa-check"></i> Sauvegarder
                                </button>
                                <a href="?" class="btn btn-secondary btn-sm w-100">
                                    <i class="fas fa-times"></i> Annuler
                                </a>
                            </td>
                        </form>
                    </tr>
                <?php else: ?>
                    <!-- 👁️ MODE LECTURE -->
                    <tr>
                        <td><strong><?= (int)$album['id'] ?></strong></td>
                        <td><?= htmlspecialchars($album['title']) ?></td>
                        <td><?= htmlspecialchars($album['artist']) ?></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($album['genre']) ?></span></td>
                        <td><?= htmlspecialchars($album['year']) ?></td>
                        <td>
                            <?php if (!empty($album['description'])): ?>
                                <small><?= htmlspecialchars(substr($album['description'], 0, 50)) ?>...</small>
                            <?php else: ?>
                                <em class="text-muted">Aucune description</em>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($album['spotify_link'])): ?>
                                <a href="<?= htmlspecialchars($album['spotify_link']) ?>" target="_blank" class="btn btn-success btn-sm">
                                    <i class="fab fa-spotify"></i>
                                </a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($album['youtube_link'])): ?>
                                <a href="<?= htmlspecialchars($album['youtube_link']) ?>" target="_blank" class="btn btn-danger btn-sm">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <img src="<?= RACINE_SITE ?><?= htmlspecialchars($album['image_url'] ?: 'assets/img/default.jpg') ?>" 
                                 alt="Image de <?= htmlspecialchars($album['title']) ?>" 
                                 class="img-thumbnail"
                                 style="height: 60px; width: 60px; object-fit: cover;">
                        </td>
                        <td>
                            <a href="?edit_id=<?= (int)$album['id'] ?>" class="btn btn-warning btn-sm mb-1 w-100">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <a href="?delete_id=<?= (int)$album['id'] ?>" 
                               class="btn btn-danger btn-sm w-100" 
                               onclick="return confirm('⚠️ ATTENTION !\n\nÊtes-vous sûr de vouloir supprimer l\'album :\n\"<?= htmlspecialchars($album['title']) ?>\" de <?= htmlspecialchars($album['artist']) ?> ?\n\n❌ Cette action est IRRÉVERSIBLE !');">
                                <i class="fas fa-trash"></i> Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../inc/footer.inc.php'; ?>