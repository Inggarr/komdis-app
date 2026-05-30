<?php
session_start();
include '../config/koneksi.php';
include '../config/auth.php';

$id = $_SESSION['id'];

// =====================
// HAPUS LAPORAN
// =====================
if (isset($_GET['hapus'])) {
    $hid = (int)$_GET['hapus'];
    // Pastikan hanya milik user sendiri dan masih pending
    $cek = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM laporan WHERE id='$hid' AND user_id='$id' AND status='pending'"));
    if ($cek) {
        mysqli_query($conn, "DELETE FROM bukti WHERE laporan_id='$hid'");
        mysqli_query($conn, "DELETE FROM laporan WHERE id='$hid'");
    }
    header("Location: ../user/laporan.php?msg=hapus");
    exit;
}

// =====================
// TAMBAH LAPORAN
// =====================
if (isset($_POST['tambah'])) {
    $judul     = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori  = mysqli_real_escape_string($conn, $_POST['kategori']);
    $kronologi = mysqli_real_escape_string($conn, $_POST['kronologi']);
    $lokasi    = mysqli_real_escape_string($conn, $_POST['lokasi']);

    // Insert laporan
    mysqli_query($conn, "INSERT INTO laporan (user_id, judul, kategori, kronologi, lokasi, status)
        VALUES ('$id','$judul','$kategori','$kronologi','$lokasi','pending')");

    $laporan_id = mysqli_insert_id($conn);

    // Upload bukti (multiple files)
    if (!empty($_FILES['bukti']['name'][0])) {
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        $uploadDir = '../assets/upload/bukti/';

        foreach ($_FILES['bukti']['name'] as $key => $filename) {
            $tmp  = $_FILES['bukti']['tmp_name'][$key];
            $size = $_FILES['bukti']['size'][$key];
            $ext  = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) continue;
            if ($size > 5000000) continue;

            $newname = uniqid() . '_' . time() . '.' . $ext;
            if (move_uploaded_file($tmp, $uploadDir . $newname)) {
                mysqli_query($conn, "INSERT INTO bukti (laporan_id, nama_file)
                    VALUES ('$laporan_id','$newname')");
            }
        }
    }

    // Kirim notifikasi ke user sendiri
    mysqli_query($conn, "INSERT INTO notifikasi (user_id, pesan)
        VALUES ('$id', 'Laporan Anda telah berhasil dikirim dan sedang menunggu proses.')");

    header("Location: ../user/laporan.php?msg=berhasil");
    exit;
}

// Jika diakses langsung tanpa action
header("Location: ../user/tambah_laporan.php");
exit;
?>