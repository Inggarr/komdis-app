<?php
session_start();
include '../config/koneksi.php';

// Validasi: harus dari form POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../auth/login.php");
    exit;
}

$nim      = mysqli_real_escape_string($conn, trim($_POST['nim']));
$password = $_POST['password'];

if (empty($nim) || empty($password)) {
    echo "<script>alert('NIM dan Password wajib diisi!'); window.location='../auth/login.php';</script>";
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM users WHERE nim='$nim'");

if (!$query) {
    echo "<script>alert('Error database: " . mysqli_error($conn) . "'); window.location='../auth/login.php';</script>";
    exit;
}

if (mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);

    if (password_verify($password, $data['password'])) {

        // Cek apakah akun di-suspend
        if (isset($data['status']) && $data['status'] === 'suspended') {
            echo "<script>alert('Akun Anda telah disuspend. Hubungi admin.'); window.location='../auth/login.php';</script>";
            exit;
        }

        $_SESSION['login']  = true;
        $_SESSION['id']     = $data['id'];
        $_SESSION['nama']   = $data['nama'];
        $_SESSION['nim']    = $data['nim'];
        $_SESSION['role']   = $data['role'];
        $_SESSION['divisi'] = $data['divisi'] ?? '';

        if ($data['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../user/dashboard.php");
        }
        exit;

    } else {
        echo "<script>alert('Password salah!'); window.location='../auth/login.php';</script>";
        exit;
    }

} else {
    echo "<script>alert('NIM tidak ditemukan!'); window.location='../auth/login.php';</script>";
    exit;
}
?>