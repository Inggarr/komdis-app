<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Handle Tambah
if (isset($_POST['tambah_kategori'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    $desk = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    mysqli_query($conn, "INSERT INTO kategori_aturan (nama_kategori, deskripsi) VALUES ('$nama', '$desk')");
    header("Location: kategori_aturan.php?msg=tambah");
    exit;
}

// Handle Edit
if (isset($_POST['edit_kategori'])) {
    $id   = (int)$_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    $desk = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    mysqli_query($conn, "UPDATE kategori_aturan SET nama_kategori='$nama', deskripsi='$desk' WHERE id='$id'");
    header("Location: kategori_aturan.php?msg=edit");
    exit;
}

// Handle Hapus
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM kategori_aturan WHERE id='$id'");
    header("Location: kategori_aturan.php?msg=hapus");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM kategori_aturan ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori Aturan - Admin Komdis</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; color: #2d3748; }
        #content-wrapper { margin-left: 260px; min-height: 100vh; background: #f8f9fa; }
        .card-custom { background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.05); overflow: hidden; }
        .form-control { border-radius: 12px; padding: 12px 15px; border: 1px solid #e2e8f0; }
        .table-custom th { background: #f8fafc; color: #475569; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; padding: 15px 20px; }
        .table-custom td { padding: 15px 20px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
    </style>
</head>
<body>

    <?php include '../partials/admin_sidebar.php'; ?>

    <div id="content-wrapper">
        <?php include '../partials/admin_navbar.php'; ?>

        <div class="container-fluid px-4 pb-5">
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #0f172a;"><i data-lucide="tag"></i> Kategori Aturan</h4>
                <button class="btn fw-bold rounded-pill px-4 text-white" style="background: #0f172a;" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Kategori</button>
            </div>

            <?php if(isset($_GET['msg'])): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-pill px-4 mb-4 fw-bold small">
                    <?= $_GET['msg'] == 'tambah' ? '✅ Kategori berhasil ditambahkan!' : '' ?>
                    <?= $_GET['msg'] == 'edit' ? '✅ Kategori berhasil diperbarui!' : '' ?>
                    <?= $_GET['msg'] == 'hapus' ? '🗑️ Kategori berhasil dihapus!' : '' ?>
                </div>
            <?php endif; ?>

            <div class="card-custom">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; while($d = mysqli_fetch_assoc($data)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-bold text-navy"><?= htmlspecialchars($d['nama_kategori']) ?></td>
                                <td class="text-muted small"><?= htmlspecialchars($d['deskripsi'] ?: '-') ?></td>
                                <td class="text-end d-flex gap-2 justify-content-end">
                                    <button class="btn btn-sm btn-light border fw-bold rounded-pill px-3" 
                                            onclick="editKategori(<?= htmlspecialchars(json_encode($d)) ?>)">Edit</button>
                                    <a href="?hapus=<?= $d['id'] ?>" class="btn btn-sm btn-light border text-danger fw-bold rounded-pill px-3" 
                                       onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if(mysqli_num_rows($data) == 0): ?>
                                <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada kategori.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <h5 class="fw-bold text-navy mb-0">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Pelanggaran Berat" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold text-muted">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat kategori..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light fw-bold rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="tambah_kategori" class="btn fw-bold rounded-pill px-4 text-white" style="background: #0f172a;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <h5 class="fw-bold text-navy mb-0">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Nama Kategori</label>
                            <input type="text" name="nama_kategori" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold text-muted">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" id="edit_desk" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light fw-bold rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="edit_kategori" class="btn fw-bold rounded-pill px-4 text-white" style="background: #0f172a;">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
        function editKategori(data) {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_nama').value = data.nama_kategori;
            document.getElementById('edit_desk').value = data.deskripsi;
            new bootstrap.Modal(document.getElementById('modalEdit')).show();
        }
    </script>
</body>
</html>
