<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header("Location: laporan.php");
    exit;
}

$laporan   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT laporan.*, users.nama, users.nim, users.divisi
    FROM laporan JOIN users ON laporan.user_id = users.id WHERE laporan.id='$id'"));
$bukti     = mysqli_query($conn, "SELECT * FROM bukti WHERE laporan_id='$id'");
$tanggapan = mysqli_query($conn, "SELECT * FROM tanggapan WHERE laporan_id='$id' ORDER BY id ASC");

if (!$laporan) {
    header("Location: laporan.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan #<?= $id ?> - Admin Komdis</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; color: #2d3748; }
        #content-wrapper { margin-left: 260px; min-height: 100vh; background: #f8f9fa; }
        .card-custom { background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.05); overflow: hidden; }
        .badge-status { padding: 6px 12px; border-radius: 50px; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; }
        .bg-pending { background: rgba(246,194,62,0.15); color: #d4a017; }
        .bg-diproses { background: rgba(54,185,204,0.15); color: #258391; }
        .bg-selesai { background: rgba(28,200,138,0.15); color: #13855c; }
        .bg-ditolak { background: rgba(231,74,59,0.15); color: #e74a3b; }
        .chat-bubble { background: #fff; border-radius: 16px; border-bottom-left-radius: 4px; padding: 15px; margin-bottom: 15px; border: 1px solid #edf2f7; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        .timeline-item { border-left: 3px solid #e2e8f0; padding-left: 15px; margin-bottom: 20px; position: relative; }
        .timeline-item::before { content: ''; width: 12px; height: 12px; background: #e2e8f0; border-radius: 50%; position: absolute; left: -8px; top: 4px; }
        .timeline-item.active::before { background: #0f172a; box-shadow: 0 0 0 3px rgba(15,23,42,0.1); }
        .timeline-item.done::before { background: #0f172a; }
    </style>
</head>
<body>

    <?php include '../partials/admin_sidebar.php'; ?>

    <div id="content-wrapper">
        <?php include '../partials/admin_navbar.php'; ?>

        <div class="container-fluid px-4 pb-5">
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #0f172a;"><i data-lucide="file-text"></i> Detail Laporan #<?= str_pad($id, 4, '0', STR_PAD_LEFT) ?></h4>
                <a href="laporan.php" class="btn btn-light fw-bold rounded-pill px-4 border text-secondary">← Kembali</a>
            </div>

            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-pill px-4 mb-4 fw-bold small">
                    <?= $_GET['msg'] == 'status' ? '✅ Status laporan berhasil diperbarui!' : '💬 Tanggapan berhasil dikirim!' ?>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <div class="col-lg-8">
                    <!-- Info Laporan -->
                    <div class="card-custom p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h4 class="fw-bold text-dark mb-1"><?= htmlspecialchars($laporan['judul']) ?></h4>
                                <div class="text-muted small">ID Laporan: <code><?= $id ?></code> • <?= date('d M Y, H:i', strtotime($laporan['created_at'])) ?></div>
                            </div>
                            <?php 
                                $status_class = 'bg-pending'; $status_text = 'Pending';
                                if($laporan['status'] == 'diproses') { $status_class = 'bg-diproses'; $status_text = 'Proses'; }
                                if($laporan['status'] == 'selesai') { $status_class = 'bg-selesai'; $status_text = 'Selesai'; }
                                if($laporan['status'] == 'ditolak') { $status_class = 'bg-ditolak'; $status_text = 'Ditolak'; }
                            ?>
                            <span class="badge-status <?= $status_class ?> px-3 py-2"><?= $status_text ?></span>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <label class="form-label small fw-bold text-muted mb-1 d-block text-uppercase">Pelapor</label>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($laporan['nama']) ?></div>
                                    <div class="small text-muted"><?= htmlspecialchars($laporan['nim']) ?> • <?= htmlspecialchars($laporan['divisi']) ?></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <label class="form-label small fw-bold text-muted mb-1 d-block text-uppercase">Kategori & Lokasi</label>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($laporan['kategori']) ?></div>
                                    <div class="small text-muted">📍 <?= htmlspecialchars($laporan['lokasi'] ?? 'Lokasi tidak disebutkan') ?></div>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold text-dark mb-2 text-uppercase small">Kronologi Kejadian:</h6>
                        <div class="p-3 rounded-3 bg-light border-0 mb-4" style="background: #fafafa !important; line-height: 1.6;">
                            <?= nl2br(htmlspecialchars($laporan['kronologi'])) ?>
                        </div>

                        <?php if (mysqli_num_rows($bukti) > 0): ?>
                            <h6 class="fw-bold text-dark mb-2 text-uppercase small">Bukti Lampiran:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <?php while ($b = mysqli_fetch_assoc($bukti)): ?>
                                    <a href="../assets/upload/bukti/<?= htmlspecialchars($b['nama_file']) ?>" target="_blank" class="btn btn-sm btn-light border fw-bold rounded-3 px-3 d-inline-flex align-items-center gap-2" style="color: #0f172a;">
                                        <i data-lucide="file"></i> Lihat Bukti
                                    </a>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Tanggapan -->
                    <div class="card-custom p-4">
                        <h6 class="fw-bold text-dark mb-4 text-uppercase small">💬 Riwayat Tanggapan:</h6>
                        <div class="ps-3">
                            <?php if (mysqli_num_rows($tanggapan) == 0): ?>
                                <p class="text-muted small italic">Belum ada tanggapan yang diberikan untuk laporan ini.</p>
                            <?php else: ?>
                                <?php while ($t = mysqli_fetch_assoc($tanggapan)): ?>
                                    <div class="chat-bubble">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-bold text-dark small">Admin Komdis</span>
                                            <span class="text-muted small" style="font-size: 0.65rem;"><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></span>
                                        </div>
                                        <p class="mb-0 small text-dark"><?= nl2br(htmlspecialchars($t['isi'])) ?></p>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>

                        <hr class="my-4 opacity-25">
                        
                        <h6 class="fw-bold text-dark mb-3 text-uppercase small">Kirim Tanggapan Baru:</h6>
                         <form method="POST" action="../proses/admin_proses.php">
                            <input type="hidden" name="laporan_id" value="<?= $id ?>">
                            <textarea name="isi" class="form-control rounded-3 mb-3" rows="4" placeholder="Tulis instruksi atau tanggapan untuk mahasiswa..." required></textarea>
                            <button name="kirim_tanggapan" class="btn fw-bold rounded-pill px-4" style="background: #0f172a; color: #fff; border: none;">Kirim Tanggapan</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Update Status -->
                    <div class="card-custom p-4 mb-4">
                        <h6 class="fw-bold text-dark mb-3 text-uppercase small d-flex align-items-center gap-2"><i data-lucide="settings" style="width: 14px; height: 14px;"></i> Tindakan Admin</h6>
                        <form method="POST" action="../proses/admin_proses.php">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Ubah Status Laporan</label>
                                <select name="status" class="form-select fw-bold">
                                    <?php foreach (['pending','diproses','selesai','ditolak'] as $s): ?>
                                        <option value="<?= $s ?>" <?= ($laporan['status'] == $s) ? 'selected' : '' ?>>
                                            <?= ucfirst($s) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button name="update_status" class="btn fw-bold w-100 rounded-pill py-2" style="background: #0f172a; color: #fff; border: none;">Update Status Laporan</button>
                        </form>
                    </div>

                    <!-- Timeline -->
                    <div class="card-custom p-4">
                        <h6 class="fw-bold text-dark mb-4 text-uppercase small d-flex align-items-center gap-2"><i data-lucide="calendar" style="width: 14px; height: 14px;"></i> Timeline Progress</h6>
                        <?php
                        $steps = [
                            'pending'  => 'Laporan dikirim',
                            'diproses' => 'Sedang diproses',
                            'selesai'  => 'Selesai / Sanksi Diberikan',
                        ];
                        $order   = array_keys($steps);
                        $currIdx = array_search($laporan['status'], $order);
                        $isDitolak = $laporan['status'] == 'ditolak';

                        foreach ($steps as $i => $label):
                            $idx  = array_search($i, $order);
                            $cls  = '';
                            if (!$isDitolak) {
                                if ($idx < $currIdx)       $cls = 'done';
                                elseif ($idx == $currIdx)  $cls = 'active';
                            } else {
                                if ($i == 'pending') $cls = 'done';
                            }
                        ?>
                            <div class="timeline-item <?= $cls ?>">
                                <div class="fw-bold small <?= $cls ? 'text-dark' : 'text-muted' ?>"><?= $label ?></div>
                            </div>
                        <?php endforeach; ?>

                        <?php if ($isDitolak): ?>
                            <div class="timeline-item active" style="border-left-color: #e74a3b;">
                                <div class="fw-bold text-danger small">Laporan Ditolak</div>
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