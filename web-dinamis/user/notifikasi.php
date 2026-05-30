<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_SESSION['id'];
$data = false;

// Update status is_read menjadi 1 saat halaman dibuka
try {
    mysqli_query($conn, "UPDATE notifikasi SET is_read=1 WHERE user_id='$id' AND is_read=0");
    $data = mysqli_query($conn, "SELECT * FROM notifikasi WHERE user_id='$id' ORDER BY id DESC");
} catch(Exception $e){}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Komdis HIMA</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #fdfdfd; color: #2d3748; }
        .card-custom { background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05); }
        .notif-item { padding: 20px; border-bottom: 1px solid #edf2f7; transition: background 0.2s; }
        .notif-item:hover { background: #fafbfa; }
        .notif-item:last-child { border-bottom: none; }
        .notif-icon { width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
        .icon-blue { background: rgba(78,115,223,0.1); color: #4e73df; }
    </style>
</head>
<body>
    <?php include '../partials/user_navbar.php'; ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold mb-1" style="color: #1a202c;">Pusat Notifikasi</h3>
                        <p class="text-muted mb-0">Pembaruan terbaru mengenai laporan dan akun kamu.</p>
                    </div>
                </div>

                <div class="card-custom overflow-hidden">
                    <?php if (!$data || mysqli_num_rows($data) == 0): ?>
                        <div class="text-center py-5">
                            <i data-lucide="bell-off" class="text-muted mb-3" style="width: 64px; height: 64px; opacity: 0.3;"></i>
                            <h5 class="fw-bold text-dark">Tidak Ada Notifikasi</h5>
                            <p class="text-muted">Kamu sudah membaca semua pemberitahuan.</p>
                        </div>
                    <?php else: ?>
                        <?php while ($d = mysqli_fetch_assoc($data)): ?>
                            <div class="notif-item d-flex gap-3">
                                <div class="notif-icon icon-blue">
                                    <i data-lucide="mail" style="width: 20px; height: 20px;"></i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h6 class="fw-bold text-dark mb-0">Sistem Komdis</h6>
                                        <span class="text-muted" style="font-size: 0.75rem;">• <?= date('d M Y, H:i', strtotime($d['created_at'])) ?></span>
                                    </div>
                                    <p class="text-dark mb-0" style="line-height: 1.5; font-size: 0.95rem;">
                                        <?= htmlspecialchars($d['pesan']) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>