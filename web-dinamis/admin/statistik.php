<?php
session_start();
include '../config/koneksi.php';
include '../config/auth.php';

if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}

// Statistik ringkas
function getCount($conn, $query) {
    $res = mysqli_query($conn, $query);
    if (!$res) return 0;
    $row = mysqli_fetch_assoc($res);
    return $row['jml'] ?? 0;
}

$total     = getCount($conn, "SELECT COUNT(*) as jml FROM laporan");
$pending   = getCount($conn, "SELECT COUNT(*) as jml FROM laporan WHERE status='pending'");
$diproses  = getCount($conn, "SELECT COUNT(*) as jml FROM laporan WHERE status='diproses'");
$selesai   = getCount($conn, "SELECT COUNT(*) as jml FROM laporan WHERE status='selesai'");
$ditolak   = getCount($conn, "SELECT COUNT(*) as jml FROM laporan WHERE status='ditolak'");
$totalUser = getCount($conn, "SELECT COUNT(*) as jml FROM users WHERE role='user'");

// Laporan per kategori
$kategoriData = mysqli_query($conn, "SELECT kategori, COUNT(*) as jml FROM laporan GROUP BY kategori ORDER BY jml DESC");
$katLabels = []; $katValues = [];
while ($k = mysqli_fetch_assoc($kategoriData)) {
    $katLabels[] = $k['kategori'];
    $katValues[] = $k['jml'];
}

// Laporan per bulan (12 bulan terakhir)
$bulanData = mysqli_query($conn, "
    SELECT DATE_FORMAT(created_at,'%b %Y') as bln, COUNT(*) as jml
    FROM laporan
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
    GROUP BY bln, DATE_FORMAT(created_at,'%Y-%m')
    ORDER BY MIN(created_at)
");
$bulanLabels = []; $bulanValues = [];
while ($b = mysqli_fetch_assoc($bulanData)) {
    $bulanLabels[] = $b['bln'];
    $bulanValues[] = $b['jml'];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Statistik - Admin Komdis</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; color: #2d3748; }
        #content-wrapper { margin-left: 260px; min-height: 100vh; background: #f8f9fa; }
        .card-custom { background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.05); overflow: hidden; }
        .stat-card { border-radius: 16px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
        .text-navy { color: #0f172a; }
    </style>
</head>

<body>
    <?php include '../partials/admin_sidebar.php'; ?>
    <div id="content-wrapper">
        <?php include '../partials/admin_navbar.php'; ?>
        <div class="container-fluid px-4 pb-5">
            <h4 class="fw-bold mb-4 text-navy d-flex align-items-center gap-2"><i data-lucide="bar-chart-3"></i> Statistik Laporan</h4>

            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-2 col-6">
                    <div class="card stat-card p-3 h-100" style="border-left: 4px solid #0f172a;">
                        <small class="text-muted fw-bold">Total</small>
                        <h4 class="fw-bold text-dark mt-1"><?= $total ?></h4>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="card stat-card p-3 h-100" style="border-left: 4px solid #f6c23e;">
                        <small class="text-muted fw-bold">Pending</small>
                        <h4 class="text-warning fw-bold mt-1"><?= $pending ?></h4>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="card stat-card p-3 h-100" style="border-left: 4px solid #36b9cc;">
                        <small class="text-muted fw-bold">Proses</small>
                        <h4 class="text-info fw-bold mt-1"><?= $diproses ?></h4>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="card stat-card p-3 h-100" style="border-left: 4px solid #1cc88a;">
                        <small class="text-muted fw-bold">Selesai</small>
                        <h4 class="text-success fw-bold mt-1"><?= $selesai ?></h4>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="card stat-card p-3 h-100" style="border-left: 4px solid #e74a3b;">
                        <small class="text-muted fw-bold">Ditolak</small>
                        <h4 class="text-danger fw-bold mt-1"><?= $ditolak ?></h4>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card-custom p-4">
                        <h6 class="fw-bold mb-3 text-navy d-flex align-items-center gap-2"><i data-lucide="trending-up" style="width: 16px;"></i> Laporan per Bulan</h6>
                        <canvas id="chartBulanan"></canvas>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card-custom p-4">
                        <h6 class="fw-bold mb-3 text-navy d-flex align-items-center gap-2"><i data-lucide="pie-chart" style="width: 16px;"></i> Laporan per Kategori</h6>
                        <canvas id="chartKategori"></canvas>
                    </div>
                </div>
            </div>

            <div class="card-custom p-4 mt-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 rounded-circle" style="background: rgba(15,23,42,0.1); color: #0f172a;">
                        <i data-lucide="users"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Total User Aktif</h6>
                        <p class="mb-0 text-muted small"><span class="text-navy fw-bold"><?= $totalUser ?></span> anggota terdaftar dalam sistem.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

<script>
// Grafik Bulanan
new Chart(document.getElementById('chartBulanan'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($bulanLabels) ?>,
        datasets: [{
            label: 'Jumlah Laporan',
            data: <?= json_encode($bulanValues) ?>,
            backgroundColor: 'rgba(15, 23, 42, 0.7)',
            borderColor: '#0f172a',
            borderWidth: 1,
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

// Grafik Kategori
new Chart(document.getElementById('chartKategori'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($katLabels) ?>,
        datasets: [{
            data: <?= json_encode($katValues) ?>,
            backgroundColor: ['#0f172a','#1cc88a','#36b9cc','#f6c23e','#e74a3b','#6f42c1']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});
    lucide.createIcons();
</script>
</body>
</html>
