<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-4" style="height: 70px; border-bottom: 1px solid rgba(0,0,0,0.05);">
    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <h5 class="mb-0 fw-bold" style="color: #1a202c;">
            <?php 
                $page_title = 'Dashboard Overview';
                $cur = basename($_SERVER['PHP_SELF']);
                if($cur == 'laporan.php') $page_title = 'Data Laporan Masuk';
                if($cur == 'detail_laporan.php') $page_title = 'Detail & Proses Laporan';
                if($cur == 'berita.php') $page_title = 'Kelola Artikel Berita';
                if($cur == 'aturan.php') $page_title = 'Kelola Tata Tertib';
                if($cur == 'faq.php') $page_title = 'Kelola Frequently Asked Questions';
                if($cur == 'pengumuman.php') $page_title = 'Kelola Pengumuman';
                if($cur == 'user.php') $page_title = 'Kelola Akun Pengguna';
                if($cur == 'statistik.php') $page_title = 'Laporan & Statistik';
                echo $page_title;
            ?>
        </h5>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ms-auto align-items-center gap-3">
        
        <li class="nav-item">
            <a class="nav-link btn btn-light btn-sm px-3 rounded-pill d-flex align-items-center gap-2" href="../guest/home.php" target="_blank" style="font-size: 0.85rem; font-weight: 600; color: #0f172a;">
                <i data-lucide="globe" style="width: 14px; height: 14px;"></i> Lihat Website
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block" style="width: 1px; height: 30px; background: rgba(0,0,0,0.1);"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-decoration-none" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="text-end d-none d-lg-block">
                    <span class="d-block small fw-bold" style="color: #2d3748; line-height: 1;"><?= $_SESSION['nama'] ?? 'Admin' ?></span>
                    <span class="d-block" style="font-size: 0.7rem; color: #718096; text-transform: capitalize;"><?= $_SESSION['role'] ?? 'Administrator' ?></span>
                </div>
                <div class="rounded-circle shadow-sm" style="width: 38px; height: 38px; background: #0f172a; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                    <?= substr($_SESSION['nama'] ?? 'A', 0, 1) ?>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in border-0 mt-2 p-2 rounded-3" aria-labelledby="userDropdown">
                <li><a class="dropdown-item rounded mb-1 d-flex align-items-center gap-2" href="#"><i data-lucide="user" style="width: 14px; height: 14px;"></i> Profil Saya</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item rounded text-danger fw-bold d-flex align-items-center gap-2" href="../auth/logout.php"><i data-lucide="log-out" style="width: 14px; height: 14px;"></i> Logout</a></li>
            </ul>
        </li>

    </ul>
</nav>
