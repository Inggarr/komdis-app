<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header("Location: dashboard.php");
    exit;
}

$berita = false;
try { 
    $berita = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM berita WHERE id='$id'")); 
} catch (Exception $e) {}

if (!$berita) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($berita['judul']) ?> - Komdis HIMA</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfdfe;
            color: #1a202c;
        }
        .container-custom { max-width: 850px; margin: 0 auto; }
        .artikel-img { width: 100%; max-height: 450px; object-fit: cover; border-radius: 24px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .artikel-body { font-size: 1.1rem; line-height: 1.8; color: #4a5568; }
        .card-berita { background: #fff; border-radius: 30px; border: 1px solid rgba(0,0,0,0.04); box-shadow: 0 10px 40px rgba(0,0,0,0.02); padding: 40px; margin-top: 30px; }
        .meta-info { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; font-size: 0.85rem; color: #718096; font-weight: 500; }
        .btn-back { display: inline-flex; align-items: center; gap: 8px; color: #718096; text-decoration: none; font-weight: 600; margin-bottom: 20px; transition: 0.2s; }
        .btn-back:hover { color: #0f172a; }
    </style>
</head>

<body>
    <?php include '../partials/user_navbar.php'; ?>

    <div class="container container-custom py-5">
        <a href="dashboard.php" class="btn-back">
            <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i> Kembali ke Dashboard
        </a>

        <div class="card-berita">
            <?php if (!empty($berita['thumbnail'])): ?>
                <img src="../assets/upload/berita/<?= htmlspecialchars($berita['thumbnail']) ?>" alt="Thumbnail" class="artikel-img">
            <?php endif; ?>

            <div class="meta-info">
                <span class="badge rounded-pill px-3 py-2" style="background: rgba(15,23,42,0.1); color: #0f172a;">BERITA</span>
                <span>•</span>
                <span><i data-lucide="calendar" style="width: 14px; height: 14px; margin-bottom: 2px;"></i> <?= date('d M Y', strtotime($berita['created_at'])) ?></span>
            </div>

            <h1 class="fw-bold mb-4" style="color: #0f172a; letter-spacing: -1px;"><?= htmlspecialchars($berita['judul']) ?></h1>

            <div class="artikel-body">
                <?= nl2br(htmlspecialchars($berita['isi'])) ?>
            </div>
            
            <hr class="my-5 opacity-10">
            
            <div class="text-center">
                <p class="text-muted small mb-0">Portal Informasi Komisi Disiplin HIMA</p>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
