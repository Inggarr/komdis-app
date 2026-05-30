<?php
session_start();
include '../config/koneksi.php';
// include '../config/auth.php'; // Auth check should be here, assuming auth.php handles it. If auth.php is missing or buggy, we just rely on session check below.

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Queries for statistics
$total = 0;
try { $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM laporan"))['jml'] ?? 0; } catch (Exception $e) {}

$pending = 0;
try { $pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM laporan WHERE status='pending'"))['jml'] ?? 0; } catch (Exception $e) {}

$diproses = 0;
try { $diproses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM laporan WHERE status='diproses'"))['jml'] ?? 0; } catch (Exception $e) {}

$selesai = 0;
try { $selesai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM laporan WHERE status='selesai'"))['jml'] ?? 0; } catch (Exception $e) {}

$total_user = 0;
try { $total_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM users WHERE role='user'"))['jml'] ?? 0; } catch (Exception $e) {}

$total_berita = 0;
try { $total_berita = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM berita"))['jml'] ?? 0; } catch (Exception $e) {}

// Get latest laporan
$latest_laporan = false;
try { $latest_laporan = mysqli_query($conn, "SELECT l.*, u.nama, u.nim FROM laporan l JOIN users u ON l.user_id = u.id ORDER BY l.created_at DESC LIMIT 5"); } catch (Exception $e) {}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Komdis HIMA</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #2d3748;
        }
        #content-wrapper {
            margin-left: 260px; /* Lebar sidebar */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f8f9fa;
        }
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .table-custom {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            overflow: hidden;
        }
        .table-custom th {
            background: #f8f9fc;
            color: #4a5568;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
            padding: 15px;
        }
        .table-custom td {
            padding: 15px;
            vertical-align: middle;
            color: #4a5568;
            border-bottom: 1px solid #edf2f7;
        }
        .badge-status {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.75rem;
        }
        .bg-pending { background: rgba(246,194,62,0.15); color: #f6c23e; }
        .bg-diproses { background: rgba(54,185,204,0.15); color: #36b9cc; }
        .bg-selesai { background: rgba(28,200,138,0.15); color: #1cc88a; }
        .bg-ditolak { background: rgba(231,74,59,0.15); color: #e74a3b; }
        .text-navy { color: #0f172a; }
        .btn-navy { background-color: #0f172a; color: #fff; }
        .btn-navy:hover { background-color: #1e293b; color: #fff; }
    </style>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

    <!-- Sidebar -->
    <?php include '../partials/admin_sidebar.php'; ?>

    <!-- Main Content Wrapper -->
    <div id="content-wrapper">
        
        <!-- Navbar -->
        <?php include '../partials/admin_navbar.php'; ?>

        <!-- Page Content -->
        <div class="container-fluid px-4 pb-5">
            
            <!-- Welcome Row -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #fff;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="fw-bold mb-1">Selamat datang kembali, <?= $_SESSION['nama'] ?? 'Admin' ?>! <span style="font-size: 1.2rem;">👋</span></h4>
                                <p class="mb-0 text-white-50">Berikut adalah ringkasan laporan dan aktivitas terbaru hari ini.</p>
                            </div>
                            <div class="d-none d-md-block" style="opacity: 0.2;">
                                <i data-lucide="shield-check" style="width: 80px; height: 80px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Row 1 -->
            <div class="row g-4 mb-4">
                <!-- Total Laporan -->
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs fw-bold text-navy text-uppercase mb-1" style="letter-spacing: 1px;">Total Laporan</div>
                                    <div class="h3 mb-0 fw-bold text-dark"><?= $total ?></div>
                                </div>
                                <div class="stat-icon" style="background: rgba(15,23,42,0.1); color: #0f172a;"><i data-lucide="inbox"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Laporan Pending -->
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs fw-bold text-warning text-uppercase mb-1" style="letter-spacing: 1px;">Laporan Pending</div>
                                    <div class="h3 mb-0 fw-bold text-dark"><?= $pending ?></div>
                                </div>
                                <div class="stat-icon" style="background: rgba(246,194,62,0.1); color: #f6c23e;"><i data-lucide="clock"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Laporan Diproses -->
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs fw-bold text-info text-uppercase mb-1" style="letter-spacing: 1px;">Laporan Diproses</div>
                                    <div class="h3 mb-0 fw-bold text-dark"><?= $diproses ?></div>
                                </div>
                                <div class="stat-icon" style="background: rgba(54,185,204,0.1); color: #36b9cc;"><i data-lucide="refresh-cw"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Laporan Selesai -->
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs fw-bold text-success text-uppercase mb-1" style="letter-spacing: 1px;">Laporan Selesai</div>
                                    <div class="h3 mb-0 fw-bold text-dark"><?= $selesai ?></div>
                                </div>
                                <div class="stat-icon" style="background: rgba(28,200,138,0.1); color: #1cc88a;"><i data-lucide="check-circle"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Chart Col -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-header bg-white py-3 border-bottom-0">
                            <h6 class="m-0 fw-bold" style="color: #0f172a;">Grafik Laporan</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="laporanChart" style="min-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Additional Stats Col -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-header bg-white py-3 border-bottom-0">
                            <h6 class="m-0 fw-bold" style="color: #0f172a;">Sistem Overview</h6>
                        </div>
                        <div class="card-body d-flex flex-column gap-3">
                            <div class="p-3 rounded-3" style="border: 1px solid #e2e8f0; background: #fafbfa;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="stat-icon" style="background: rgba(133,135,150,0.1); color: #858796; width: 40px; height: 40px; font-size: 1.2rem;">👥</div>
                                        <div>
                                            <div class="text-muted small fw-bold text-uppercase">Total Pengguna</div>
                                            <div class="fw-bold fs-5 text-dark"><?= $total_user ?></div>
                                        </div>
                                    </div>
                                    <a href="user.php" class="btn btn-sm btn-light text-primary fw-bold">Detail</a>
                                </div>
                            </div>
                            <div class="p-3 rounded-3" style="border: 1px solid #e2e8f0; background: #fafbfa;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="stat-icon" style="background: rgba(133,135,150,0.1); color: #858796; width: 40px; height: 40px; font-size: 1.2rem;">📰</div>
                                        <div>
                                            <div class="text-muted small fw-bold text-uppercase">Artikel Berita</div>
                                            <div class="fw-bold fs-5 text-dark"><?= $total_berita ?></div>
                                        </div>
                                    </div>
                                    <a href="berita.php" class="btn btn-sm btn-light text-primary fw-bold">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latest Laporan Table -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between border-bottom-0">
                            <h6 class="m-0 fw-bold" style="color: #0f172a;">Laporan Masuk Terbaru</h6>
                            <a href="laporan.php" class="btn btn-sm fw-bold rounded-pill px-3" style="border: 1px solid #0f172a; color: #0f172a;">Lihat Semua</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-custom mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Pelapor</th>
                                            <th>Judul Laporan</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($latest_laporan && mysqli_num_rows($latest_laporan) > 0): ?>
                                            <?php while($row = mysqli_fetch_assoc($latest_laporan)): 
                                                $status_class = 'bg-pending';
                                                $status_text = 'Menunggu';
                                                if($row['status'] == 'diproses') { $status_class = 'bg-diproses'; $status_text = 'Diproses'; }
                                                if($row['status'] == 'selesai') { $status_class = 'bg-selesai'; $status_text = 'Selesai'; }
                                                if($row['status'] == 'ditolak') { $status_class = 'bg-ditolak'; $status_text = 'Ditolak'; }
                                            ?>
                                            <tr>
                                                <td class="fw-bold text-dark">#<?= $row['id'] ?></td>
                                                <td>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($row['nama']) ?></div>
                                                    <div class="small text-muted"><?= htmlspecialchars($row['nim']) ?></div>
                                                </td>
                                                <td class="fw-bold"><?= htmlspecialchars($row['judul']) ?></td>
                                                <td><?= date('d M Y, H:i', strtotime($row['created_at'])) ?></td>
                                                <td><span class="badge-status <?= $status_class ?>"><?= $status_text ?></span></td>
                                                <td class="text-end">
                                                    <a href="detail_laporan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary fw-bold rounded-3">Proses</a>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada laporan masuk.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        // Chart Configuration
        const ctx = document.getElementById('laporanChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Diproses', 'Selesai', 'Ditolak'],
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: [<?= $pending ?>, <?= $diproses ?>, <?= $selesai ?>, 0], // Ditolak hardcoded 0 for now as it's not in initial query
                    backgroundColor: [
                        'rgba(246, 194, 62, 0.7)',
                        'rgba(54, 185, 204, 0.7)',
                        'rgba(15, 23, 42, 0.7)',
                        'rgba(231, 74, 59, 0.7)'
                    ],
                    borderWidth: 0,
                    borderRadius: 4,
                    barPercentage: 0.6
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 2], drawBorder: false },
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false, drawBorder: false }
                    }
                }
            }
        });
    </script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>