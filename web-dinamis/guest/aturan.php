<?php 
session_start(); 
include '../config/koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tata Tertib & Aturan - Komdis HIMA</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background: #f8fafc; font-family: 'Plus Jakarta Sans', sans-serif; color: #1e293b; }
        .hero-section { background: #ffffff; padding: 100px 0 60px; border-bottom: 1px solid rgba(15,23,42,0.05); margin-bottom: 50px; }
        .hero-section h1 { font-weight: 800; color: #0f172a; font-size: clamp(2.2rem, 5vw, 3rem); letter-spacing: -1px; }
        .hero-section p { color: #64748b; font-size: 1.15rem; max-width: 600px; margin: 0 auto; }
        
        .kat-card { background: transparent; border: none; margin-bottom: 40px; }
        .kat-header { margin-bottom: 20px; }
        .kat-title { font-size: 1.4rem; font-weight: 800; color: #0f172a; letter-spacing: -0.5px; display: flex; align-items: center; gap: 12px; }
        .kat-title::before { content: ''; width: 4px; height: 28px; background: #0f172a; border-radius: 10px; }
        .kat-desc { color: #64748b; font-size: 0.95rem; margin-top: 4px; padding-left: 16px; }

        .accordion-item { border: 1px solid rgba(15,23,42,0.06) !important; border-radius: 16px !important; margin-bottom: 15px; background: #ffffff; overflow: hidden; box-shadow: 0 4px 12px rgba(15,23,42,0.02); transition: all 0.3s; }
        .accordion-item:hover { box-shadow: 0 8px 24px rgba(15,23,42,0.05); transform: translateY(-2px); }
        .accordion-button { font-weight: 700; color: #334155; padding: 20px 24px; font-size: 1.05rem; }
        .accordion-button:not(.collapsed) { background: #f8fafc; color: #0f172a; box-shadow: none; border-bottom: 1px solid rgba(15,23,42,0.03); }
        .accordion-body { color: #475569; line-height: 1.8; padding: 24px; font-size: 1rem; }
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

<div class="hero-section text-center">
    <div class="container">
        <div class="mb-4 d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: rgba(15,23,42,0.05); color: #0f172a; border-radius: 20px;">
            <i data-lucide="scale" style="width: 35px; height: 35px;"></i>
        </div>
        <h1>Tata Tertib & Aturan</h1>
        <p>Landasan hukum dan etika berorganisasi untuk seluruh anggota HIMA.</p>
    </div>
</div>

<div class="container pb-5" style="max-width: 900px;">
    <?php
    $categories = mysqli_query($conn, "SELECT * FROM kategori_aturan ORDER BY id ASC");
    if (mysqli_num_rows($categories) == 0):
    ?>
        <div class="alert alert-info border-0 rounded-4 p-4 text-center shadow-sm">
            <h6 class="fw-bold mb-0">Belum ada aturan yang dipublikasikan.</h6>
        </div>
    <?php else: ?>
        <?php while($cat = mysqli_fetch_assoc($categories)): 
            $cat_name = $cat['nama_kategori'];
            $rules = mysqli_query($conn, "SELECT * FROM aturan WHERE kategori='$cat_name' ORDER BY id ASC");
            if (mysqli_num_rows($rules) > 0):
        ?>
            <div class="kat-card">
                <div class="kat-header">
                    <h3 class="kat-title"><?= htmlspecialchars($cat_name) ?></h3>
                    <?php if($cat['deskripsi']): ?>
                        <p class="kat-desc"><?= htmlspecialchars($cat['deskripsi']) ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="accordion" id="acc_<?= $cat['id'] ?>">
                    <?php while($rule = mysqli_fetch_assoc($rules)): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rule_<?= $rule['id'] ?>">
                                    <?= htmlspecialchars($rule['judul']) ?>
                                </button>
                            </h2>
                            <div id="rule_<?= $rule['id'] ?>" class="accordion-collapse collapse" data-bs-parent="#acc_<?= $cat['id'] ?>">
                                <div class="accordion-body">
                                    <?= nl2br(htmlspecialchars($rule['isi'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; endwhile; ?>
    <?php endif; ?>
</div>

<?php include '../partials/footer.php'; ?>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
</body>
</html>
