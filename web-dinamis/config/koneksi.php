<?php

// Baca dari environment variable (production/Docker)
// Jika tidak ada, deteksi OS: Windows -> localhost, Linux (Docker) -> komdis-db
$host = getenv('DB_HOST') ?: (PHP_OS_FAMILY === 'Windows' ? 'localhost' : 'dbkomdis');
$user = getenv('DB_USER') ?: 'userkomdis';
$pass = getenv('DB_PASS') ?: '12345';
$db = getenv('DB_NAME') ?: 'dbkomdis';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

?>