<?php
$user = isset($_SESSION['user_id']) ? getUserById($_SESSION['user_id']) : null;
$avatar = 'default.jpg';
if ($user && !empty($user['profile_picture'])) {
    $avatar = htmlspecialchars($user['profile_picture']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $pageTitle ?? RACINE_SITE ?> - <?= RACINE_SITE ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;600&display=swap" rel="stylesheet" />
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="<?= RACINE_SITE ?>assets/css/style.css" />
</head>

<body>

<header>
    <nav class="navbar navbar-expand-lg fixed-top bg-dark navbar-dark shadow">
        <div class="container-fluid">
            <h1 class="m-0">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= RACINE_SITE ?>index.php">
                    <img src="<?= RACINE_SITE ?>assets/img/logo/logo.png" alt="Logo" height="80" class="me-2">
                </a>
            </h1>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarContent" aria-controls="navbarContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= RACINE_SITE ?>index.php">
                            <i class="fa-solid fa-house"></i> Accueil
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= RACINE_SITE ?>albums.php">
                            <i class="fa-solid fa-compact-disc"></i> Albums
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if ($user): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?= RACINE_SITE ?>assets/img/avatars/<?= $avatar ?>" 
                                     alt="Avatar de <?= htmlspecialchars($user['username']) ?>" 
                                     class="rounded-circle me-2" width="60" height="60" style="object-fit: cover;">
                                <?= htmlspecialchars($user['username']) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="<?= RACINE_SITE ?>profil.php">Mon profil</a></li>

                                <?php if (function_exists('isAdmin') && isAdmin()): ?>
                                    <li><a class="dropdown-item" href="<?= RACINE_SITE ?>admin/add_album.php">Ajouter un album</a></li>
                                    <li><a class="dropdown-item" href="<?= RACINE_SITE ?>admin/all_album.php">Voir les albums</a></li>
                                    <li><a class="dropdown-item" href="<?= RACINE_SITE ?>admin/users.php">Utilisateurs</a></li>
                                <?php endif; ?>

                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="post" action="<?= RACINE_SITE ?>logout.php" class="m-0">
                                        <button type="submit" class="dropdown-item">
                                            <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= RACINE_SITE ?>register.php">
                                <i class="fa-solid fa-user-plus"></i> Inscription
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= RACINE_SITE ?>connexion.php">
                                <i class="fa-solid fa-right-to-bracket"></i> Connexion
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="container" style="padding-top: 90px;">
