<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_SESSION['id'];

// Mengambil statistik
$total = 0; $pending = 0; $diproses = 0; $selesai = 0; $ditolak = 0;
try {
    $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM laporan WHERE user_id='$id'"))['jml'] ?? 0;
    $pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM laporan WHERE user_id='$id' AND status='pending'"))['jml'] ?? 0;
    $diproses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM laporan WHERE user_id='$id' AND status='diproses'"))['jml'] ?? 0;
    $selesai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM laporan WHERE user_id='$id' AND status='selesai'"))['jml'] ?? 0;
} catch (Exception $e) {}

// Mengambil 5 laporan terbaru
$latest_laporan = false;
try {
    $latest_laporan = mysqli_query($conn, "SELECT * FROM laporan WHERE user_id='$id' ORDER BY created_at DESC LIMIT 5");
} catch (Exception $e) {}

// Mengambil 3 berita terbaru
$latest_berita = false;
try {
    $latest_berita = mysqli_query($conn, "SELECT * FROM berita ORDER BY created_at DESC LIMIT 3");
} catch (Exception $e) {}

// Mengambil 3 aturan terbaru
$latest_aturan = false;
try {
    $latest_aturan = mysqli_query($conn, "SELECT * FROM aturan ORDER BY id ASC LIMIT 3");
} catch (Exception $e) {}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - Komdis HIMA</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfdfe;
            color: #1a202c;
        }
        .container-custom { max-width: 1000px; margin: 0 auto; }
        
        .hero-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 24px;
            padding: 60px 40px;
            margin-bottom: 40px;
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
            position: relative;
            overflow: hidden;
            color: #fff;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            pointer-events: none;
        }
        
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 50px;
        }
        @media (max-width: 768px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
        
        .stat-card {
            background: #fff;
            padding: 24px;
            border-radius: 20px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            text-align: center;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.05);
            border-color: #0f172a;
        }
        .stat-val { font-size: 2rem; font-weight: 800; margin-bottom: 4px; color: #0f172a; }
        .stat-label { font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }

        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #0f172a;
        }
        .section-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: #0f172a;
            border-radius: 10px;
        }

        .content-card {
            background: #f8fafc;
            border-radius: 24px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-left: 6px solid #0f172a;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            padding: 30px;
            margin-bottom: 50px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
        }

        .content-card:hover {
            background: #fff;
            transform: translateY(-8px);
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.08);
            border-color: #0f172a;
        }

        .table-custom th { background: transparent; color: #64748b; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #f8fafc; padding: 15px; }
        .table-custom td { padding: 20px 15px; vertical-align: middle; border-bottom: 1px solid #f8fafc; }

        .badge-pill { padding: 6px 16px; border-radius: 50px; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; }
        .bg-pending { background: rgba(246,194,62,0.1); color: #d4a017; }
        .bg-diproses { background: rgba(54,185,204,0.1); color: #258391; }
        .bg-selesai { background: rgba(28,200,138,0.1); color: #13855c; }

        .news-item {
            display: flex;
            gap: 20px;
            padding: 20px;
            border-radius: 20px;
            transition: 0.3s;
            text-decoration: none;
            color: inherit;
            border: 1px solid transparent;
            background: rgba(255,255,255,0.5);
            margin-bottom: 10px;
        }
        .news-item:hover { 
            background: #fff; 
            transform: translateX(10px); 
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border-color: #f1f5f9;
        }
        .news-img { width: 100px; height: 100px; border-radius: 15px; object-fit: cover; background: #f8fafc; flex-shrink: 0; }

        .rule-card {
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            padding: 20px;
            border-radius: 18px;
            margin-bottom: 15px;
            transition: 0.3s;
        }
        .rule-card:hover { border-color: #0f172a; background: #fff; }

        .contact-box {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #fff;
            border-radius: 24px;
            padding: 50px 40px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
        }
        .btn-navy { background-color: #0f172a; color: #fff; border: none; }
        .btn-navy:hover { background-color: #1e293b; color: #fff; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(15, 23, 42, 0.2); }
        .btn-green-light { background: #1cc88a; color: #fff; border: none; }
        .btn-green-light:hover { background: #17a673; color: #fff; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(28, 200, 138, 0.2); }
    </style>
</head>
<body>

    <?php include '../partials/user_navbar.php'; ?>

    <div class="container container-custom py-5">
        
        <!-- Hero Section -->
        <div class="hero-section text-center">
            <h1 class="fw-bold mb-3" style="font-size: 2.8rem; letter-spacing: -1.5px;">Halo, <?= explode(' ', $_SESSION['nama'])[0] ?>! <span style="font-size: 2.5rem;">✨</span></h1>
            <p class="mb-4 mx-auto" style="max-width: 550px; color: rgba(255,255,255,0.7); font-size: 1.1rem; line-height: 1.6;">Pantau pengaduanmu dan dapatkan informasi terbaru seputar kedisiplinan kampus dalam satu genggaman.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="tambah_laporan.php" class="btn btn-green-light fw-bold px-4 py-3 rounded-pill shadow-sm">+ Buat Laporan</a>
                <a href="laporan.php" class="btn btn-outline-light fw-bold px-4 py-3 rounded-pill">Riwayat Laporan</a>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="stat-grid">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-center mb-2" style="color: #0f172a; opacity: 0.8;">
                    <i data-lucide="clipboard-list" style="width: 24px; height: 24px;"></i>
                </div>
                <div class="stat-val" style="color: #0f172a;"><?= $total ?></div>
                <div class="stat-label">Total Laporan</div>
            </div>
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-center mb-2" style="color: #0f172a; opacity: 0.8;">
                    <i data-lucide="clock" style="width: 24px; height: 24px;"></i>
                </div>
                <div class="stat-val" style="color: #0f172a;"><?= $pending ?></div>
                <div class="stat-label">Menunggu</div>
            </div>
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-center mb-2" style="color: #0f172a; opacity: 0.8;">
                    <i data-lucide="refresh-cw" style="width: 24px; height: 24px;"></i>
                </div>
                <div class="stat-val" style="color: #0f172a;"><?= $diproses ?></div>
                <div class="stat-label">Diproses</div>
            </div>
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-center mb-2" style="color: #0f172a; opacity: 0.8;">
                    <i data-lucide="check-circle" style="width: 24px; height: 24px;"></i>
                </div>
                <div class="stat-val" style="color: #0f172a;"><?= $selesai ?></div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>

        <!-- Latest Reports -->
        <div class="section-title">Laporan Terbarumu</div>
        <div class="content-card">
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Tiket</th>
                            <th>Judul Laporan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($latest_laporan && mysqli_num_rows($latest_laporan) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($latest_laporan)): 
                                $status_class = 'bg-pending'; $status_text = 'Pending';
                                if($row['status'] == 'diproses') { $status_class = 'bg-diproses'; $status_text = 'Proses'; }
                                if($row['status'] == 'selesai') { $status_class = 'bg-selesai'; $status_text = 'Selesai'; }
                            ?>
                            <tr>
                                <td class="fw-bold">#<?= $row['id'] ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($row['judul']) ?></td>
                                <td class="text-muted" style="font-size: 0.85rem;"><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                                <td><span class="badge-pill <?= $status_class ?>"><?= $status_text ?></span></td>
                                <td class="text-end">
                                    <a href="detail_laporan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-light fw-bold px-3 rounded-pill border">Detail</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada laporan terbaru.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Latest News Section -->
        <div class="section-title">Informasi & Berita</div>
        <div class="content-card">
            <?php if ($latest_berita && mysqli_num_rows($latest_berita) > 0): ?>
                <div class="row">
                    <?php while($row = mysqli_fetch_assoc($latest_berita)): ?>
                    <div class="col-12">
                        <a href="detail_berita.php?id=<?= $row['id'] ?>" class="news-item">
                            <div class="news-img d-flex align-items-center justify-content-center">
                                <?php if($row['thumbnail']): ?>
                                    <img src="../assets/upload/berita/<?= $row['thumbnail'] ?>" class="news-img">
                                <?php else: ?>
                                    <i data-lucide="newspaper" class="text-muted" style="width: 32px; height: 32px;"></i>
                                <?php endif; ?>
                            </div>
                            <div class="py-1">
                                <h5 class="fw-bold mb-1"><?= htmlspecialchars($row['judul']) ?></h5>
                                <p class="text-muted small mb-2"><?= substr(strip_tags($row['isi']), 0, 100) ?>...</p>
                                <span class="text-primary fw-bold small">Baca Selengkapnya →</span>
                            </div>
                        </a>
                    </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-muted mb-0">Belum ada berita terbaru.</p>
            <?php endif; ?>
        </div>

        <!-- Rules Section -->
        <div class="section-title">Aturan & Tata Tertib</div>
        <div class="content-card">
            <?php if ($latest_aturan && mysqli_num_rows($latest_aturan) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($latest_aturan)): ?>
                <div class="rule-card">
                    <h6 class="fw-bold mb-2 d-flex align-items-center gap-2"><i data-lucide="scale" style="width: 18px; height: 18px; color: #1cc88a;"></i> <?= htmlspecialchars($row['judul']) ?></h6>
                    <p class="text-muted small mb-0"><?= strip_tags($row['isi']) ?></p>
                </div>
                <?php endwhile; ?>
                <div class="text-center mt-3">
                    <a href="../guest/aturan.php" class="btn btn-sm btn-light fw-bold px-4 rounded-pill border">Lihat Semua Aturan</a>
                </div>
            <?php else: ?>
                <p class="text-center text-muted mb-0">Data aturan belum tersedia.</p>
            <?php endif; ?>
        </div>

        <!-- Contact Section -->
        <div class="contact-box">
            <h3 class="fw-bold mb-2">Butuh Bantuan Mendalam?</h3>
            <p class="text-white-50 mb-4">Tim Komdis siap mendengarkan pengaduanmu kapan saja.</p>
            <div class="d-flex justify-content-center gap-4 flex-wrap mb-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 rounded-circle" style="background: rgba(255,255,255,0.1);"><i data-lucide="phone" style="width: 20px; height: 20px; color: #1cc88a;"></i></div>
                    <div class="text-start">
                        <div class="small fw-bold">WhatsApp</div>
                        <div class="small text-white-50">+62 812 3456 7890</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 rounded-circle" style="background: rgba(255,255,255,0.1);"><i data-lucide="mail" style="width: 20px; height: 20px; color: #1cc88a;"></i></div>
                    <div class="text-start">
                        <div class="small fw-bold">Email</div>
                        <div class="small text-white-50">komdis@hima.univ.ac.id</div>
                    </div>
                </div>
            </div>
            <a href="../guest/kontak.php" class="btn btn-green-light fw-bold px-5 py-3 rounded-pill">Hubungi Kami Sekarang</a>
        </div>

    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>