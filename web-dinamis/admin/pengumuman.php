<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Handle tambah pengumuman
if (isset($_POST['tambah_pengumuman'])) {
    $judul   = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi     = mysqli_real_escape_string($conn, $_POST['isi']);
    $pin     = isset($_POST['pin']) ? 1 : 0;
    mysqli_query($conn, "INSERT INTO pengumuman (judul, isi, pin) VALUES ('$judul','$isi','$pin')");
    header("Location: pengumuman.php?msg=tambah");
    exit;
}

// Handle edit pengumuman
if (isset($_POST['edit_pengumuman'])) {
    $id      = (int)$_POST['id'];
    $judul   = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi     = mysqli_real_escape_string($conn, $_POST['isi']);
    $pin     = isset($_POST['pin']) ? 1 : 0;
    mysqli_query($conn, "UPDATE pengumuman SET judul='$judul', isi='$isi', pin='$pin' WHERE id='$id'");
    header("Location: pengumuman.php?msg=edit");
    exit;
}

// Handle hapus
if (isset($_GET['hapus'])) {
    $hid = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM pengumuman WHERE id='$hid'");
    header("Location: pengumuman.php");
    exit;
}

// Handle toggle pin
if (isset($_GET['pin'])) {
    $pid      = (int)$_GET['pin'];
    $curr     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT pin FROM pengumuman WHERE id='$pid'"));
    $newPin   = $curr['pin'] == 1 ? 0 : 1;
    mysqli_query($conn, "UPDATE pengumuman SET pin='$newPin' WHERE id='$pid'");
    header("Location: pengumuman.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM pengumuman ORDER BY pin DESC, id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengumuman - Admin Komdis</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; color: #2d3748; }
        #content-wrapper { margin-left: 260px; min-height: 100vh; background: #f8f9fa; }
        .card-custom { background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.05); overflow: hidden; }
        .form-control { border-radius: 12px; padding: 12px 15px; border: 1px solid #e2e8f0; }
        .announce-item { padding: 20px; border-radius: 20px; background: #fff; border: 1px solid rgba(0,0,0,0.04); margin-bottom: 20px; position: relative; transition: 0.3s; }
        .announce-item:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.02); }
        .pinned-badge { background: #fffaf0; color: #0f172a; font-weight: 700; font-size: 0.65rem; padding: 4px 10px; border-radius: 50px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #0f172a; }
    </style>
</head>
<body>

    <?php include '../partials/admin_sidebar.php'; ?>

    <div id="content-wrapper">
        <?php include '../partials/admin_navbar.php'; ?>

        <div class="container-fluid px-4 pb-5">
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #0f172a;"><i data-lucide="megaphone"></i> Manajemen Pengumuman</h4>
            </div>

            <?php if(isset($_GET['msg'])): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-pill px-4 mb-4 fw-bold small">
                    <?= $_GET['msg'] == 'tambah' ? '✅ Pengumuman berhasil dipublikasikan!' : '' ?>
                    <?= $_GET['msg'] == 'edit' ? '✅ Pengumuman berhasil diperbarui!' : '' ?>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card-custom p-4">
                        <h6 class="fw-bold mb-3">Buat Pengumuman Baru</h6>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Judul Pengumuman</label>
                                <input type="text" name="judul" class="form-control" placeholder="Ketik judul pengumuman..." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Isi Pengumuman</label>
                                <textarea name="isi" class="form-control" rows="5" placeholder="Tulis informasi pengumuman..." required></textarea>
                            </div>
                            <div class="form-check form-switch mb-4">
                                <input class="form-check-input" type="checkbox" name="pin" id="pinSwitch">
                                <label class="form-check-label small fw-bold text-muted" for="pinSwitch">Sematkan Pengumuman (PIN)</label>
                            </div>
                            <button name="tambah_pengumuman" class="btn fw-bold rounded-pill py-2 w-100" style="background: #0f172a; color: #fff; border: none;">Publikasikan</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-8">
                    <h6 class="fw-bold mb-4 text-muted small text-uppercase" style="letter-spacing: 1px;">Pengumuman Aktif</h6>
                    <?php if (mysqli_num_rows($data) == 0): ?>
                        <div class="text-center py-5 bg-white rounded-4 border text-muted">Belum ada pengumuman.</div>
                    <?php else: ?>
                        <?php while ($d = mysqli_fetch_assoc($data)): ?>
                            <div class="announce-item shadow-sm">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if ($d['pin']): ?>
                                            <span class="pinned-badge d-flex align-items-center gap-1"><i data-lucide="pin" style="width: 10px; height: 10px;"></i> Tersemat</span>
                                        <?php endif; ?>
                                        <h5 class="fw-bold text-dark mb-0"><?= htmlspecialchars($d['judul']) ?></h5>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-light border fw-bold rounded-pill px-3" onclick="editPengumuman(<?= htmlspecialchars(json_encode($d)) ?>)">Edit</button>
                                        <a href="?pin=<?= $d['id'] ?>" class="btn btn-sm btn-light border fw-bold rounded-pill px-3">
                                            <?= $d['pin'] ? 'Lepas Pin' : 'Pin' ?>
                                        </a>
                                        <a href="?hapus=<?= $d['id'] ?>" class="btn btn-sm btn-light border text-danger fw-bold rounded-pill px-3" onclick="return confirm('Hapus pengumuman ini?')">Hapus</a>
                                    </div>
                                </div>
                                <p class="text-muted small mb-0" style="line-height: 1.6;"><?= nl2br(htmlspecialchars($d['isi'])) ?></p>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <h5 class="fw-bold text-navy mb-0">Edit Pengumuman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Judul Pengumuman</label>
                            <input type="text" name="judul" id="edit_judul" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Isi Pengumuman</label>
                            <textarea name="isi" id="edit_isi" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="pin" id="edit_pin">
                            <label class="form-check-label small fw-bold text-muted" for="edit_pin">Sematkan Pengumuman (PIN)</label>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light fw-bold rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="edit_pengumuman" class="btn fw-bold rounded-pill px-4" style="background: #0f172a; color: #fff;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();

        function editPengumuman(data) {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_judul').value = data.judul;
            document.getElementById('edit_isi').value = data.isi;
            document.getElementById('edit_pin').checked = data.pin == 1;
            
            var modal = new bootstrap.Modal(document.getElementById('modalEdit'));
            modal.show();
        }
    </script>
</body>
</html>
