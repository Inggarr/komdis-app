<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_SESSION['id'];

// Handle Update Profil (Nama & Divisi & Foto)
if (isset($_POST['update_profil'])) {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $divisi = mysqli_real_escape_string($conn, $_POST['divisi']);
    
    // Handle Foto
    $foto_sql = "";
    if (!empty($_FILES['foto']['name'])) {
        $tmp  = $_FILES['foto']['tmp_name'];
        $ext  = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];
        
        if (in_array($ext, $allowed)) {
            $namaBaru = time() . '_' . $id . '.' . $ext;
            $dest = '../assets/upload/profil/';
            
            if (!is_dir($dest)) {
                mkdir($dest, 0777, true);
            }
            
            // Delete old photo if exists
            $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT foto FROM users WHERE id='$id'"));
            if (!empty($old['foto']) && file_exists($dest . $old['foto'])) {
                @unlink($dest . $old['foto']);
            }
            
            if (move_uploaded_file($tmp, $dest . $namaBaru)) {
                $foto_sql = ", foto='$namaBaru'";
            }
        } else {
            $target = isset($_POST['from_settings']) ? 'pengaturan.php' : 'profile.php';
            header("Location: ../user/$target?msg=format_error");
            exit;
        }
    }
    
    $query = "UPDATE users SET nama='$nama', divisi='$divisi' $foto_sql WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['nama'] = $nama; // Update session name
        $target = isset($_POST['from_settings']) ? 'pengaturan.php' : 'profile.php';
        header("Location: ../user/$target?msg=profil_success");
    } else {
        $target = isset($_POST['from_settings']) ? 'pengaturan.php' : 'profile.php';
        header("Location: ../user/$target?msg=error");
    }
    exit;
}

// Handle Ganti Password
if (isset($_POST['update_password'])) {
    $pass_lama = $_POST['pass_lama'];
    $pass_baru = $_POST['pass_baru'];
    $konfirmasi = $_POST['konfirmasi'];
    $target = isset($_POST['from_settings']) ? 'pengaturan.php' : 'profile.php';
    
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT password FROM users WHERE id='$id'"));
    
    if (password_verify($pass_lama, $user['password'])) {
        if ($pass_baru === $konfirmasi) {
            $hashed = password_hash($pass_baru, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE users SET password='$hashed' WHERE id='$id'");
            header("Location: ../user/$target?msg=pass_success");
        } else {
            header("Location: ../user/$target?msg=pass_mismatch");
        }
    } else {
        header("Location: ../user/$target?msg=old_pass_error");
    }
    exit;
}
