<?php session_start(); include '../config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Komdis HIMA</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fdfdfd; font-family: 'Inter', 'Segoe UI', sans-serif; }
        .hero-section { background: #ffffff; padding: 80px 0 60px; border-bottom: 1px solid rgba(0,0,0,0.03); margin-bottom: 40px; }
        .hero-section h1 { font-weight: 800; color: #1a202c; font-size: clamp(2rem, 4vw, 2.8rem); margin-bottom: 10px; }
        .hero-section p { color: #4a5568; font-size: 1.1rem; }
        .accordion-item { border: 1px solid rgba(0,0,0,0.05) !important; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border-radius: 12px !important; margin-bottom: 12px; background: #ffffff; overflow: hidden; }
        .accordion-button { font-weight: 600; color: #2d3748; padding: 18px 24px; }
        .accordion-button:not(.collapsed) { background: #f8fafc; color: #0f172a; box-shadow: none; border-bottom: 1px solid rgba(0,0,0,0.03); }
        .accordion-body { color: #4a5568; line-height: 1.7; padding: 20px 24px; }
        .faq-number {
            width: 28px; height: 28px; border-radius: 50%;
            background: rgba(15,23,42,.1); color: #0f172a;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: .8rem; font-weight: bold; margin-right: 12px; flex-shrink: 0;
            transition: all 0.2s;
        }
        .accordion-button:not(.collapsed) .faq-number { background: #0f172a; color: #fff; }
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
        <h1 class="d-flex align-items-center justify-content-center gap-3"><i data-lucide="help-circle" style="width: 40px; height: 40px; color: #4e73df;"></i> Frequently Asked Questions</h1>
        <p class="mb-0">Pertanyaan yang sering ditanyakan seputar Komdis HIMA</p>
    </div>
</div>

<div class="container pb-5" style="max-width:760px;">
    <?php
    $data = false;
    try { $data = mysqli_query($conn, "SELECT * FROM faq ORDER BY id ASC"); } catch (Exception $e) {}
    if (!$data || mysqli_num_rows($data) == 0):
    ?>
        <div class="alert alert-info text-center">Belum ada FAQ yang tersedia.</div>
    <?php else: ?>
        <div class="accordion" id="faqAccordion">
            <?php $no = 1; while ($d = mysqli_fetch_assoc($data)): ?>
                <div class="accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed d-flex align-items-center" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#faqItem<?= $d['id'] ?>">
                            <span class="faq-number"><?= $no++ ?></span>
                            <?= htmlspecialchars($d['pertanyaan']) ?>
                        </button>
                    </h2>
                    <div id="faqItem<?= $d['id'] ?>" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <?= nl2br(htmlspecialchars($d['jawaban'])) ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

    <!-- CTA -->
    <div class="text-center mt-5">
        <p class="text-muted">Masih punya pertanyaan lain?</p>
        <a href="kontak.php" class="btn fw-bold px-4 py-2" style="background: #0f172a; color: #fff; border-radius: 50px;"><i data-lucide="mail" style="width: 18px; height: 18px;"></i> Hubungi Kami</a>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script>
    lucide.createIcons();
</script>
</body>
</html>
