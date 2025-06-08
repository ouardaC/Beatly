<?php
require_once 'inc/config.inc.php';
require_once 'inc/functions.inc.php';

$album_id = (int)($_GET['id_albums'] ?? 0);
if ($album_id <= 0) {
    header('Location: albums.php');
    exit;
}

$album = getAlbumById($album_id);
if (!$album) {
    header('Location: albums.php?error=not_found');
    exit;
}

$reviews = getAlbumReviews($album_id);
$review_success = '';
$review_errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
        $rating = (int)($_POST['rating'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');

        if ($rating >= 1 && $rating <= 5 && !empty($comment)) {
            if (userHasReviewed($album_id, $user_id)) {
                updateReview($user_id, $album_id, $rating, $comment);
                $review_success = "Votre avis a été modifié.";
            } else {
                addReview($user_id, $album_id, $rating, $comment);
                $review_success = "Merci pour votre avis !";
            }
            $reviews = getAlbumReviews($album_id); // rafraîchir la liste
        } else {
            $review_errors[] = "Veuillez remplir correctement tous les champs.";
        }
    }
}

include 'inc/header.inc.php';
?>

<div class="container my-5">
    <div class="card bg-dark text-white p-4 mb-5 d-flex flex-row align-items-center gap-4">
        <div style="flex: 0 0 200px;">
            <img src="<?= htmlspecialchars($album['image_url'] ?? 'assets/img/default.jpg') ?>"
                 alt="<?= htmlspecialchars($album['title']) ?>" 
                 class="img-fluid rounded" 
                 style="max-height: 200px; object-fit: cover;">
        </div>
        <div style="flex: 1;">
            <h1><?= htmlspecialchars($album['title']) ?></h1>
            <h3><?= htmlspecialchars($album['artist']) ?></h3>
            <h4><?= htmlspecialchars($album['year']) ?></h4>
            <p><?= nl2br(htmlspecialchars($album['description'])) ?></p>

            <?php if (!empty($album['spotify_link'])): ?>
                <a href="<?= htmlspecialchars($album['spotify_link']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-success me-2 mb-2">
                    Écouter sur Spotify
                </a>
            <?php endif; ?>

            <?php if (!empty($album['youtube_link'])): ?>
                <a href="<?= htmlspecialchars($album['youtube_link']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-danger mb-2">
                    Voir sur YouTube
                </a>
            <?php endif; ?>
        </div>
    </div>

    <h2 class="text-white">Avis</h2>

    <?php if ($review_success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($review_success) ?></div>
    <?php endif; ?>

    <?php foreach ($reviews as $review): ?>
        <div class="card mb-4 bg-secondary text-white p-3">
            <div class="d-flex align-items-center mb-2">
                <img src="<?= RACINE_SITE ?>assets/img/avatars/<?= htmlspecialchars($review['profile_picture'] ?? 'default.jpg') ?>" 
                     alt="Avatar de <?= htmlspecialchars($review['username']) ?>" 
                     class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                <h5 class="mb-0"><?= htmlspecialchars($review['username']) ?></h5>
            </div>

            <div class="text-warning mb-2">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <?= $i <= $review['rating'] ? '★' : '☆' ?>
                <?php endfor; ?>
            </div>

            <!-- Affichage du commentaire -->
            <p id="comment-display-<?= $review['user_id'] ?>"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>

            <!-- Formulaire d'édition caché pour l'utilisateur -->
            <?php if (isLoggedIn() && $_SESSION['user_id'] == $review['user_id']): ?>
                <form method="post" id="edit-form-<?= $review['user_id'] ?>" class="d-none">
                    <div class="mb-2">
                        <label for="rating">Note :</label>
                        <select name="rating" class="form-select w-auto d-inline-block">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option value="<?= $i ?>" <?= $review['rating'] == $i ? 'selected' : '' ?>><?= $i ?> étoile<?= $i > 1 ? 's' : '' ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <textarea name="comment" class="form-control mb-2"><?= htmlspecialchars($review['comment']) ?></textarea>
                    <button type="submit" class="btn btn-success btn-sm">Enregistrer</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="cancelEdit(<?= $review['user_id'] ?>)">Annuler</button>
                </form>

                <button class="btn btn-outline-light btn-sm mt-2" onclick="editReview(<?= $review['user_id'] ?>)">✏ Modifier mon avis</button>
            <?php endif; ?>

            <small class="text-light"><?= htmlspecialchars($review['created_at']) ?></small>
        </div>
    <?php endforeach; ?>

    <!-- Formulaire pour laisser un nouvel avis -->
    <?php if (isLoggedIn() && !userHasReviewed($album_id, $_SESSION['user_id'])): ?>
        <div class="card bg-secondary text-white p-4 mt-5">
            <h3>Laisser un avis</h3>
            <?php if (!empty($review_errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($review_errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="rating">Note</label>
                    <select name="rating" class="form-select w-auto" required>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?> étoile<?= $i > 1 ? 's' : '' ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="comment">Commentaire</label>
                    <textarea name="comment" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    <?php elseif (!isLoggedIn()): ?>
        <p class="text-center text-white mt-4">
            <a href="connexion.php?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="btn btn-outline-light">Connectez-vous pour commenter</a>
        </p>
    <?php endif; ?>
</div>

<script>
function editReview(userId) {
    document.getElementById('comment-display-' + userId).classList.add('d-none');
    document.getElementById('edit-form-' + userId).classList.remove('d-none');
}
function cancelEdit(userId) {
    document.getElementById('edit-form-' + userId).classList.add('d-none');
    document.getElementById('comment-display-' + userId).classList.remove('d-none');
}
</script>

<?php include 'inc/footer.inc.php'; ?>
