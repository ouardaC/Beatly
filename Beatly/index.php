<?php
require_once __DIR__ . '/inc/config.inc.php'; 
require_once __DIR__ . '/inc/functions.inc.php';
require_once __DIR__ . '/inc/header.inc.php';

$pageTitle = "Accueil - BEATLY";
$message = "";

// -------------------------
// Gestion des albums à afficher
// -------------------------
if (!empty($_GET)) {
    if (isset($_GET['genre'])) {
        $genre = htmlspecialchars($_GET['genre']);
        $albums = filterAlbumsByGenre($genre);
        $message = "Albums du genre « $genre » :";

        if (empty($albums)) {
            setFlashMessage("Aucun album trouvé dans ce genre.", "warning");
        }
    } elseif (isset($_GET['action']) && $_GET['action'] === 'voirPlus') {
        $albums = getAllAlbums();
        $message = "Tous nos albums :";
    }
} else {
    $albums = getRecentAlbums(6);
    $message = "Derniers albums ajoutés :";
}

$stats = getAlbumStats();
?>

<!-- ------------------------- Hero section ------------------------- -->
<section class="bg-dark text-white py-5">
    <div class="container text-center">
        <h1 class="display-4"><?= SITE_NAME ?> – Parce que la musique, ça se partage</h1>
        <p class="lead">
            Découvrez notre collection de 
            <?= $stats['total_albums'] ?? 0 ?> albums dans 
            <?= $stats['total_genres'] ?? 0 ?> genres différents.
        </p>
        <a href="albums.php" class="btn btn-primary btn-lg mt-3">
            <i class="fas fa-music"></i> Explorer la collection
        </a>
    </div>
</section>

<!-- ------------------------- Message de section ------------------------- -->
<div class="container text-center my-4">
    <h2><?= htmlspecialchars($message) ?></h2>
</div>

<!-- ------------------------- Grille d'albums ------------------------- -->
<div class="container pb-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!empty($albums)): ?>
            <?php foreach ($albums as $album): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img 
                            src="<?= htmlspecialchars($album['image_url'] ?? 'assets/img/default.jpg') ?>" 
                            class="card-img-top" 
                            alt="<?= htmlspecialchars($album['title'] ?? 'Album') ?>"
                        >
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title text-white"><?= htmlspecialchars($album['title'] ?? 'Titre inconnu') ?></h5>
                            <p class="card-text text-white"><?= htmlspecialchars($album['artist'] ?? 'Artiste inconnu') ?></p>
                            <a 
                                href="<?= RACINE_SITE ?>album_detail.php?id_albums=<?= urlencode($album['id']) ?>" 
                                class="btn btn-outline-primary mt-2"
                            >
                                <i class="fas fa-info-circle"></i> Voir Détails
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Aucun album à afficher pour le moment.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/inc/footer.inc.php'; ?>
