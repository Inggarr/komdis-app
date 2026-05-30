<?php 
session_start();
include '../config/koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOMDIS HIMA — Komisi Disiplin</title>
    <meta name="description"
        content="Portal resmi Komisi Disiplin HIMA. Informasi aturan, berita, dan pengaduan disiplin mahasiswa.">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        /* ── RESET & BASE ── */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #ffffff;
            color: #121212;
            margin: 0;
            letter-spacing: -0.01em;
        }

        /* ── HERO ── */
        .hero {
            background: #ffffff;
            min-height: 90vh;
            display: flex;
            align-items: center;
            position: relative;
            padding: 60px 0;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f5f5f7;
            border: 1px solid #eeeeee;
            color: #121212;
            border-radius: 50px;
            padding: 8px 20px;
            font-size: .85rem;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .hero-title {
            font-size: clamp(2.8rem, 6vw, 4.2rem);
            font-weight: 800;
            color: #000000;
            line-height: 1.05;
            letter-spacing: -3px;
            margin-bottom: 25px;
        }

        .hero-title span {
            display: block;
            color: #475569;
        }

        .hero-desc {
            color: #666666;
            font-size: 1.15rem;
            line-height: 1.6;
            max-width: 540px;
            margin-bottom: 40px;
        }

        /* ── BUTTONS ── */
        .btn-hero-primary {
            background: #0f172a;
            color: #fff;
            border: none;
            padding: 16px 36px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all .3s ease;
            box-shadow: 0 10px 20px rgba(15,23,42,0.15);
        }

        .btn-hero-primary:hover {
            background: #333;
            transform: translateY(-2px);
            color: #fff;
        }

        .btn-hero-secondary {
            background: #ffffff;
            color: #000;
            border: 1px solid #e5e5e5;
            padding: 16px 36px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all .3s ease;
        }

        .btn-hero-secondary:hover {
            background: #f5f5f7;
            border-color: #000;
            color: #000;
        }

        /* ── FLOATING CARD (STATISTIK) ── */
        .hero-card-float {
            background: #ffffff;
            border: 1px solid #f0f0f0;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.06);
            border-radius: 40px;
            padding: 40px;
            position: relative;
            z-index: 2;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
        }

        .stat-item .num {
            font-size: 2.2rem;
            font-weight: 800;
            color: #000;
            letter-spacing: -2px;
        }

        .stat-item .num span {
            color: #0f172a;
        }

        .stat-item .lbl {
            font-size: .8rem;
            color: #888;
            margin-top: 5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ── FITUR & SECTION ── */
        .section {
            padding: 100px 0;
        }

        .section-label {
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 12px;
        }

        .section-title {
            font-size: 2.8rem;
            font-weight: 800;
            color: #000;
            letter-spacing: -1.5px;
            margin-bottom: 20px;
        }

        .section-sub {
            color: #666;
            font-size: 1.1rem;
            max-width: 600px;
        }

        .feature-card {
            background: #ffffff;
            border-radius: 35px;
            padding: 45px 35px;
            border: 1px solid #f1f5f9;
            transition: all .4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .feature-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 40px 80px rgba(15, 23, 42, 0.08);
            border-color: #0f172a;
        }

        .feature-icon {
            width: 65px;
            height: 65px;
            background: #f8fafc !important;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 25px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.02);
            transition: 0.3s;
            color: #0f172a;
        }

        .feature-card:hover .feature-icon {
            background: #0f172a !important;
            color: #fff !important;
        }

        .feature-card h5 {
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }

        .feature-card p {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .btn-feature-link {
            color: #0f172a;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .feature-card:hover .btn-feature-link {
            gap: 12px;
        }

        /* ── NEWS ── */
        .news-card {
            background: #fff;
            border-radius: 30px;
            overflow: hidden;
            border: 1px solid #f1f5f9;
            transition: all .4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
        }

        .news-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.1);
            border-color: #0f172a;
        }

        .news-card img {
            height: 220px;
            width: 100%;
            object-fit: cover;
            transition: 0.5s;
        }

        .news-card:hover img {
            transform: scale(1.05);
        }

        .news-no-img {
            height: 220px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .news-card .card-body {
            padding: 30px;
        }

        .news-card h6 {
            font-weight: 800;
            color: #0f172a;
            font-size: 1.2rem;
            margin-bottom: 12px;
            line-height: 1.4;
            letter-spacing: -0.5px;
            transition: 0.3s;
        }

        .news-card:hover h6 {
            color: #0f172a;
        }

        .news-card p {
            color: #64748b;
            font-size: .9rem;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        /* ── CTA ── */
        .cta-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 100px 0;
            border-radius: 50px;
            margin: 0 20px 60px;
            position: relative;
            overflow: hidden;
            color: #fff;
        }

        .cta-section .hero-title { color: #fff; }
        .cta-section .hero-desc { color: rgba(255,255,255,0.7); }
        .cta-section .hero-badge { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #fff; }

        .btn-cta-light {
            background: #fff;
            color: #0f172a;
            padding: 16px 36px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-cta-light:hover {
            background: #f8fafc;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .btn-cta-outline {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255,255,255,0.3);
            padding: 14px 36px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-cta-outline:hover {
            border-color: #fff;
            background: rgba(255,255,255,0.05);
        }

        /* ── FOOTER ── */
        .site-footer {
            background: #ffffff;
            padding: 80px 0 40px;
            border-top: 1px solid #f0f0f0;
        }

        .pulse-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #000;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 0, 0, .2);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
            }
        }

        /* Custom Button Style for Referensi */
        .btn-outline-dark-custom {
            border: 1px solid #ddd;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 700;
            font-size: 0.85rem;
            color: #000;
            transition: 0.3s;
        }

        .btn-outline-dark-custom:hover {
            background: #0f172a;
            color: #fff;
            border-color: #0f172a;
        }
    </style>
</head>

<body>
    <?php 
    if (isset($_SESSION['login']) && $_SESSION['role'] == 'user') {
        include '../partials/user_navbar.php';
    } else {
        include '../partials/guest_navbar.php';
    }
    ?>

    <!-- ══════════════════ HERO ══════════════════ -->
    <section class="hero">
        <div class="container position-relative">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <div class="hero-badge">
                        <i data-lucide="shield-check" style="width: 16px; height: 16px; color: #0f172a;"></i> Sistem Pengaduan Terpadu
                    </div>
                    <h1 class="hero-title">
                        Jaga Integritas<span>Bersama Komdis.</span>
                    </h1>
                    <p class="hero-desc">
                        Portal resmi Komisi Disiplin HIMA. Sistem informasi dan pengaduan terintegrasi untuk menjaga
                        integritas dan kedisiplinan organisasi.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <?php if (isset($_SESSION['login'])): ?>
                            <?php $dashboardUrl = ($_SESSION['role'] == 'admin') ? '../admin/dashboard.php' : '../user/dashboard.php'; ?>
                            <a href="<?= $dashboardUrl ?>" class="btn-hero-primary">Ke Dashboard</a>
                        <?php else: ?>
                            <a href="../auth/login.php" class="btn-hero-primary">Get Started</a>
                            <a href="../auth/register.php" class="btn-hero-secondary">Daftar Akun</a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="hero-card-float">
                        <p class="section-label text-center mb-4">Statistik Portal</p>
                        <div class="row g-0">
                            <div class="col-6 stat-item"
                                style="border-right:1px solid #f0f0f0; border-bottom:1px solid #f0f0f0;">
                                <?php
                                $jml_laporan = 0;
                                try {
                                    $jml_laporan = @mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM laporan"))[0] ?? 0;
                                } catch (Exception $e) {
                                }
                                ?>
                                <div class="num"><span><?= $jml_laporan ?></span></div>
                                <div class="lbl">Laporan</div>
                            </div>
                            <div class="col-6 stat-item" style="border-bottom:1px solid #f0f0f0;">
                                <?php
                                $jml_berita = 0;
                                try {
                                    $jml_berita = @mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM berita"))[0] ?? 0;
                                } catch (Exception $e) {
                                }
                                ?>
                                <div class="num"><span><?= $jml_berita ?></span></div>
                                <div class="lbl">Berita</div>
                            </div>
                            <div class="col-6 stat-item" style="border-right:1px solid #f0f0f0;">
                                <?php
                                $jml_aturan = 0;
                                try {
                                    $jml_aturan = @mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM aturan"))[0] ?? 0;
                                } catch (Exception $e) {
                                }
                                ?>
                                <div class="num"><span><?= $jml_aturan ?></span></div>
                                <div class="lbl">Pasal</div>
                            </div>
                            <div class="col-6 stat-item">
                                <?php
                                $jml_faq = 0;
                                try {
                                    $jml_faq = @mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM faq"))[0] ?? 0;
                                } catch (Exception $e) {
                                }
                                ?>
                                <div class="num"><span><?= $jml_faq ?></span></div>
                                <div class="lbl">FAQ</div>
                            </div>
                        </div>
                        <div class="mt-4 pt-2 d-flex align-items-center gap-3 justify-content-center">
                            <div class="pulse-dot"></div>
                            <small
                                style="color:#000; font-weight:700; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px;">Sistem
                                Aktif</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════ FITUR ══════════════════ -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 pb-3">
                <div class="section-label" style="color: #0f172a;">Core Services</div>
                <h2 class="section-title">Layanan Kami</h2>
                <p class="section-sub mx-auto">Pusat kendali kedisiplinan yang transparan dan mudah diakses.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i data-lucide="file-text"></i></div>
                        <h5>Tata Tertib</h5>
                        <p>Pahami landasan aturan organisasi yang berlaku.</p>
                        <a href="aturan.php" class="btn-feature-link">Explore More <i data-lucide="arrow-right" style="width: 16px;"></i></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i data-lucide="newspaper"></i></div>
                        <h5>Informasi</h5>
                        <p>Update kegiatan dan pengumuman resmi Komdis.</p>
                        <a href="berita.php" class="btn-feature-link">Explore More <i data-lucide="arrow-right" style="width: 16px;"></i></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i data-lucide="help-circle"></i></div>
                        <h5>FAQ</h5>
                        <p>Temukan jawaban cepat atas kendala umum.</p>
                        <a href="faq.php" class="btn-feature-link">Explore More <i data-lucide="arrow-right" style="width: 16px;"></i></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i data-lucide="send"></i></div>
                        <h5>Laporan</h5>
                        <p>Sistem pengaduan terenkripsi dan aman.</p>
                        <a href="../auth/login.php" class="btn-feature-link">Login First <i data-lucide="arrow-right" style="width: 16px;"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════ BERITA TERBARU ══════════════════ -->
    <?php
    $berita_list = false;
    try {
        $berita_list = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC LIMIT 3");
    } catch (Exception $e) {
    }
    if ($berita_list && mysqli_num_rows($berita_list) > 0):
        ?>
        <section class="section pt-0">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3">
                    <div>
                        <div class="section-label">Latest News</div>
                        <h2 class="section-title mb-0">Berita & Informasi</h2>
                    </div>
                    <a href="berita.php" class="btn-hero-secondary py-2 px-4">See All</a>
                </div>
                <div class="row g-4">
                    <?php while ($b = mysqli_fetch_assoc($berita_list)): ?>
                        <div class="col-md-4">
                            <div class="news-card border-0 shadow-sm">
                                <?php if (!empty($b['thumbnail'])): ?>
                                    <div class="overflow-hidden">
                                        <img src="../assets/upload/berita/<?= htmlspecialchars($b['thumbnail']) ?>"
                                            alt="<?= htmlspecialchars($b['judul']) ?>">
                                    </div>
                                <?php else: ?>
                                    <div class="news-no-img"><i data-lucide="newspaper" class="text-muted" style="width: 48px; height: 48px;"></i></div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <span class="section-label mb-2 d-block" style="font-size: 0.65rem; color: #0f172a;">Updates</span>
                                    <h6><?= htmlspecialchars($b['judul']) ?></h6>
                                    <p><?= htmlspecialchars(substr(strip_tags($b['isi']), 0, 80)) ?>...</p>
                                    <a href="detail_berita.php?id=<?= $b['id'] ?>"
                                        class="fw-bold text-navy text-decoration-none small d-flex align-items-center gap-2">Baca Selengkapnya <i data-lucide="arrow-right" style="width: 14px;"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ══════════════════ CTA ══════════════════ -->
    <section class="cta-section mx-md-5">
        <div class="container text-center position-relative" style="z-index: 2;">
            <div class="hero-badge mb-4"><i data-lucide="shield" style="width: 16px; height: 16px; color: #fff;"></i> Integrity First</div>
            <h2 class="hero-title mb-3">Punya Laporan<br>Pelanggaran?</h2>
            <p class="hero-desc mx-auto mb-5">
                Kami menjamin kerahasiaan identitas pelapor. Login sekarang untuk memulai proses pengaduan yang resmi.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <?php if (isset($_SESSION['login'])): ?>
                    <?php $dashboardUrl = ($_SESSION['role'] == 'admin') ? '../admin/dashboard.php' : '../user/dashboard.php'; ?>
                    <a href="<?= $dashboardUrl ?>" class="btn-cta-light"><i data-lucide="layout-dashboard" style="width: 18px; height: 18px;"></i> Ke Dashboard</a>
                <?php else: ?>
                    <a href="../auth/login.php" class="btn-cta-light"><i data-lucide="lock" style="width: 18px; height: 18px;"></i> Login Sekarang</a>
                    <a href="kontak.php" class="btn-cta-outline"><i data-lucide="mail" style="width: 18px; height: 18px;"></i> Kontak Komdis</a>
                <?php endif; ?>
            </div>
        </div>
        <!-- Decorative Background -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at top right, rgba(255,255,255,0.05) 0%, transparent 40%); pointer-events: none;"></div>
    </section>

    <!-- ══════════════════ FOOTER ══════════════════ -->
    <footer class="site-footer">
        <div class="container">
            <div class="row g-5 mb-5">
                <div class="col-md-5">
                    <h2 style="font-weight: 800; letter-spacing: -1.5px; margin-bottom: 25px;">komdis.</h2>
                    <p style="color:#888; line-height: 1.8; max-width: 350px;">Portal resmi Komisi Disiplin HIMA.
                        Menjaga integritas organisasi dengan transparansi penuh.</p>
                </div>
                <div class="col-md-3">
                    <h6
                        style="font-weight:800; margin-bottom:20px; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;">
                        Navigation</h6>
                    <ul class="list-unstyled" style="font-size:.95rem; line-height: 2.2;">
                        <li><a href="home.php" class="text-dark text-decoration-none">Beranda</a></li>
                        <li><a href="berita.php" class="text-dark text-decoration-none">Berita</a></li>
                        <li><a href="aturan.php" class="text-dark text-decoration-none">Aturan</a></li>
                        <li><a href="faq.php" class="text-dark text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6
                        style="font-weight:800; margin-bottom:20px; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;">
                        Contact Us</h6>
                    <p class="text-dark mb-1 fw-bold">komdis@hima.ac.id</p>
                    <p class="text-muted small">Gedung HIMA Lt. 2, Kampus Utama</p>
                </div>
            </div>
            <div class="pt-5 border-top d-flex justify-content-between align-items-center flex-wrap gap-3">
                <p style="font-size:.85rem;color:#888; margin:0;">© <?= date('Y') ?> Komdis HIMA. Minimalist Design
                    Concept.</p>
                <div class="d-flex gap-4">
                    <a href="#" class="text-dark text-decoration-none small fw-bold">Instagram</a>
                    <a href="#" class="text-dark text-decoration-none small fw-bold">Twitter</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>