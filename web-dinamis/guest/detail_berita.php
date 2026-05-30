<?php
session_start();
include '../config/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header("Location: berita.php");
    exit;
}

$berita = false;
try { $berita = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM berita WHERE id='$id'")); } catch (Exception $e) {}
if (!$berita) {
    header("Location: berita.php");
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
    <style>
        body { background: #fdfdfd; font-family: 'Inter', 'Segoe UI', sans-serif; }
        .artikel-img { width: 100%; max-height: 380px; object-fit: cover; border-radius: 12px; }
        .artikel-body { font-size: 1.05rem; line-height: 1.8; color: #4a5568; }
        .breadcrumb-area { background: #ffffff; border-bottom: 1px solid rgba(0,0,0,0.05); padding: 20px 0; margin-bottom: 40px; }
        .breadcrumb-area .breadcrumb-item a { color: #718096; text-decoration: none; }
        .breadcrumb-area .breadcrumb-item a:hover { color: #4e73df; }
        .breadcrumb-area .breadcrumb-item.active { color: #2d3748; font-weight: 600; }
        .card { border-radius: 16px; border: 1px solid rgba(0,0,0,0.05) !important; box-shadow: 0 4px 20px rgba(0,0,0,0.03) !important; background: #ffffff; }
    </style>
</head>

<body>
<?php 
if (isset($_SESSION['login']) && $_SESSION['role'] == 'user') {
    include '../partials/user_navbar.php';
} else {
    include '../partials/guest_navbar.php';
}
?>

<!-- Breadcrumb -->
<div class="breadcrumb-area mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item"><a href="berita.php">Berita</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars(substr($berita['judul'], 0, 40)) ?>...</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container pb-5" style="max-width:760px;">
    <div class="card shadow border-0 rounded-3 p-4">
        <?php if (!empty($berita['thumbnail'])): ?>
            <img src="../assets/upload/berita/<?= htmlspecialchars($berita['thumbnail']) ?>"
                 alt="Thumbnail" class="artikel-img mb-4">
        <?php endif; ?>

        <h2 class="fw-bold mb-2" style="color: #0f172a;"><?= htmlspecialchars($berita['judul']) ?></h2>
        <span class="badge mb-3" style="background:rgba(15,23,42,.1);color:#0f172a;font-size:0.8rem;padding:6px 12px;font-weight:600;width:fit-content;">Berita</span>

        <hr>

        <div class="artikel-body">
            <?= nl2br(htmlspecialchars($berita['isi'])) ?>
        </div>

        <hr class="mt-4">
        <a href="berita.php" class="btn btn-outline-secondary">← Kembali ke Berita</a>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
</body>
</html>
