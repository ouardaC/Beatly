<?php
require_once __DIR__ . '/../inc/config.inc.php';
require_once __DIR__ . '/../inc/functions.inc.php';
$pageTitle = "Ajouter un album - " . SITE_NAME;

// Redirection si non connecté ou non admin
if (!isLoggedIn() || !isAdmin()) {
    header('Location: index.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $artist = trim($_POST['artist'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    $year = (int)($_POST['year'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $spotify_link = trim($_POST['spotify_link'] ?? '');
    $youtube_link = trim($_POST['youtube_link'] ?? '');
    $user_id = $_SESSION['user_id'];

    $image_url = null;
    $uploadDir = __DIR__ . '/../assets/img/';

    // Choix d'une image existante
    if (!empty($_POST['existing_image'])) {
        $safePath = realpath(__DIR__ . '/../' . $_POST['existing_image']);
        $allowedDir = realpath($uploadDir);
        if ($safePath && strpos($safePath, $allowedDir) === 0 && is_file($safePath)) {
            $image_url = $_POST['existing_image'];
        } else {
            $errors[] = "Image existante invalide.";
        }
    }
    // Sinon, upload d'une nouvelle image
    elseif (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $tmpName = $_FILES['image_url']['tmp_name'];
        $originalName = basename($_FILES['image_url']['name']);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png'];
        if (!in_array($ext, $allowed)) {
            $errors[] = "Format d'image non supporté (jpg, jpeg, png autorisés.)";
        } else {
            $fileHash = sha1_file($tmpName);
            $newName = 'album_' . $fileHash . '.' . $ext;
            $destination = $uploadDir . $newName;

            // Vérifier si le fichier existe déjà (même contenu)
            if (file_exists($destination)) {
                // Le fichier existe déjà, on utilise l'existant
                $image_url = 'assets/img/' . $newName;
            } else {
                // Nouveau fichier, on l'upload
                if (move_uploaded_file($tmpName, $destination)) {
                    $image_url = 'assets/img/' . $newName;
                } else {
                    $errors[] = "Erreur lors de l'upload de l'image.";
                }
            }
        }
    }

    // Validation
    if (!$title) $errors[] = "Le titre est obligatoire.";
    if (!$artist) $errors[] = "L'artiste est obligatoire.";

    // Insertion
    if (empty($errors)) {
        if (addAlbum(
            $title,
            $artist,
            $genre ?: null,
            $year ?: null,
            $description ?: null,
            $spotify_link ?: null,
            $youtube_link ?: null,
            $image_url,
            $user_id
        )) {
            header('Location: ' . RACINE_SITE . 'albums.php');
            exit;
        } else {
            $errors[] = "Erreur lors de l'ajout de l'album.";
        }
    }
}

// Fonction pour obtenir les images avec preview et infos
function getImagesWithInfo($imgDir) {
    $images = [];
    $imgFiles = array_diff(scandir($imgDir), ['.', '..']);
    
    foreach ($imgFiles as $img) {
        $fullPath = $imgDir . $img;
        $relativePath = 'assets/img/' . $img;
        
        if (is_file($fullPath) && in_array(strtolower(pathinfo($img, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'])) {
            $images[] = [
                'name' => $img,
                'path' => $relativePath,
                'size' => filesize($fullPath),
                'date' => filemtime($fullPath)
            ];
        }
    }
    
    // Trier par date de modification (plus récent en premier)
    usort($images, function($a, $b) {
        return $b['date'] - $a['date'];
    });
    
    return $images;
}

require_once __DIR__ . '/../inc/header.inc.php';
?>

<h1 class="mb-4">Ajouter un album</h1>

<?php if ($errors): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
        <input 
            type="text" 
            id="title" 
            name="title" 
            class="form-control" 
            value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" 
            required
        >
        <div class="invalid-feedback">Le titre est obligatoire.</div>
    </div>

    <div class="mb-3">
        <label for="artist" class="form-label">Artiste <span class="text-danger">*</span></label>
        <input 
            type="text" 
            id="artist" 
            name="artist" 
            class="form-control" 
            value="<?= htmlspecialchars($_POST['artist'] ?? '') ?>" 
            required
        >
        <div class="invalid-feedback">L'artiste est obligatoire.</div>
    </div>

    <div class="mb-3">
        <label for="genre" class="form-label">Genre</label>
        <input 
            type="text" 
            id="genre" 
            name="genre" 
            class="form-control" 
            value="<?= htmlspecialchars($_POST['genre'] ?? '') ?>"
        >
    </div>

    <div class="mb-3">
        <label for="year" class="form-label">Année</label>
        <input 
            type="number" 
            id="year" 
            name="year" 
            class="form-control" 
            value="<?= htmlspecialchars($_POST['year'] ?? '') ?>"
            min="1900" max="<?= date('Y') ?>"
        >
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea 
            id="description" 
            name="description" 
            class="form-control" 
            rows="4"
        ><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
        <label for="spotify_link" class="form-label">Spotify Link</label>
        <input 
            type="url" 
            id="spotify_link" 
            name="spotify_link" 
            class="form-control" 
            value="<?= htmlspecialchars($_POST['spotify_link'] ?? '') ?>"
        >
    </div>

    <div class="mb-3">
        <label for="youtube_link" class="form-label">YouTube Link</label>
        <input 
            type="url" 
            id="youtube_link" 
            name="youtube_link" 
            class="form-control" 
            value="<?= htmlspecialchars($_POST['youtube_link'] ?? '') ?>"
        >
    </div>

    <!-- Section améliorée pour les images -->
    <div class="mb-4">
        <h5>Image de l'album</h5>
        
        <!-- Onglets pour choisir entre existante ou nouvelle -->
        <ul class="nav nav-tabs" id="imageTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="existing-tab" data-bs-toggle="tab" data-bs-target="#existing" type="button" role="tab">
                    Images existantes
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab">
                    Uploader nouvelle image
                </button>
            </li>
        </ul>

        <div class="tab-content" id="imageTabContent">
            <!-- Images existantes avec preview -->
            <div class="tab-pane fade show active" id="existing" role="tabpanel">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="existing_image" class="form-label">Choisir une image existante</label>
                            <select name="existing_image" id="existing_image" class="form-control" onchange="previewExistingImage()">
                                <option value="">-- Aucune --</option>
                                <?php
                                $imgDir = __DIR__ . '/../assets/img/';
                                $images = getImagesWithInfo($imgDir);
                                foreach ($images as $img) {
                                    $selected = (($_POST['existing_image'] ?? '') === $img['path']) ? 'selected' : '';
                                    $sizeKB = round($img['size'] / 1024, 1);
                                    $date = date('d/m/Y H:i', $img['date']);
                                    echo '<option value="' . htmlspecialchars($img['path']) . '" ' . $selected . '>' 
                                         . htmlspecialchars($img['name']) . ' (' . $sizeKB . ' KB - ' . $date . ')</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Prévisualisation</label>
                            <div id="existing_preview" class="border rounded p-2" style="height: 150px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                <span class="text-muted">Sélectionnez une image pour la prévisualiser</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload nouvelle image -->
            <div class="tab-pane fade" id="upload" role="tabpanel">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="image_url" class="form-label">Uploader une nouvelle image</label>
                            <input 
                                type="file" 
                                id="image_url" 
                                name="image_url" 
                                class="form-control" 
                                accept=".jpg,.jpeg,.png"
                                onchange="previewNewImage()"
                            >
                            <div class="form-text">Formats acceptés : jpg, jpeg, png</div>
                            <small class="text-info">
                                <i class="fas fa-info-circle"></i> 
                                Les doublons sont automatiquement détectés et évités.
                            </small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Prévisualisation</label>
                            <div id="upload_preview" class="border rounded p-2" style="height: 150px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                <span class="text-muted">Choisissez une image pour la prévisualiser</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Ajouter l'album</button>
</form>



 <!-- Script pour la prévisualisation des images ( ça cause d'un souci de doublon d'image apres avoir submit les albums)-->
<script>
// Prévisualisation image existante
function previewExistingImage() {
    const select = document.getElementById('existing_image');
    const preview = document.getElementById('existing_preview');
    
    if (select.value) {
        preview.innerHTML = `<img src="<?= RACINE_SITE ?>${select.value}" alt="Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">`;
    } else {
        preview.innerHTML = '<span class="text-muted">Sélectionnez une image pour la prévisualiser</span>';
    }
}

// Prévisualisation nouvelle image
function previewNewImage() {
    const input = document.getElementById('image_url');
    const preview = document.getElementById('upload_preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">`;
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.innerHTML = '<span class="text-muted">Choisissez une image pour la prévisualiser</span>';
    }
}

// Gérer l'exclusion mutuelle des deux options
document.getElementById('existing_image').addEventListener('change', function() {
    if (this.value) {
        document.getElementById('image_url').value = '';
        document.getElementById('upload_preview').innerHTML = '<span class="text-muted">Choisissez une image pour la prévisualiser</span>';
    }
});

document.getElementById('image_url').addEventListener('change', function() {
    if (this.files.length > 0) {
        document.getElementById('existing_image').value = '';
        document.getElementById('existing_preview').innerHTML = '<span class="text-muted">Sélectionnez une image pour la prévisualiser</span>';
    }
});
</script>

<?php require_once __DIR__ . '/../inc/footer.inc.php'; ?>