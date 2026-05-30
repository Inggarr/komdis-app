<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_SESSION['id'];

$user = false;
$laporan = false;
$total = 0; $pending = 0; $selesai = 0;

try {
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$id'"));
    $laporan = mysqli_query($conn, "SELECT * FROM laporan WHERE user_id='$id' ORDER BY id DESC LIMIT 5");
    $total    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM laporan WHERE user_id='$id'"))['jml'] ?? 0;
    $pending  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM laporan WHERE user_id='$id' AND status='pending'"))['jml'] ?? 0;
    $selesai  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM laporan WHERE user_id='$id' AND status='selesai'"))['jml'] ?? 0;
} catch(Exception $e){}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Komdis HIMA</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fdfdfd; color: #2d3748; }
        .card-custom { background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; transition: all 0.3s ease; }
        .card-custom:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(15, 23, 42, 0.05); border-color: #0f172a; }
        .avatar-lg { width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #0f172a, #1e293b); display: flex; align-items: center; justify-content: center; font-size: 3rem; color: #fff; font-weight: bold; margin: 0 auto; box-shadow: 0 10px 25px rgba(15,23,42,0.2); border: 5px solid #fff; overflow: hidden; }
        .stat-box { background: #f8fafc; border-radius: 12px; padding: 15px; border: 1px solid #f1f5f9; transition: 0.3s; }
        .stat-box:hover { background: #fff; border-color: #0f172a; }
        .badge-status { padding: 6px 14px; border-radius: 50px; font-weight: 600; font-size: 0.75rem; }
        .bg-pending { background: rgba(246,194,62,0.15); color: #d4a017; }
        .bg-diproses { background: rgba(54,185,204,0.15); color: #258391; }
        .bg-selesai { background: rgba(28,200,138,0.15); color: #13855c; }
        .bg-ditolak { background: rgba(231,74,59,0.15); color: #e74a3b; }
    </style>
</head>
<body>
    <?php include '../partials/user_navbar.php'; ?>

    <div class="container py-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h3 class="fw-bold mb-0" style="color: #1a202c;">Profil Saya</h3>
            <a href="pengaturan.php" class="btn btn-navy fw-bold rounded-pill px-4 d-flex align-items-center gap-2" style="background: #0f172a; color: #fff;">
                <i data-lucide="settings" style="width: 18px; height: 18px;"></i> Edit Profil
            </a>
        </div>

        <div class="row g-4">
            <!-- Profil Card -->
            <div class="col-md-4">
                <div class="card-custom p-4 text-center">
                    <div class="avatar-lg mb-3">
                        <?php if(!empty($user['foto'])): ?>
                            <img src="../assets/upload/profil/<?= $user['foto'] ?>" class="w-100 h-100" style="object-fit: cover;">
                        <?php else: ?>
                            <?= strtoupper(substr($user['nama'] ?? 'U', 0, 1)) ?>
                        <?php endif; ?>
                    </div>
                    <h4 class="fw-bold text-dark mb-1"><?= htmlspecialchars($user['nama'] ?? 'User') ?></h4>
                    <p class="text-muted mb-3"><?= htmlspecialchars($user['nim'] ?? 'NIM') ?></p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">Mahasiswa</span>
                    </div>
                    
                    <hr class="text-muted opacity-25">
                    
                    <div class="row text-center mt-3 g-2">
                        <div class="col-4">
                            <div class="stat-box">
                                <h5 class="fw-bold mb-0 text-dark"><?= $total ?></h5>
                                <small class="text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">TOTAL</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box">
                                <h5 class="fw-bold mb-0 text-warning"><?= $pending ?></h5>
                                <small class="text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">PENDING</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box">
                                <h5 class="fw-bold mb-0 text-success"><?= $selesai ?></h5>
                                <small class="text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">SELESAI</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Detail & Histori -->
            <div class="col-md-8">
                <!-- Data Akun -->
                <div class="card-custom p-4 mb-4">
                    <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                        <i data-lucide="lock" style="width: 20px; height: 20px; color: #0f172a;"></i> Informasi Akun
                    </h5>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label text-muted fw-bold small text-uppercase">Nama Lengkap</label>
                            <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($user['nama'] ?? '') ?>" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted fw-bold small text-uppercase">NIM / ID Pengguna</label>
                            <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($user['nim'] ?? '') ?>" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted fw-bold small text-uppercase">Divisi / Jabatan</label>
                            <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($user['divisi'] ?? '-') ?>" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted fw-bold small text-uppercase">Bergabung Sejak</label>
                            <input type="text" class="form-control bg-light" value="<?= isset($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : '-' ?>" readonly>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-top">
                        <p class="text-muted small mb-0"><em>Catatan: Data ini bersifat readonly. Klik tombol "Edit Profil" untuk memperbarui informasi Anda.</em></p>
                    </div>
                </div>

                <!-- Histori Singkat -->
                <div class="card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                            <i data-lucide="history" style="width: 20px; height: 20px; color: #0f172a;"></i> Aktivitas Terakhir
                        </h5>
                        <a href="laporan.php" class="btn btn-sm btn-light fw-bold rounded-pill px-3">Lihat Semua</a>
                    </div>

                    <?php if (!$laporan || mysqli_num_rows($laporan) == 0): ?>
                        <div class="text-center py-4 rounded-3" style="background: #f8f9fa;">
                            <i data-lucide="inbox" class="text-muted mb-2" style="width: 48px; height: 48px; opacity: 0.5;"></i>
                            <p class="text-muted mb-0">Belum ada aktivitas pelaporan.</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php while ($d = mysqli_fetch_assoc($laporan)): 
                                $status_class = 'bg-pending'; $status_text = 'Menunggu';
                                if($d['status'] == 'diproses') { $status_class = 'bg-diproses'; $status_text = 'Diproses'; }
                                if($d['status'] == 'selesai') { $status_class = 'bg-selesai'; $status_text = 'Selesai'; }
                                if($d['status'] == 'ditolak') { $status_class = 'bg-ditolak'; $status_text = 'Ditolak'; }
                            ?>
                                <a href="detail_laporan.php?id=<?= $d['id'] ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0 py-3 border-light">
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1"><?= htmlspecialchars($d['judul']) ?></h6>
                                        <small class="text-muted d-flex align-items-center gap-1"><i data-lucide="calendar" style="width: 12px; height: 12px;"></i> <?= date('d M Y', strtotime($d['created_at'])) ?> • <?= htmlspecialchars(ucwords($d['kategori'])) ?></small>
                                    </div>
                                    <span class="badge-status <?= $status_class ?>"><?= $status_text ?></span>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
