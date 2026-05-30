<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Handle tambah aturan
if (isset($_POST['tambah_aturan'])) {
    $judul    = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $isi      = mysqli_real_escape_string($conn, $_POST['isi']);
    mysqli_query($conn, "INSERT INTO aturan (judul, kategori, isi) VALUES ('$judul','$kategori','$isi')");
    header("Location: aturan.php?msg=berhasil");
    exit;
}

// Handle edit
if (isset($_POST['edit_aturan'])) {
    $id       = (int)$_POST['id'];
    $judul    = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $isi      = mysqli_real_escape_string($conn, $_POST['isi']);
    mysqli_query($conn, "UPDATE aturan SET judul='$judul', kategori='$kategori', isi='$isi' WHERE id='$id'");
    header("Location: aturan.php");
    exit;
}

// Handle hapus
if (isset($_GET['hapus'])) {
    $hid = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM aturan WHERE id='$hid'");
    header("Location: aturan.php");
    exit;
}

// Data edit
$editData = null;
if (isset($_GET['edit'])) {
    $eid = (int)$_GET['edit'];
    $editData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM aturan WHERE id='$eid'"));
}

$data = mysqli_query($conn, "SELECT * FROM aturan ORDER BY kategori, id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tata Tertib - Admin Komdis</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; color: #2d3748; }
        #content-wrapper { margin-left: 260px; min-height: 100vh; background: #f8f9fa; }
        .card-custom { background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.05); overflow: hidden; }
        .form-control, .form-select { border-radius: 12px; padding: 12px 15px; border: 1px solid #e2e8f0; }
        .rule-item { border-left: 4px solid #0f172a; padding: 15px; background: #fff; border-radius: 0 16px 16px 0; margin-bottom: 15px; border: 1px solid rgba(0,0,0,0.03); border-left-width: 4px; box-shadow: 0 2px 10px rgba(0,0,0,0.01); }
        .cat-badge { background: rgba(15,23,42,0.1); color: #0f172a; font-weight: 700; font-size: 0.7rem; padding: 5px 12px; border-radius: 50px; text-transform: uppercase; }
    </style>
</head>
<body>

    <?php include '../partials/admin_sidebar.php'; ?>

    <div id="content-wrapper">
        <?php include '../partials/admin_navbar.php'; ?>

        <div class="container-fluid px-4 pb-5">
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #0f172a;"><i data-lucide="scale"></i> Manajemen Tata Tertib</h4>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card-custom p-4">
                        <h6 class="fw-bold mb-3"><?= $editData ? 'Edit Aturan' : 'Tambah Aturan Baru' ?></h6>
                        <form method="POST">
                            <?php if ($editData): ?>
                                <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                            <?php endif; ?>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Judul Aturan</label>
                                <input type="text" name="judul" class="form-control" placeholder="Contoh: Larangan Merokok" value="<?= $editData ? htmlspecialchars($editData['judul']) : '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    <?php
                                    $kategori_query = mysqli_query($conn, "SELECT * FROM kategori_aturan ORDER BY nama_kategori ASC");
                                    while ($k = mysqli_fetch_assoc($kategori_query)):
                                    ?>
                                        <option value="<?= htmlspecialchars($k['nama_kategori']) ?>" <?= ($editData && $editData['kategori'] == $k['nama_kategori']) ? 'selected' : '' ?>><?= htmlspecialchars($k['nama_kategori']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Deskripsi Aturan</label>
                                <textarea name="isi" class="form-control" rows="5" placeholder="Tulis isi aturan secara jelas..." required><?= $editData ? htmlspecialchars($editData['isi']) : '' ?></textarea>
                            </div>
                            <button name="<?= $editData ? 'edit_aturan' : 'tambah_aturan' ?>" class="btn fw-bold rounded-pill py-2 w-100" style="background: #0f172a; color: #fff; border: none;">
                                <?= $editData ? 'Simpan Perubahan' : 'Tambahkan Aturan' ?>
                            </button>
                            <?php if ($editData): ?>
                                <a href="aturan.php" class="btn btn-light w-100 fw-bold rounded-pill mt-2">Batalkan</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card-custom p-4">
                        <h6 class="fw-bold mb-4">Daftar Tata Tertib Aktif</h6>
                        <?php if (mysqli_num_rows($data) == 0): ?>
                            <div class="text-center py-5 text-muted">Belum ada data aturan.</div>
                        <?php else: ?>
                            <?php
                            $currentKat = '';
                            while ($d = mysqli_fetch_assoc($data)):
                                if ($d['kategori'] != $currentKat):
                                    $currentKat = $d['kategori'];
                                    echo "<div class='mt-4 mb-2'><span class='cat-badge'>" . htmlspecialchars($currentKat) . "</span></div>";
                                endif;
                            ?>
                                <div class="rule-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1"><?= htmlspecialchars($d['judul']) ?></h6>
                                        <p class="text-muted small mb-0"><?= nl2br(htmlspecialchars($d['isi'])) ?></p>
                                    </div>
                                    <div class="ms-3 d-flex gap-2">
                                        <a href="?edit=<?= $d['id'] ?>" class="btn btn-sm btn-light border fw-bold text-primary rounded-pill px-3">Edit</a>
                                        <a href="?hapus=<?= $d['id'] ?>" class="btn btn-sm btn-light border fw-bold text-danger rounded-pill px-3" onclick="return confirm('Hapus aturan ini?')">Hapus</a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
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
