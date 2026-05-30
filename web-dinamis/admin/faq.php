<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Handle tambah FAQ
if (isset($_POST['tambah_faq'])) {
    $pertanyaan = mysqli_real_escape_string($conn, $_POST['pertanyaan']);
    $jawaban    = mysqli_real_escape_string($conn, $_POST['jawaban']);
    mysqli_query($conn, "INSERT INTO faq (pertanyaan, jawaban) VALUES ('$pertanyaan','$jawaban')");
    header("Location: faq.php?msg=berhasil");
    exit;
}

// Handle hapus
if (isset($_GET['hapus'])) {
    $hid = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM faq WHERE id='$hid'");
    header("Location: faq.php");
    exit;
}

// Handle edit
if (isset($_POST['edit_faq'])) {
    $id         = (int)$_POST['id'];
    $pertanyaan = mysqli_real_escape_string($conn, $_POST['pertanyaan']);
    $jawaban    = mysqli_real_escape_string($conn, $_POST['jawaban']);
    mysqli_query($conn, "UPDATE faq SET pertanyaan='$pertanyaan', jawaban='$jawaban' WHERE id='$id'");
    header("Location: faq.php");
    exit;
}

$editData = null;
if (isset($_GET['edit'])) {
    $eid = (int)$_GET['edit'];
    $editData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM faq WHERE id='$eid'"));
}

$data = mysqli_query($conn, "SELECT * FROM faq ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola FAQ - Admin Komdis</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; color: #2d3748; }
        #content-wrapper { margin-left: 260px; min-height: 100vh; background: #f8f9fa; }
        .card-custom { background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.05); overflow: hidden; }
        .form-control { border-radius: 12px; padding: 12px 15px; border: 1px solid #e2e8f0; }
        .accordion-item { border-radius: 16px !important; border: 1px solid #edf2f7 !important; margin-bottom: 10px; overflow: hidden; }
        .accordion-button { font-weight: 700; color: #2d3748; background-color: #fff; box-shadow: none !important; }
        .accordion-button:not(.collapsed) { color: #0f172a; background-color: #f8fafc; }
    </style>
</head>
<body>

    <?php include '../partials/admin_sidebar.php'; ?>

    <div id="content-wrapper">
        <?php include '../partials/admin_navbar.php'; ?>

        <div class="container-fluid px-4 pb-5">
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #0f172a;"><i data-lucide="help-circle"></i> Manajemen FAQ</h4>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card-custom p-4">
                        <h6 class="fw-bold mb-3"><?= $editData ? 'Edit Pertanyaan' : 'Tambah FAQ Baru' ?></h6>
                        <form method="POST">
                            <?php if ($editData): ?>
                                <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                            <?php endif; ?>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Pertanyaan</label>
                                <input type="text" name="pertanyaan" class="form-control" placeholder="Apa pertanyaan populer?" value="<?= $editData ? htmlspecialchars($editData['pertanyaan']) : '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Jawaban</label>
                                <textarea name="jawaban" class="form-control" rows="5" placeholder="Tulis jawaban lengkap..." required><?= $editData ? htmlspecialchars($editData['jawaban']) : '' ?></textarea>
                            </div>
                            <button name="<?= $editData ? 'edit_faq' : 'tambah_faq' ?>" class="btn fw-bold rounded-pill py-2 w-100" style="background: #0f172a; color: #fff; border: none;">
                                <?= $editData ? 'Simpan Perubahan' : 'Tambahkan FAQ' ?>
                            </button>
                            <?php if ($editData): ?>
                                <a href="faq.php" class="btn btn-light w-100 fw-bold rounded-pill mt-2">Batalkan</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card-custom p-4">
                        <h6 class="fw-bold mb-4">Daftar Tanya Jawab</h6>
                        <?php if (mysqli_num_rows($data) == 0): ?>
                            <div class="text-center py-5 text-muted">Belum ada FAQ.</div>
                        <?php else: ?>
                            <div class="accordion" id="faqAccordion">
                                <?php $i = 1; while ($d = mysqli_fetch_assoc($data)): ?>
                                    <div class="accordion-item">
                                        <div class="accordion-header d-flex align-items-center">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?= $d['id'] ?>">
                                                <?= htmlspecialchars($d['pertanyaan']) ?>
                                            </button>
                                            <div class="pe-3 d-flex gap-1">
                                                <a href="?edit=<?= $d['id'] ?>" class="btn btn-sm btn-light border fw-bold text-primary rounded-pill px-3">Edit</a>
                                                <a href="?hapus=<?= $d['id'] ?>" class="btn btn-sm btn-light border fw-bold text-danger rounded-pill px-3" onclick="return confirm('Hapus FAQ ini?')">Hapus</a>
                                            </div>
                                        </div>
                                        <div id="faq<?= $d['id'] ?>" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body text-muted small">
                                                <?= nl2br(htmlspecialchars($d['jawaban'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
