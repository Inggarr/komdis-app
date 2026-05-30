<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Tambah User
if (isset($_POST['tambah_user'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $nim      = mysqli_real_escape_string($conn, $_POST['nim']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $divisi   = mysqli_real_escape_string($conn, $_POST['divisi']);
    $role     = mysqli_real_escape_string($conn, $_POST['role']);

    $query = "INSERT INTO users (nama, nim, password, divisi, role) VALUES ('$nama', '$nim', '$password', '$divisi', '$role')";
    if (mysqli_query($conn, $query)) {
        header("Location: ../admin/user.php?msg=tambah");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    exit;
}

// Edit User
if (isset($_POST['edit_user'])) {
    $id     = (int)$_POST['id'];
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $nim    = mysqli_real_escape_string($conn, $_POST['nim']);
    $divisi = mysqli_real_escape_string($conn, $_POST['divisi']);
    $role   = mysqli_real_escape_string($conn, $_POST['role']);

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "UPDATE users SET nama='$nama', nim='$nim', password='$password', divisi='$divisi', role='$role' WHERE id='$id'";
    } else {
        $query = "UPDATE users SET nama='$nama', nim='$nim', divisi='$divisi', role='$role' WHERE id='$id'";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: ../admin/user.php?msg=edit");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    exit;
}

// Hapus User
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    
    // Prevent deleting self
    if ($id == $_SESSION['user_id']) {
        header("Location: ../admin/user.php?msg=error_self");
        exit;
    }

    if (mysqli_query($conn, "DELETE FROM users WHERE id='$id'")) {
        header("Location: ../admin/user.php?msg=hapus");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    exit;
}
