<?php
session_start();
include '../config/koneksi.php';

if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}

// =====================
// UPDATE STATUS LAPORAN
// =====================
if (isset($_POST['update_status'])) {
    $laporan_id = (int)$_POST['id'];
    $status     = mysqli_real_escape_string($conn, $_POST['status']);

    mysqli_query($conn, "UPDATE laporan SET status='$status' WHERE id='$laporan_id'");

    // Kirim notifikasi ke user pelapor
    $lp = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_id, judul FROM laporan WHERE id='$laporan_id'"));
    $pesan = "Status laporan \"" . addslashes($lp['judul']) . "\" telah diperbarui menjadi: $status.";
    mysqli_query($conn, "INSERT INTO notifikasi (user_id, pesan) VALUES ('{$lp['user_id']}','$pesan')");

    header("Location: ../admin/detail_laporan.php?id=$laporan_id&msg=status");
    exit;
}

// =====================
// KIRIM TANGGAPAN
// =====================
if (isset($_POST['kirim_tanggapan'])) {
    $laporan_id = (int)$_POST['laporan_id'];
    $admin_id   = $_SESSION['id'];
    $isi        = mysqli_real_escape_string($conn, $_POST['isi']);

    mysqli_query($conn, "INSERT INTO tanggapan (laporan_id, admin_id, isi)
        VALUES ('$laporan_id','$admin_id','$isi')");

    // Kirim notifikasi
    $lp = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_id, judul FROM laporan WHERE id='$laporan_id'"));
    $pesan = "Laporan \"" . addslashes($lp['judul']) . "\" mendapat tanggapan dari admin.";
    mysqli_query($conn, "INSERT INTO notifikasi (user_id, pesan) VALUES ('{$lp['user_id']}','$pesan')");

    header("Location: ../admin/detail_laporan.php?id=$laporan_id&msg=tanggapan");
    exit;
}

// =====================
// TAMBAH BERITA
// =====================
if (isset($_POST['tambah_berita'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi   = mysqli_real_escape_string($conn, $_POST['isi']);

    $namaBaru = '';
    if (!empty($_FILES['foto']['name'])) {
        $tmp      = $_FILES['foto']['tmp_name'];
        $ext      = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $namaBaru = time() . '_' . uniqid() . '.' . $ext;
        move_uploaded_file($tmp, '../assets/upload/berita/' . $namaBaru);
    }

    mysqli_query($conn, "INSERT INTO berita (judul, isi, thumbnail)
        VALUES ('$judul','$isi','$namaBaru')");

    header("Location: ../admin/berita.php?msg=berhasil");
    exit;
}

// =====================
// HAPUS BERITA
// =====================
if (isset($_GET['hapus_berita'])) {
    $bid = (int)$_GET['hapus_berita'];
    mysqli_query($conn, "DELETE FROM berita WHERE id='$bid'");
    header("Location: ../admin/berita.php");
    exit;
}

// =====================
// UPDATE ROLE USER
// =====================
if (isset($_POST['update_role'])) {
    $uid  = (int)$_POST['user_id'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    mysqli_query($conn, "UPDATE users SET role='$role' WHERE id='$uid'");
    header("Location: ../admin/user.php?msg=role");
    exit;
}

// =====================
// SUSPEND USER
// =====================
if (isset($_GET['suspend'])) {
    $uid = (int)$_GET['suspend'];
    mysqli_query($conn, "UPDATE users SET status='suspended' WHERE id='$uid'");
    header("Location: ../admin/user.php");
    exit;
}

// =====================
// AKTIFKAN USER
// =====================
if (isset($_GET['aktif'])) {
    $uid = (int)$_GET['aktif'];
    mysqli_query($conn, "UPDATE users SET status='aktif' WHERE id='$uid'");
    header("Location: ../admin/user.php");
    exit;
}

// Jika tidak ada action
header("Location: ../admin/dashboard.php");
exit;
?>