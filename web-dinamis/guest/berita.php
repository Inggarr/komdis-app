<?php 
session_start();
include '../config/koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita - Komdis HIMA</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fdfdfd; font-family: 'Inter', 'Segoe UI', sans-serif; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }
        .card-berita { transition: transform .2s, box-shadow .2s; border: 1px solid rgba(0,0,0,0.05); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.03); background: #ffffff; }
        .card-berita:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .card-berita img { height: 180px; object-fit: cover; width: 100%; }
        .badge-kat { background: rgba(15,23,42,.1); color: #0f172a; font-weight: 600; font-size: .72rem; border-radius: 20px; padding: 6px 12px; }
        .hero-section { background: #ffffff; padding: 80px 0 60px; border-bottom: 1px solid rgba(0,0,0,0.03); }
        .hero-section h1 { font-weight: 800; color: #1a202c; font-size: clamp(2rem, 4vw, 2.8rem); margin-bottom: 10px; }
        .hero-section p { color: #4a5568; font-size: 1.1rem; }
        .no-img { height: 180px; background: rgba(15,23,42,.05); display:flex; align-items:center; justify-content:center; color:#0f172a; font-size:2rem; }
        .text-muted { color: #718096 !important; }
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

<div class="hero-section text-center mb-5">
    <div class="container">
        <h1 class="d-flex align-items-center justify-content-center gap-3"><i data-lucide="newspaper" style="width: 40px; height: 40px; color: #4e73df;"></i> Berita & Informasi</h1>
        <p class="mb-0">Update terbaru dari Komdis HIMA</p>
    </div>
</div>

<div class="container pb-5">
    <?php
    // Ambil data berita
    $berita = false;
    try { $berita = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC"); } catch (Exception $e) {}
    if (!$berita || mysqli_num_rows($berita) == 0):
    ?>
        <div class="alert alert-info text-center">Belum ada berita yang dipublikasikan.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php while ($b = mysqli_fetch_assoc($berita)): ?>
                <div class="col-md-4">
                    <div class="card card-berita shadow-sm h-100">
                        <?php if (!empty($b['thumbnail'])): ?>
                            <img src="../assets/upload/berita/<?= htmlspecialchars($b['thumbnail']) ?>" alt="Thumbnail">
                        <?php else: ?>
                            <div class="no-img"><i data-lucide="newspaper" style="width: 48px; height: 48px; opacity: 0.5;"></i></div>
                        <?php endif; ?>
                        <div class="card-body">
                            <span class="badge badge-kat mb-3">Berita</span>
                            <h6 class="fw-bold" style="color: #2d3748; line-height: 1.4;"><?= htmlspecialchars($b['judul']) ?></h6>
                            <p class="text-muted small"><?= htmlspecialchars(substr(strip_tags($b['isi']), 0, 100)) ?>...</p>
                        </div>
                        <div class="card-footer bg-white border-0 pb-3">
                            <a href="detail_berita.php?id=<?= $b['id'] ?>" class="btn fw-semibold w-100 rounded-pill" style="border: 1px solid #0f172a; color: #0f172a; transition: all 0.3s;">
                                Baca Selengkapnya →
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../partials/footer.php'; ?>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script>
    lucide.createIcons();
</script>
</body>
</html>
