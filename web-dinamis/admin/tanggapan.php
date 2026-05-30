<?php
session_start();
include '../config/koneksi.php';
include '../config/auth.php';

if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}

// Handle kirim tanggapan
if (isset($_POST['kirim_tanggapan'])) {
    $laporan_id = (int)$_POST['laporan_id'];
    $admin_id   = $_SESSION['id'];
    $isi        = mysqli_real_escape_string($conn, $_POST['isi']);

    mysqli_query($conn, "INSERT INTO tanggapan (laporan_id, admin_id, isi) VALUES ('$laporan_id','$admin_id','$isi')");

    // Kirim notifikasi ke user pelapor
    $lp = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_id, judul FROM laporan WHERE id='$laporan_id'"));
    $pesan = "Laporan \"{$lp['judul']}\" mendapat tanggapan dari admin.";
    mysqli_query($conn, "INSERT INTO notifikasi (user_id, pesan) VALUES ('{$lp['user_id']}','$pesan')");

    header("Location: tanggapan.php?laporan_id=$laporan_id&msg=berhasil");
    exit;
}

// Handle hapus tanggapan
if (isset($_GET['hapus'])) {
    $hid = (int)$_GET['hapus'];
    $lid = (int)$_GET['lid'];
    mysqli_query($conn, "DELETE FROM tanggapan WHERE id='$hid'");
    header("Location: tanggapan.php?laporan_id=$lid");
    exit;
}

// Data laporan yang dipilih
$lid      = isset($_GET['laporan_id']) ? (int)$_GET['laporan_id'] : 0;
$laporan  = $lid ? mysqli_fetch_assoc(mysqli_query($conn, "SELECT laporan.*, users.nama FROM laporan JOIN users ON laporan.user_id=users.id WHERE laporan.id='$lid'")) : null;
$tanggapan = $lid ? mysqli_query($conn, "SELECT * FROM tanggapan WHERE laporan_id='$lid' ORDER BY id ASC") : null;

// Daftar semua laporan (untuk navigasi)
$daftarLaporan = mysqli_query($conn, "SELECT laporan.id, laporan.judul, laporan.status, users.nama FROM laporan JOIN users ON laporan.user_id=users.id ORDER BY laporan.id DESC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tanggapan Laporan - Admin Komdis</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }
        .chat-bubble { border-left: 4px solid #4e73df; background: #fff; }
    </style>
</head>

<body>
<div class="d-flex">
    <?php include '../partials/sidebar.php'; ?>
    <div class="flex-grow-1 p-4" style="margin-left:210px;">
        <h4 class="mb-4">💬 Tanggapan Laporan</h4>

        <div class="row g-4">
            <!-- Daftar Laporan -->
            <div class="col-md-4">
                <div class="card shadow p-3">
                    <h6 class="mb-3">Pilih Laporan</h6>
                    <?php while ($d = mysqli_fetch_assoc($daftarLaporan)): ?>
                        <a href="?laporan_id=<?= $d['id'] ?>"
                            class="d-block text-decoration-none mb-2 p-2 rounded <?= ($lid == $d['id']) ? 'bg-primary text-white' : 'bg-light text-dark' ?>">
                            <small class="d-block"><?= htmlspecialchars($d['nama']) ?></small>
                            <strong><?= htmlspecialchars(substr($d['judul'], 0, 35)) ?>...</strong>
                            <span class="badge bg-secondary ms-1"><?= $d['status'] ?></span>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Detail & Tanggapan -->
            <div class="col-md-8">
                <?php if ($laporan): ?>
                    <div class="card shadow p-4 mb-3">
                        <h6 class="text-muted mb-1">Laporan dari: <strong><?= htmlspecialchars($laporan['nama']) ?></strong></h6>
                        <h5><?= htmlspecialchars($laporan['judul']) ?></h5>
                        <span class="badge bg-info"><?= $laporan['kategori'] ?></span>
                        <span class="badge bg-warning text-dark"><?= $laporan['status'] ?></span>
                        <p class="mt-2 text-muted"><?= nl2br(htmlspecialchars($laporan['kronologi'])) ?></p>
                    </div>

                    <?php if (isset($_GET['msg'])): ?>
                        <div class="alert alert-success">Tanggapan berhasil dikirim!</div>
                    <?php endif; ?>

                    <!-- Thread Tanggapan -->
                    <div class="mb-3">
                        <?php if (mysqli_num_rows($tanggapan) == 0): ?>
                            <p class="text-muted">Belum ada tanggapan.</p>
                        <?php else: ?>
                            <?php while ($t = mysqli_fetch_assoc($tanggapan)): ?>
                                <div class="card chat-bubble mb-2 p-3">
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">Admin</small>
                                        <a href="?hapus=<?= $t['id'] ?>&lid=<?= $lid ?>"
                                            class="btn btn-sm btn-outline-danger py-0"
                                            onclick="return confirm('Hapus tanggapan ini?')">×</a>
                                    </div>
                                    <p class="mb-0 mt-1"><?= nl2br(htmlspecialchars($t['isi'])) ?></p>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Form Tanggapan -->
                    <div class="card shadow p-4">
                        <h6 class="mb-3">Kirim Tanggapan</h6>
                        <form method="POST">
                            <input type="hidden" name="laporan_id" value="<?= $lid ?>">
                            <textarea name="isi" class="form-control mb-2" rows="3" placeholder="Tulis tanggapan..." required></textarea>
                            <button name="kirim_tanggapan" class="btn btn-primary">Kirim</button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">Pilih laporan dari daftar untuk melihat tanggapan.</div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
</body>
</html>
