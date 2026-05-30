<?php
session_start();
include '../config/koneksi.php';

// Validasi: harus dari form POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../auth/register.php");
    exit;
}

$nama     = mysqli_real_escape_string($conn, trim($_POST['nama'] ?? ''));
$nim      = mysqli_real_escape_string($conn, trim($_POST['nim'] ?? ''));
$divisi   = ''; // Dikosongkan karena pendaftar umum tidak punya divisi
$jabatan  = ''; // Dikosongkan karena pendaftar umum tidak punya jabatan
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Validasi wajib
if (empty($nama) || empty($nim) || empty($_POST['password'])) {
    echo "<script>alert('Nama, NIM, dan Password wajib diisi!'); window.location='../auth/register.php';</script>";
    exit;
}

// Cek NIM sudah terdaftar
$cek = mysqli_query($conn, "SELECT id FROM users WHERE nim='$nim'");
if (!$cek) {
    echo "<script>alert('Error database: " . mysqli_error($conn) . "'); window.location='../auth/register.php';</script>";
    exit;
}

if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('NIM sudah terdaftar! Gunakan NIM lain.'); window.location='../auth/register.php';</script>";
    exit;
}

// Insert user baru
$insert = mysqli_query($conn, "INSERT INTO users (nama, nim, divisi, jabatan, password, role, status)
    VALUES ('$nama','$nim','$divisi','$jabatan','$password','user','aktif')");

if ($insert) {
    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='../auth/login.php';</script>";
} else {
    // Tampilkan error MySQL yang lebih detail
    $errMsg = mysqli_error($conn);
    echo "<script>alert('Registrasi gagal: $errMsg'); window.location='../auth/register.php';</script>";
}
exit;
?>