<?php

// Baca dari environment variable (production/Docker)
// Jika tidak ada, deteksi OS: Windows -> localhost, Linux (Docker) -> komdis-db
$host = getenv('DB_HOST') ?: (PHP_OS_FAMILY === 'Windows' ? 'localhost' : 'komdis-db');
$user = getenv('DB_USER') ?: 'userkomdis';
$pass = getenv('DB_PASS') ?: '12345';
$db   = getenv('DB_NAME') ?: 'dbkomdis';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Fitur Auto-Import Skema Database jika tabel 'users' belum ada
$check_table = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
if (mysqli_num_rows($check_table) == 0) {
    $sql_file = dirname(__DIR__) . '/db_tambahan.sql';
    if (file_exists($sql_file)) {
        $sql_content = file_get_contents($sql_file);
        if (mysqli_multi_query($conn, $sql_content)) {
            do {
                if ($result = mysqli_store_result($conn)) {
                    mysqli_free_result($result);
                }
            } while (mysqli_next_result($conn));
        }
    }
}

?>