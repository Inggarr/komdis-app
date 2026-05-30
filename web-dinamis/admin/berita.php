<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Tambah berita
if (isset($_POST['tambah_berita'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi   = mysqli_real_escape_string($conn, $_POST['isi']);

    $namaBaru = '';
    if (!empty($_FILES['foto']['name'])) {
        $tmp  = $_FILES['foto']['tmp_name'];
        $ext  = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $namaBaru = time() . '_' . uniqid() . '.' . $ext;
        
        if (!is_dir('../assets/upload/berita/')) {
            mkdir('../assets/upload/berita/', 0777, true);
        }
        
        move_uploaded_file($tmp, '../assets/upload/berita/' . $namaBaru);
    }
    mysqli_query($conn, "INSERT INTO berita (judul, isi, thumbnail) VALUES ('$judul','$isi','$namaBaru')");
    header("Location: berita.php?msg=berhasil");
    exit;
}

// Edit berita
if (isset($_POST['edit_berita'])) {
    $id    = (int)$_POST['id'];
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi   = mysqli_real_escape_string($conn, $_POST['isi']);

    if (!empty($_FILES['foto']['name'])) {
        // Hapus foto lama
        $old_res = mysqli_query($conn, "SELECT thumbnail FROM berita WHERE id='$id'");
        $old_row = mysqli_fetch_assoc($old_res);
        if (!empty($old_row['thumbnail'])) {
            @unlink('../assets/upload/berita/' . $old_row['thumbnail']);
        }

        $tmp  = $_FILES['foto']['tmp_name'];
        $ext  = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $namaBaru = time() . '_' . uniqid() . '.' . $ext;
        move_uploaded_file($tmp, '../assets/upload/berita/' . $namaBaru);
        
        mysqli_query($conn, "UPDATE berita SET judul='$judul', isi='$isi', thumbnail='$namaBaru' WHERE id='$id'");
    } else {
        mysqli_query($conn, "UPDATE berita SET judul='$judul', isi='$isi' WHERE id='$id'");
    }
    header("Location: berita.php?msg=edit_berhasil");
    exit;
}

// Hapus berita
if (isset($_GET['hapus'])) {
    $hid = (int)$_GET['hapus'];
    
    // Get thumbnail name to delete file
    $res = mysqli_query($conn, "SELECT thumbnail FROM berita WHERE id='$hid'");
    $row = mysqli_fetch_assoc($res);
    if (!empty($row['thumbnail'])) {
        @unlink('../assets/upload/berita/' . $row['thumbnail']);
    }
    
    mysqli_query($conn, "DELETE FROM berita WHERE id='$hid'");
    header("Location: berita.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita - Admin Komdis</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; color: #2d3748; }
        #content-wrapper { margin-left: 260px; min-height: 100vh; background: #f8f9fa; }
        .card-custom { background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.05); overflow: hidden; }
        .table-custom th { background: #f8f9fc; color: #4a5568; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #edf2f7; padding: 18px 20px; }
        .table-custom td { padding: 18px 20px; vertical-align: middle; color: #4a5568; border-bottom: 1px solid #edf2f7; }
        .thumb-preview { width:60px; height:45px; object-fit:cover; border-radius:8px; border: 1px solid #eee; }
        .form-control, .form-textarea { border-radius: 12px; border: 1px solid #e2e8f0; padding: 12px 15px; }
    </style>
</head>
<body>

    <?php include '../partials/admin_sidebar.php'; ?>

    <div id="content-wrapper">
        <?php include '../partials/admin_navbar.php'; ?>

        <div class="container-fluid px-4 pb-5">
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #0f172a;"><i data-lucide="newspaper"></i> Manajemen Berita</h4>
            </div>

            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'berhasil'): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-pill px-4 mb-4 fw-bold small">✅ Berita berhasil dipublikasikan!</div>
            <?php endif; ?>
            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'edit_berhasil'): ?>
                <div class="alert alert-primary border-0 shadow-sm rounded-pill px-4 mb-4 fw-bold small">✅ Berita berhasil diperbarui!</div>
            <?php endif; ?>

            <div class="row g-4">
                <!-- Form Input -->
                <div class="col-lg-4">
                    <div class="card-custom p-4">
                        <h6 class="fw-bold mb-3">Buat Artikel Baru</h6>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Judul Berita</label>
                                <input type="text" name="judul" class="form-control" placeholder="Ketik judul..." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Isi Artikel</label>
                                <textarea name="isi" class="form-control" rows="6" placeholder="Tulis berita lengkap..." required></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted">Thumbnail Gambar</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                            </div>
                             <button name="tambah_berita" class="btn fw-bold w-100 rounded-pill py-2" style="background: #0f172a; color: #fff; border: none;">Publikasikan</button>
                        </form>
                    </div>
                </div>

                <!-- Table List -->
                <div class="col-lg-8">
                    <div class="card-custom">
                        <div class="table-responsive">
                            <table class="table table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>Thumb</th>
                                        <th>Informasi Artikel</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($data) == 0): ?>
                                        <tr><td colspan="3" class="text-center py-5 text-muted">Belum ada berita.</td></tr>
                                    <?php else: ?>
                                        <?php while ($d = mysqli_fetch_assoc($data)): ?>
                                            <tr>
                                                <td style="width: 80px;">
                                                    <?php if (!empty($d['thumbnail'])): ?>
                                                        <img src="../assets/upload/berita/<?= htmlspecialchars($d['thumbnail']) ?>" class="thumb-preview">
                                                    <?php else: ?>
                                                        <div class="thumb-preview bg-light d-flex align-items-center justify-content-center text-muted" style="font-size: 0.7rem;">NO IMG</div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="fw-bold text-dark mb-1"><?= htmlspecialchars($d['judul']) ?></div>
                                                    <div class="small text-muted"><?= date('d M Y', strtotime($d['created_at'])) ?> • <?= substr(strip_tags($d['isi']), 0, 60) ?>...</div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <button class="btn btn-sm btn-light border fw-bold rounded-pill px-3 edit-btn" 
                                                                data-id="<?= $d['id'] ?>" 
                                                                data-judul="<?= htmlspecialchars($d['judul']) ?>" 
                                                                data-isi="<?= htmlspecialchars($d['isi']) ?>">Edit</button>
                                                        <a href="?hapus=<?= $d['id'] ?>" class="btn btn-sm btn-light border text-danger fw-bold rounded-pill px-3" onclick="return confirm('Hapus berita ini?')">Hapus</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold">Edit Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Judul Berita</label>
                            <input type="text" name="judul" id="edit-judul" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Isi Artikel</label>
                            <textarea name="isi" id="edit-isi" class="form-control" rows="8" required></textarea>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold text-muted">Ganti Thumbnail (Opsional)</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="edit_berita" class="btn btn-dark rounded-pill px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        const editBtns = document.querySelectorAll('.edit-btn');
        const modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
        
        editBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('edit-id').value = btn.dataset.id;
                document.getElementById('edit-judul').value = btn.dataset.judul;
                document.getElementById('edit-isi').value = btn.dataset.isi;
                modalEdit.show();
            });
        });
    </script>
</body>
</html>