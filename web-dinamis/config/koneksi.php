<?php

// Baca dari environment variable (production/Docker)
// Jika tidak ada, fallback ke nilai lokal (development)
$host = getenv('DB_HOST') ?: 'host.docker.internal';
$user = getenv('DB_USER') ?: 'userkommdis';
$pass = getenv('DB_PASS') ?: '12345';
$db = getenv('DB_NAME') ?: 'dbkomdis';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

?>