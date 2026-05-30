<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$id   = $_SESSION['id'];
$data = false;
try {
    $data = mysqli_query($conn, "SELECT * FROM laporan WHERE user_id='$id' ORDER BY id DESC");
} catch(Exception $e){}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Laporan - Komdis HIMA</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #fdfdfd; color: #2d3748; }
        .table-custom { background: #fff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.05); overflow: hidden; }
        .table-custom th { background: #f8f9fc; color: #4a5568; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #edf2f7; padding: 18px 24px; }
        .table-custom td { padding: 18px 24px; vertical-align: middle; color: #4a5568; border-bottom: 1px solid #edf2f7; }
        
        .badge-status { padding: 6px 14px; border-radius: 50px; font-weight: 600; font-size: 0.75rem; display: inline-block; text-align: center; }
        .bg-pending { background: rgba(246,194,62,0.15); color: #d4a017; }
        .bg-diproses { background: rgba(54,185,204,0.15); color: #258391; }
        .bg-selesai { background: rgba(28,200,138,0.15); color: #13855c; }
        .bg-ditolak { background: rgba(231,74,59,0.15); color: #e74a3b; }
    </style>
</head>
<body>
    <?php include '../partials/user_navbar.php'; ?>

    <div class="container py-5">
        
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-<?= $_GET['msg'] == 'berhasil' ? 'success' : 'warning' ?> alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2" role="alert">
                <i data-lucide="<?= $_GET['msg'] == 'berhasil' ? 'check-circle' : 'trash-2' ?>" style="width: 20px; height: 20px;"></i>
                <strong class="mx-1"><?= $_GET['msg'] == 'berhasil' ? 'Berhasil!' : 'Dihapus!' ?></strong> 
                <?= $_GET['msg'] == 'berhasil' ? 'Laporan kamu sudah terkirim ke sistem.' : 'Laporan berhasil dibatalkan/dihapus.' ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h3 class="fw-bold mb-1" style="color: #1a202c;">Riwayat Laporan</h3>
                <p class="text-muted mb-0">Daftar semua laporan pelanggaran yang pernah kamu buat.</p>
            </div>
            <a href="tambah_laporan.php" class="btn btn-success fw-bold rounded-pill px-4 shadow-sm" style="background: #1cc88a; border: none;">+ Buat Laporan Baru</a>
        </div>

        <div class="table-responsive table-custom">
            <table class="table mb-0 border-0 table-hover">
                <thead>
                    <tr>
                        <th class="border-0">No. Tiket</th>
                        <th class="border-0">Informasi Laporan</th>
                        <th class="border-0">Kategori</th>
                        <th class="border-0">Status</th>
                        <th class="border-0 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($data && mysqli_num_rows($data) > 0): ?>
                        <?php while ($d = mysqli_fetch_assoc($data)): 
                            $status_class = 'bg-pending';
                            $status_text = 'Menunggu';
                            if($d['status'] == 'diproses') { $status_class = 'bg-diproses'; $status_text = 'Diproses'; }
                            if($d['status'] == 'selesai') { $status_class = 'bg-selesai'; $status_text = 'Selesai'; }
                            if($d['status'] == 'ditolak') { $status_class = 'bg-ditolak'; $status_text = 'Ditolak'; }
                        ?>
                            <tr>
                                <td class="fw-bold text-dark">#<?= str_pad($d['id'], 4, '0', STR_PAD_LEFT) ?></td>
                                <td>
                                    <div class="fw-bold text-dark mb-1" style="font-size: 0.95rem;"><?= htmlspecialchars($d['judul']) ?></div>
                                    <div class="small text-muted d-flex align-items-center gap-1"><i data-lucide="calendar" style="width: 12px; height: 12px;"></i> <?= date('d M Y, H:i', strtotime($d['created_at'])) ?></div>
                                </td>
                                <td><span class="badge bg-light text-secondary border px-2 py-1"><?= htmlspecialchars(ucwords($d['kategori'])) ?></span></td>
                                <td>
                                    <span class="badge-status <?= $status_class ?>"><?= $status_text ?></span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="detail_laporan.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-light fw-bold text-primary rounded-pill px-3 shadow-sm border">Detail</a>
                                        <?php if ($d['status'] == 'pending'): ?>
                                            <a href="../proses/laporan_proses.php?hapus=<?= $d['id'] ?>" class="btn btn-sm btn-light fw-bold text-danger rounded-pill px-3 shadow-sm border" onclick="return confirm('Kamu yakin ingin membatalkan dan menghapus laporan ini?')">Batal</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i data-lucide="inbox" class="text-muted mb-3" style="width: 64px; height: 64px; opacity: 0.5;"></i>
                                <h5 class="fw-bold text-dark">Riwayat Masih Kosong</h5>
                                <p class="text-muted">Kamu belum pernah membuat laporan pelanggaran apapun.</p>
                                <a href="tambah_laporan.php" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold mt-2">Buat Laporan Sekarang</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>