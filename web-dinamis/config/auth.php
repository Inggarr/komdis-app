<?php
// Guard: cegah double session_start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>