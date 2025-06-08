<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
} else {
    // Si quelqu’un tente d’accéder à logout.php en GET : on redirige
    header("Location: index.php");
    exit;
}
