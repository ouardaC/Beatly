<?php
$pageTitle = "Albums - BEATLY";
require_once 'inc/functions.inc.php';
require_once 'inc/header.inc.php';

// Initialisation des filtres
$search = htmlspecialchars($_GET['search'] ?? '');
$genreFilter = htmlspecialchars($_GET['genre'] ?? '');
$artistFilter = htmlspecialchars($_GET['artist'] ?? '');

// Récupération des options de filtre
$genres = getAllGenres();
$artists = getAllArtists();

// Récupération des albums filtrés
$albums = searchAndFilterAlbums($search, $genreFilter, $artistFilter);
?>

<div class="container py-5">
    <h1 class="text-center mb-4">Catalogue d'albums</h1>

    <!-- Formulaire de recherche et filtres -->
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <input 
                type="text" 
                name="search" 
                value="<?= $search ?>" 
                class="form-control" 
                placeholder="Rechercher un titre ou un artiste"
            >
        </div>
        <div class="col-md-3">
            <select name="genre" class="form-select">
                <option value="">Tous les genres</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= htmlspecialchars($genre) ?>"<?= $genre === $genreFilter ? 'selected' : '' ?>>
                        <?= htmlspecialchars($genre) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <select name="artist" class="form-select">
                <option value="">Tous les artistes</option>
                <?php foreach ($artists as $artist): ?>
                    <option value="<?= htmlspecialchars($artist) ?>" <?= $artist === $artistFilter ? 'selected' : '' ?>>
                        <?= htmlspecialchars($artist) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search"></i> Rechercher
            </button>
        </div>
    </form>

    <!-- Affichage des résultats -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <?php if (!empty($albums)): ?>
            <?php foreach ($albums as $album): ?>
                <div class="col">
                    <div class="card h-100">
                        <img 
                            src="<?= htmlspecialchars($album['image_url'] ?? 'assets/img/default.jpg') ?>" 
                            class="card-img-top" 
                            alt="<?= htmlspecialchars($album['title']) ?>" 
                            onerror="this.onerror=null;this.src='assets/img/default.jpg';"
                        >
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($album['title']) ?></h5>
                            <p class="card-text text-white"><?= htmlspecialchars($album['artist']) ?></p>
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
            <p class="text-center">Aucun album trouvé avec les critères sélectionnés.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'inc/footer.inc.php'; ?>
