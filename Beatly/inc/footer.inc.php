</main>

<footer class="site-footer bg-dark text-white pt-5 pb-3 mt-auto">
    <div class="container">
        <!-- Footer Top -->
        <div class="row text-center text-md-start">
            <!-- Brand Section -->
            <div class="col-md-3 mb-4">
                <h1 class="m-0">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= RACINE_SITE ?>index.php">
                    <img src="<?= RACINE_SITE ?>assets/img/logo/logo.png" alt="Logo" height="80" class="me-2">
                </a>
            </h1>
                <p>
                    Découvrez, partagez et évaluez vos albums préférés dans une communauté passionnée de musique.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-3 mb-4">
                <h4>Navigation</h4>
                <ul class="list-unstyled">
                    <li><a href="<?= RACINE_SITE ?>index.php" class="text-white text-decoration-none">Accueil</a></li>
                    <li><a href="<?= RACINE_SITE ?>albums.php" class="text-white text-decoration-none">Albums</a></li>
                    <?php if (isset($user)): ?>
                        <li><a href="<?= RACINE_SITE ?>profil.php" class="text-white text-decoration-none">Mon Profil</a></li>
                        <?php if (function_exists('isAdmin') && isAdmin()): ?>
                            <li><a href="<?= RACINE_SITE ?>admin/add_album.php" class="text-white text-decoration-none">Ajouter un Album</a></li>
                            <li><a href="<?= RACINE_SITE ?>admin/all_album.php" class="text-white text-decoration-none">Voir les Albums</a></li>
                            <li><a href="<?= RACINE_SITE ?>admin/users.php" class="text-white text-decoration-none">Utilisateurs</a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><a href="<?= RACINE_SITE ?>connexion.php" class="text-white text-decoration-none">Connexion</a></li>
                        <li><a href="<?= RACINE_SITE ?>register.php" class="text-white text-decoration-none">Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-md-3 mb-4">
                <h4>Contact</h4>
                <ul class="list-unstyled">
                    <li>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:contact@beatly.com" class="text-white text-decoration-none">contact@beatly.com</a>
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt"></i> Paris, France
                    </li>
                </ul>
            </div>

            <!-- Social Links -->
            <div class="col-md-3 mb-4">
                <h4>Suivez-nous</h4>
                <div class="d-flex justify-content-center justify-content-md-start gap-3 center">
                    <a href="https://twitter.com/BEATLY" class="text-white" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/WebSiteMusicBeatly" class="text-white" title="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="text-center pt-4 border-top mt-4">
            <p class="mb-1">&copy; <?= date('Y') ?> <?= htmlspecialchars(SITE_NAME) ?>. Tous droits réservés.</p>
            <p>Fait avec <i class="fas fa-heart text-danger"></i> pour la musique</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= RACINE_SITE ?>assets/js/script.js"></script>
</body>
</html>
