<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Admin Komdis</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; color: #2d3748; }
        #content-wrapper { margin-left: 260px; min-height: 100vh; background: #f8f9fa; }
        .card-custom { background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.05); overflow: hidden; }
        .table-custom th { background: #f8f9fc; color: #4a5568; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #edf2f7; padding: 18px 20px; }
        .table-custom td { padding: 18px 20px; vertical-align: middle; color: #4a5568; border-bottom: 1px solid #edf2f7; }
        .avatar-sm { width: 35px; height: 35px; border-radius: 10px; background: #edf2f7; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #4a5568; }
    </style>
</head>
<body>

    <?php include '../partials/admin_sidebar.php'; ?>

    <div id="content-wrapper">
        <?php include '../partials/admin_navbar.php'; ?>

        <div class="container-fluid px-4 pb-5">
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #0f172a;"><i data-lucide="users"></i> Manajemen Pengguna</h4>
                <button class="btn fw-bold rounded-pill px-4" style="background: #0f172a; color: #fff; border: none;" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah User</button>
            </div>
            
            <?php if(isset($_GET['msg'])): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-pill px-4 mb-4 fw-bold small">
                    <?= $_GET['msg'] == 'tambah' ? '✅ User berhasil ditambahkan!' : '' ?>
                    <?= $_GET['msg'] == 'edit' ? '✅ Data user berhasil diperbarui!' : '' ?>
                    <?= $_GET['msg'] == 'hapus' ? '🗑️ User berhasil dihapus!' : '' ?>
                </div>
            <?php endif; ?>

            <div class="card-custom">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pengguna</th>
                                <th>NIM / ID</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while ($d = mysqli_fetch_assoc($data)) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm"><?= substr($d['nama'], 0, 1) ?></div>
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($d['nama']) ?></div>
                                        </div>
                                    </td>
                                    <td><code><?= htmlspecialchars($d['nim']) ?></code></td>
                                    <td>
                                        <span class="badge rounded-pill px-3" style="background: <?= $d['role'] == 'admin' ? '#0f172a' : '#1e293b' ?>; color: #fff;">
                                            <?= strtoupper($d['role']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-success fw-bold small">● AKTIF</span>
                                    </td>
                                    <td class="text-end d-flex gap-2 justify-content-end">
                                        <button class="btn btn-sm btn-light border fw-bold rounded-pill px-3" 
                                                onclick="editUser(<?= htmlspecialchars(json_encode($d)) ?>)">
                                            Edit
                                        </button>
                                        <a href="../proses/user_proses.php?hapus=<?= $d['id'] ?>" 
                                           class="btn btn-sm btn-light border text-danger fw-bold rounded-pill px-3" 
                                           onclick="return confirm('Hapus user ini?')">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
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
                    <h5 class="fw-bold text-navy mb-0">Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../proses/user_proses.php" method="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama lengkap..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">NIM / Username</label>
                            <input type="text" name="nim" class="form-control" placeholder="NIM atau username login..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password login..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Divisi / Jabatan</label>
                            <input type="text" name="divisi" class="form-control" placeholder="Contoh: Mahasiswa, Staff, dll...">
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold text-muted">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="user">User / Mahasiswa</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light fw-bold rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="tambah_user" class="btn fw-bold rounded-pill px-4" style="background: #0f172a; color: #fff;">Simpan User</button>
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
                    <h5 class="fw-bold text-navy mb-0">Edit Data User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../proses/user_proses.php" method="POST">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                            <input type="text" name="nama" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">NIM / Username</label>
                            <input type="text" name="nim" id="edit_nim" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Divisi / Jabatan</label>
                            <input type="text" name="divisi" id="edit_divisi" class="form-control">
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold text-muted">Role</label>
                            <select name="role" id="edit_role" class="form-select" required>
                                <option value="user">User / Mahasiswa</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light fw-bold rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="edit_user" class="btn fw-bold rounded-pill px-4" style="background: #0f172a; color: #fff;">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
        
        function editUser(data) {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_nama').value = data.nama;
            document.getElementById('edit_nim').value = data.nim;
            document.getElementById('edit_divisi').value = data.divisi;
            document.getElementById('edit_role').value = data.role;
            
            var modal = new bootstrap.Modal(document.getElementById('modalEdit'));
            modal.show();
        }
    </script>
</body>
</html>