<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Filter & search
$where = "WHERE 1=1";
if (!empty($_GET['cari'])) {
    $cari  = mysqli_real_escape_string($conn, $_GET['cari']);
    $where .= " AND laporan.judul LIKE '%$cari%'";
}
if (!empty($_GET['status'])) {
    $st    = mysqli_real_escape_string($conn, $_GET['status']);
    $where .= " AND laporan.status='$st'";
}
if (!empty($_GET['kategori'])) {
    $kat   = mysqli_real_escape_string($conn, $_GET['kategori']);
    $where .= " AND laporan.kategori='$kat'";
}

$data = mysqli_query($conn, "SELECT laporan.*, users.nama
    FROM laporan
    JOIN users ON laporan.user_id = users.id
    $where
    ORDER BY laporan.id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Laporan - Admin Komdis</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; color: #2d3748; }
        #content-wrapper { margin-left: 260px; min-height: 100vh; background: #f8f9fa; }
        .card-custom { background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.05); overflow: hidden; }
        .table-custom th { background: #f8f9fc; color: #4a5568; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #edf2f7; padding: 18px 20px; }
        .table-custom td { padding: 18px 20px; vertical-align: middle; color: #4a5568; border-bottom: 1px solid #edf2f7; }
        .badge-status { padding: 6px 12px; border-radius: 50px; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; }
        .bg-pending { background: rgba(246,194,62,0.15); color: #d4a017; }
        .bg-diproses { background: rgba(54,185,204,0.15); color: #258391; }
        .bg-selesai { background: rgba(28,200,138,0.15); color: #13855c; }
        .bg-ditolak { background: rgba(231,74,59,0.15); color: #e74a3b; }
        .form-control, .form-select { border-radius: 12px; padding: 10px 15px; border: 1px solid #e2e8f0; font-size: 0.9rem; }
        .text-navy { color: #0f172a; }
    </style>
</head>
<body>

    <?php include '../partials/admin_sidebar.php'; ?>

    <div id="content-wrapper">
        <?php include '../partials/admin_navbar.php'; ?>

        <div class="container-fluid px-4 pb-5">
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-0 text-navy d-flex align-items-center gap-2"><i data-lucide="inbox"></i> Manajemen Laporan</h4>
            </div>

            <!-- Filter Card -->
            <div class="card-custom p-4 mb-4">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted">Cari Laporan</label>
                        <input type="text" name="cari" class="form-control" placeholder="Judul laporan..." value="<?= htmlspecialchars($_GET['cari'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <?php foreach (['pending','diproses','selesai','ditolak'] as $s): ?>
                                <option value="<?= $s ?>" <?= (($_GET['status'] ?? '') == $s) ? 'selected' : '' ?>>
                                    <?= ucfirst($s) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            <?php
                            $kats = ['Pelanggaran Etika','Tindak Kekerasan','Penyalahgunaan Wewenang','Kehilangan Barang','Lainnya'];
                            foreach ($kats as $k):
                            ?>
                                <option value="<?= $k ?>" <?= (($_GET['kategori'] ?? '') == $k) ? 'selected' : '' ?>>
                                    <?= ucfirst($k) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn fw-bold rounded-pill py-2 w-100" style="background: #0f172a; color: #fff; border: none;">Filter</button>
                    </div>
                </form>
            </div>

            <!-- Data Table -->
            <div class="card-custom">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pelapor</th>
                                <th>Judul Laporan</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($data) == 0): ?>
                                <tr><td colspan="6" class="text-center py-5 text-muted">Tidak ada data laporan ditemukan.</td></tr>
                            <?php else: ?>
                                <?php $no = 1; while ($d = mysqli_fetch_assoc($data)): 
                                    $status_class = 'bg-pending'; $status_text = 'Pending';
                                    if($d['status'] == 'diproses') { $status_class = 'bg-diproses'; $status_text = 'Proses'; }
                                    if($d['status'] == 'selesai') { $status_class = 'bg-selesai'; $status_text = 'Selesai'; }
                                    if($d['status'] == 'ditolak') { $status_class = 'bg-ditolak'; $status_text = 'Ditolak'; }
                                ?>
                                <tr>
                                    <td class="fw-bold">#<?= $d['id'] ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($d['nama']) ?></div>
                                        <div class="small text-muted d-flex align-items-center gap-1"><i data-lucide="calendar" style="width: 12px; height: 12px;"></i> <?= date('d/m/Y', strtotime($d['created_at'])) ?></div>
                                    </td>
                                    <td class="fw-bold"><?= htmlspecialchars($d['judul']) ?></td>
                                    <td><span class="badge bg-light text-secondary border small px-2"><?= htmlspecialchars($d['kategori']) ?></span></td>
                                    <td><span class="badge-status <?= $status_class ?>"><?= $status_text ?></span></td>
                                    <td class="text-end">
                                        <a href="detail_laporan.php?id=<?= $d['id'] ?>" class="btn btn-sm fw-bold rounded-pill px-3 shadow-sm" style="border: 1px solid #0f172a; color: #0f172a;">Detail & Proses</a>
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

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>