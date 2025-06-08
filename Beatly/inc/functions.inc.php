<?php
require_once __DIR__ . '/config.inc.php';

/**
 * Fonction de debug simplifiée
 */
function debug($var): void {
    echo '<pre class="border border-dark bg-light text-danger fw-bold w-50 p-5 mt-5">';
    var_dump($var);
    echo '</pre>';
}

/*
 * -------------------------
 * UTILISATEURS (users)
 * -------------------------
 */

function addUser(string $username, string $email, string $password, string $role = 'user', ?string $profile_picture = null): bool {
    global $pdo;
    $data = [
        'username' => htmlspecialchars($username, ENT_QUOTES, 'UTF-8'),
        'email' => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
        'password' => $password,
        'role' => $role,
        'profile_picture' => $profile_picture
    ];
    $sql = "INSERT INTO users (username, email, password, role, profile_picture)
            VALUES (:username, :email, :password, :role, :profile_picture)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function getUserById(int $id): ?array {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function getUserByEmailOrUsername(string $identifier): ?array {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :identifier OR username = :identifier");
    $stmt->execute(['identifier' => $identifier]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function checkEmailUser(string $email): bool {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetchColumn() > 0;
}

function checkPseudoUser(string $username): bool {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    return $stmt->fetchColumn() > 0;
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function isAdmin(): bool {
    return isset($_SESSION['user']) && 
           isset($_SESSION['user']['role']) && 
           $_SESSION['user']['role'] === 'admin';
}

/*
 * -------------------------
 * ALBUMS
 * -------------------------
 */

function addAlbum(string $title, string $artist, string $genre, ?int $year, ?string $description, ?string $spotify_link, ?string $youtube_link, ?string $image_url, ?int $user_id): bool {
    global $pdo;
    $data = [
        'title' => htmlspecialchars($title, ENT_QUOTES, 'UTF-8'),
        'artist' => htmlspecialchars($artist, ENT_QUOTES, 'UTF-8'),
        'genre' => htmlspecialchars($genre, ENT_QUOTES, 'UTF-8'),
        'year' => $year,
        'description' => htmlspecialchars($description ?? '', ENT_QUOTES, 'UTF-8'),
        'spotify_link' => $spotify_link,
        'youtube_link' => $youtube_link,
        'image_url' => $image_url,
        'user_id' => $user_id
    ];
    $sql = "INSERT INTO albums (title, artist, genre, year, description, spotify_link, youtube_link, image_url, user_id)
            VALUES (:title, :artist, :genre, :year, :description, :spotify_link, :youtube_link, :image_url, :user_id)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function getAlbumById(int $id): ?array {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM albums WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function updateAlbum(int $id, string $title, string $artist, string $genre, ?int $year, ?string $description, ?string $spotify_link, ?string $youtube_link, ?string $image_url): bool {
    global $pdo;
    $data = [
        'id' => $id,
        'title' => htmlspecialchars($title, ENT_QUOTES, 'UTF-8'),
        'artist' => htmlspecialchars($artist, ENT_QUOTES, 'UTF-8'),
        'genre' => htmlspecialchars($genre, ENT_QUOTES, 'UTF-8'),
        'year' => $year,
        'description' => htmlspecialchars($description ?? '', ENT_QUOTES, 'UTF-8'),
        'spotify_link' => $spotify_link,
        'youtube_link' => $youtube_link,
        'image_url' => $image_url
    ];
    $sql = "UPDATE albums SET title = :title, artist = :artist, genre = :genre, year = :year,
            description = :description, spotify_link = :spotify_link,
            youtube_link = :youtube_link, image_url = :image_url WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function deleteAlbum(int $id): bool {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM albums WHERE id = :id");
    return $stmt->execute(['id' => $id]);
}

function getAllAlbums(): array {
    global $pdo;
    $result = $pdo->query("SELECT * FROM albums ORDER BY created_at DESC");
    return $result ? $result->fetchAll(PDO::FETCH_ASSOC) : [];
}

function getRecentAlbums(int $limit = 6): array {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM albums ORDER BY created_at DESC LIMIT :limit");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getAlbumStats (): array {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) AS total_albums, COUNT(DISTINCT genre) AS total_genres FROM albums");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllGenres(): array {
    global $pdo;
    $stmt = $pdo->query("SELECT DISTINCT genre FROM albums ORDER BY genre");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function getAllArtists(): array {
    global $pdo;
    $stmt = $pdo->query("SELECT DISTINCT artist FROM albums ORDER BY artist");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function searchAndFilterAlbums(string $search = '', string $genre = '', string $artist = ''): array {
    global $pdo;
    $sql = "SELECT * FROM albums WHERE 1=1";
    $params = [];

    if ($search) {
        $sql .= " AND (title LIKE :search OR artist LIKE :search)";
        $params['search'] = '%' . htmlspecialchars($search, ENT_QUOTES, 'UTF-8') . '%';
    }
    if ($genre) {
        $sql .= " AND genre = :genre";
        $params['genre'] = htmlspecialchars($genre, ENT_QUOTES, 'UTF-8');
    }
    if ($artist) {
        $sql .= " AND artist = :artist";
        $params['artist'] = htmlspecialchars($artist, ENT_QUOTES, 'UTF-8');
    }

    $sql .= " ORDER BY created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
 * -------------------------
 * IMAGE UPLOAD ALBUMS 
 * -------------------------
 */

function uploadImage($file, $destination_folder) {
    // Vérification du type de fichier
    $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!in_array($file['type'], $allowed)) {
        return ['error' => 'Format non autorisé (JPG, PNG ou JPEG uniquement)'];
    }

    // Création du dossier si nécessaire
    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755, true);
    }

    // Génération d'un nom unique
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $destination = $destination_folder . $filename;

    // Upload du fichier
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return ['url' => 'assets/img/' . $filename];
    }

    return ['error' => "Erreur lors de l'upload"];
}


/*
 * -------------------------
 * REVIEWS
 * -------------------------
 */

function getAlbumReviews(int $album_id): array {
    global $pdo;
    $sql = "SELECT r.user_id, u.username, u.profile_picture, r.rating, r.comment, r.created_at
            FROM reviews r
            INNER JOIN users u ON r.user_id = u.id
            WHERE r.album_id = :album_id
            ORDER BY r.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['album_id' => $album_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addReview(int $user_id, int $album_id, int $rating, string $comment): bool {
    global $pdo;
    $sql = "INSERT INTO reviews (user_id, album_id, rating, comment, created_at)
            VALUES (:user_id, :album_id, :rating, :comment, NOW())";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'user_id' => $user_id,
        'album_id' => $album_id,
        'rating' => $rating,
        'comment' => $comment
    ]);
}

function userHasReviewed(int $album_id, int $user_id): bool {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM reviews WHERE album_id = :album_id AND user_id = :user_id");
    $stmt->execute([
        'album_id' => $album_id,
        'user_id' => $user_id
    ]);
    return $stmt->fetchColumn() > 0;
}

function updateReview(int $user_id, int $album_id, int $rating, string $comment): bool {
    global $pdo;
    $sql = "UPDATE reviews SET rating = :rating, comment = :comment WHERE user_id = :user_id AND album_id = :album_id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'rating' => $rating,
        'comment' => $comment,
        'user_id' => $user_id,
        'album_id' => $album_id
    ]);
}

/*
 * -------------------------
 * FLASH MESSAGES
 * -------------------------
 */

function setFlashMessage(string $message, string $type = 'info'): void {
    if (!isset($_SESSION['flash_messages'])) {
        $_SESSION['flash_messages'] = [];
    }
    $_SESSION['flash_messages'][] = ['message' => $message, 'type' => $type];
}

function getFlashMessages(): array {
    if (!isset($_SESSION['flash_messages'])) {
        return [];
    }
    $messages = $_SESSION['flash_messages'];
    unset($_SESSION['flash_messages']);
    return $messages;
}

function displayFlashMessages(): void {
    foreach (getFlashMessages() as $flash) {
        $type = htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8');
        $msg = htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8');
        echo "<div class='alert alert-$type' role='alert'>$msg</div>";
    }
}


/*
 * -------------------------
 * ADMIN LISTE UTILISATEURS
 * -------------------------
 */

 function getAllUsers() {
    global $pdo; // ou ta variable PDO
    $stmt = $pdo->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

