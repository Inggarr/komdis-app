<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar text-white shadow" style="width: 260px; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 1000; overflow-y: auto; background-color: #0f172a !important;">
    <div class="p-4 d-flex align-items-center gap-3">
        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #0f172a, #1e293b); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 900; font-size: 1.4rem; box-shadow: 0 4px 10px rgba(15,23,42,0.3);"><i data-lucide="scale" style="width: 24px; height: 24px;"></i></div>
        <div>
            <h5 class="mb-0 fw-bold" style="letter-spacing: 0.5px;">KOMDIS</h5>
            <small style="font-size: 0.7rem; color: #9ca3af; letter-spacing: 1px;">ADMIN PANEL</small>
        </div>
    </div>
    
    <div class="p-3 mt-2">
        <div class="text-uppercase small fw-bold mb-3 px-3" style="letter-spacing: 1.5px; font-size: 0.65rem; color: #6b7280;">Menu Utama</div>
        <ul class="nav flex-column mb-4">
            <li class="nav-item mb-1">
                <a href="dashboard.php" class="nav-link px-3 py-2 rounded text-white d-flex align-items-center gap-3 <?= $current_page == 'dashboard.php' ? 'active-navy fw-bold' : 'text-opacity-75' ?>">
                    <i data-lucide="layout-dashboard" style="width: 18px; height: 18px;"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="laporan.php" class="nav-link px-3 py-2 rounded text-white d-flex align-items-center gap-3 <?= $current_page == 'laporan.php' || $current_page == 'detail_laporan.php' ? 'active-navy fw-bold' : 'text-opacity-75' ?>">
                    <i data-lucide="inbox" style="width: 18px; height: 18px;"></i> Laporan Masuk
                </a>
            </li>
        </ul>

        <div class="text-uppercase small fw-bold mb-3 px-3" style="letter-spacing: 1.5px; font-size: 0.65rem; color: #6b7280;">Kelola Konten Publik</div>
        <ul class="nav flex-column mb-4">
            <li class="nav-item mb-1">
                <a href="berita.php" class="nav-link px-3 py-2 rounded text-white d-flex align-items-center gap-3 <?= $current_page == 'berita.php' ? 'active-navy fw-bold' : 'text-opacity-75' ?>">
                    <i data-lucide="newspaper" style="width: 18px; height: 18px;"></i> Berita
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="pengumuman.php" class="nav-link px-3 py-2 rounded text-white d-flex align-items-center gap-3 <?= $current_page == 'pengumuman.php' ? 'active-navy fw-bold' : 'text-opacity-75' ?>">
                    <i data-lucide="megaphone" style="width: 18px; height: 18px;"></i> Pengumuman
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="aturan.php" class="nav-link px-3 py-2 rounded text-white d-flex align-items-center gap-3 <?= $current_page == 'aturan.php' ? 'active-navy fw-bold' : 'text-opacity-75' ?>">
                    <i data-lucide="file-text" style="width: 18px; height: 18px;"></i> Tata Tertib
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="kategori_aturan.php" class="nav-link px-3 py-2 rounded text-white d-flex align-items-center gap-3 <?= $current_page == 'kategori_aturan.php' ? 'active-navy fw-bold' : 'text-opacity-75' ?>">
                    <i data-lucide="tag" style="width: 18px; height: 18px;"></i> Kategori Aturan
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="faq.php" class="nav-link px-3 py-2 rounded text-white d-flex align-items-center gap-3 <?= $current_page == 'faq.php' ? 'active-navy fw-bold' : 'text-opacity-75' ?>">
                    <i data-lucide="help-circle" style="width: 18px; height: 18px;"></i> FAQ
                </a>
            </li>
        </ul>

        <div class="text-uppercase small fw-bold mb-3 px-3" style="letter-spacing: 1.5px; font-size: 0.65rem; color: #6b7280;">Pengaturan Sistem</div>
        <ul class="nav flex-column">
            <li class="nav-item mb-1">
                <a href="user.php" class="nav-link px-3 py-2 rounded text-white d-flex align-items-center gap-3 <?= $current_page == 'user.php' ? 'active-navy fw-bold' : 'text-opacity-75' ?>">
                    <i data-lucide="users" style="width: 18px; height: 18px;"></i> Kelola Pengguna
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="statistik.php" class="nav-link px-3 py-2 rounded text-white d-flex align-items-center gap-3 <?= $current_page == 'statistik.php' ? 'active-navy fw-bold' : 'text-opacity-75' ?>">
                    <i data-lucide="bar-chart-3" style="width: 18px; height: 18px;"></i> Statistik Laporan
                </a>
            </li>
        </ul>
    </div>
</div>

<style>
.sidebar .nav-link { transition: all 0.2s ease-in-out; font-size: 0.9rem; border-radius: 10px !important; margin: 0 8px; }
.sidebar .nav-link:hover { background: rgba(255,255,255,0.08); color: #fff !important; transform: translateX(4px); }
.sidebar .nav-link.active-navy { background: rgba(255,255,255,0.1) !important; color: #fff !important; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
</style>
<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
