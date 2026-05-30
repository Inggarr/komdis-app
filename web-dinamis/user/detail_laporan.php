<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header("Location: laporan.php");
    exit;
}

// Pastikan laporan milik user yang login
$laporan = false;
try {
    $laporan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM laporan WHERE id='$id' AND user_id='{$_SESSION['id']}'"));
} catch (Exception $e){}

if (!$laporan) {
    header("Location: laporan.php");
    exit;
}

$bukti = false;
$tanggapan = false;
try {
    $bukti     = mysqli_query($conn, "SELECT * FROM bukti WHERE laporan_id='$id'");
    $tanggapan = mysqli_query($conn, "SELECT * FROM tanggapan WHERE laporan_id='$id' ORDER BY id ASC");
} catch (Exception $e){}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan #<?= str_pad($laporan['id'], 4, '0', STR_PAD_LEFT) ?> - Komdis</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #fdfdfd; color: #2d3748; }
        .card-custom { background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05); }
        .badge-status { padding: 6px 14px; border-radius: 50px; font-weight: 600; font-size: 0.75rem; display: inline-block; text-align: center; }
        .bg-pending { background: rgba(246,194,62,0.15); color: #d4a017; }
        .bg-diproses { background: rgba(54,185,204,0.15); color: #258391; }
        .bg-selesai { background: rgba(28,200,138,0.15); color: #13855c; }
        .bg-ditolak { background: rgba(231,74,59,0.15); color: #e74a3b; }
        
        .chat-bubble { background: #fff; border-radius: 16px; border-bottom-left-radius: 4px; padding: 16px 20px; position: relative; margin-bottom: 25px; border: 1px solid #e2e8f0; margin-left: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        .chat-bubble-icon { position: absolute; left: -45px; top: 0; background: #0f172a; color: #fff; width: 35px; height: 35px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        
        .timeline { position: relative; padding-left: 30px; margin-top: 20px; }
        .timeline::before { content: ''; position: absolute; left: 11px; top: 0; bottom: 0; width: 2px; background: #e2e8f0; }
        .timeline-item { position: relative; margin-bottom: 25px; }
        .timeline-item::before { content: ''; position: absolute; left: -25px; top: 5px; width: 14px; height: 14px; border-radius: 50%; background: #e2e8f0; border: 3px solid #fff; box-shadow: 0 0 0 2px #e2e8f0; }
        .timeline-item.active::before { background: #0f172a; box-shadow: 0 0 0 2px #0f172a; }
        .timeline-item.done::before { background: #0f172a; box-shadow: 0 0 0 2px #0f172a; }
        .timeline-item.rejected::before { background: #e74a3b; box-shadow: 0 0 0 2px #e74a3b; }
    </style>
</head>
<body>
    <?php include '../partials/user_navbar.php'; ?>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Tiket Laporan #<?= str_pad($laporan['id'], 4, '0', STR_PAD_LEFT) ?></h4>
            <a href="laporan.php" class="btn btn-light fw-bold text-secondary rounded-pill px-4 shadow-sm border">← Kembali</a>
        </div>

        <div class="row g-4">
            <!-- Konten Utama -->
            <div class="col-lg-8">
                
                <!-- Info Laporan -->
                <div class="card-custom p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h4 class="fw-bold text-dark mb-2"><?= htmlspecialchars($laporan['judul']) ?></h4>
                            <div class="d-flex flex-wrap gap-3 text-muted small fw-medium">
                                <span class="d-flex align-items-center gap-1"><i data-lucide="calendar" style="width: 14px; height: 14px;"></i> <?= date('d M Y, H:i', strtotime($laporan['created_at'])) ?></span>
                                <span class="d-flex align-items-center gap-1"><i data-lucide="tag" style="width: 14px; height: 14px;"></i> <?= htmlspecialchars(ucwords($laporan['kategori'])) ?></span>
                            </div>
                        </div>
                        <?php 
                            $status_class = 'bg-pending'; $status_text = 'Menunggu';
                            if($laporan['status'] == 'diproses') { $status_class = 'bg-diproses'; $status_text = 'Diproses'; }
                            if($laporan['status'] == 'selesai') { $status_class = 'bg-selesai'; $status_text = 'Selesai'; }
                            if($laporan['status'] == 'ditolak') { $status_class = 'bg-ditolak'; $status_text = 'Ditolak'; }
                        ?>
                        <span class="badge-status <?= $status_class ?> px-3 py-2 fs-6"><?= $status_text ?></span>
                    </div>

                    <?php if (!empty($laporan['lokasi'])): ?>
                    <div class="mb-4 p-3 rounded-3" style="background: #f8f9fa; border: 1px solid #e2e8f0;">
                        <small class="text-muted d-flex align-items-center gap-1 fw-bold mb-1 text-uppercase" style="letter-spacing: 1px;"><i data-lucide="map-pin" style="width: 12px; height: 12px;"></i> Lokasi Kejadian</small>
                        <span class="fw-bold text-dark"><?= htmlspecialchars($laporan['lokasi']) ?></span>
                    </div>
                    <?php endif; ?>

                    <h6 class="fw-bold text-dark mb-2">Kronologi Kejadian:</h6>
                    <div class="p-3 rounded-3 mb-4 text-dark" style="background: #fafbfa; border: 1px solid #edf2f7; line-height: 1.6;">
                        <?= nl2br(htmlspecialchars($laporan['kronologi'])) ?>
                    </div>

                    <!-- Bukti -->
                    <?php if ($bukti && mysqli_num_rows($bukti) > 0): ?>
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2"><i data-lucide="paperclip" style="width: 18px; height: 18px;"></i> Bukti Terlampir:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <?php while ($b = mysqli_fetch_assoc($bukti)): ?>
                                <a href="../assets/upload/bukti/<?= htmlspecialchars($b['nama_file']) ?>" target="_blank" class="btn btn-light border text-primary fw-bold shadow-sm d-flex align-items-center gap-2">
                                    <i data-lucide="file-text" style="width: 16px; height: 16px;"></i> Lihat Dokumen
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Tanggapan Admin -->
                <div class="card-custom p-4">
                    <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                        <i data-lucide="gavel" style="width: 24px; height: 24px; color: #1cc88a;"></i> Tanggapan Komdis
                    </h5>
                    
                    <div class="ps-4">
                        <?php if (!$tanggapan || mysqli_num_rows($tanggapan) == 0): ?>
                            <div class="text-center py-4">
                                <i data-lucide="hourglass" class="text-muted mb-2" style="width: 48px; height: 48px; opacity: 0.5;"></i>
                                <p class="text-muted fw-medium">Belum ada tanggapan atau instruksi dari pihak Komdis. Harap menunggu proses verifikasi.</p>
                            </div>
                        <?php else: ?>
                            <?php while ($t = mysqli_fetch_assoc($tanggapan)): ?>
                                <div class="chat-bubble">
                                    <div class="chat-bubble-icon">
                                        <i data-lucide="message-square" style="width: 18px; height: 18px;"></i>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-bold text-dark">Admin Komdis</span>
                                        <small class="text-muted"><?= date('d M Y, H:i', strtotime($t['created_at'])) ?></small>
                                    </div>
                                    <p class="mb-0 text-dark" style="line-height: 1.5;"><?= nl2br(htmlspecialchars($t['isi'])) ?></p>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar: Timeline -->
            <div class="col-lg-4">
                <div class="card-custom p-4 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-4">Status Proses</h5>
                    
                    <div class="timeline">
                        <?php
                        $steps = [
                            'pending'  => ['title' => 'Laporan Diterima', 'desc' => 'Menunggu verifikasi admin'],
                            'diproses' => ['title' => 'Sedang Diproses', 'desc' => 'Admin sedang menginvestigasi'],
                            'selesai'  => ['title' => 'Kasus Selesai', 'desc' => 'Tindakan sudah diambil'],
                        ];
                        
                        $isDitolak = $laporan['status'] == 'ditolak';
                        $status_arr = array_keys($steps);
                        $current_idx = array_search($laporan['status'], $status_arr);
                        
                        foreach ($status_arr as $i => $status_key) {
                            $class = '';
                            if (!$isDitolak) {
                                if ($i < $current_idx) $class = 'done';
                                else if ($i == $current_idx) $class = 'active';
                            } else {
                                if ($status_key == 'pending') $class = 'done'; // Tetap hijau karena diterima
                            }
                            
                            echo '<div class="timeline-item '.$class.'">';
                            echo '<h6 class="fw-bold mb-1 '.($class ? 'text-dark' : 'text-muted').'">'.$steps[$status_key]['title'].'</h6>';
                            echo '<p class="small text-muted mb-0">'.$steps[$status_key]['desc'].'</p>';
                            echo '</div>';
                        }
                        
                        if ($isDitolak) {
                            echo '<div class="timeline-item rejected">';
                            echo '<h6 class="fw-bold text-danger mb-1">Laporan Ditolak</h6>';
                            echo '<p class="small text-muted mb-0">Laporan dianggap tidak valid atau kurang bukti.</p>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>