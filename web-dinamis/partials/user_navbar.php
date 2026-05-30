<?php
// Pastikan koneksi tersedia
if (!isset($conn)) {
    include_once dirname(__DIR__) . '/config/koneksi.php';
}

$current_page = basename($_SERVER['PHP_SELF']);
$is_guest_folder = (strpos($_SERVER['PHP_SELF'], '/guest/') !== false);
$prefix = $is_guest_folder ? '../user/' : '';

// Ambil jumlah notif belum dibaca
$user_id_nav = $_SESSION['id'];
$unreads_query = false;
try {
    $unreads_query = mysqli_query($conn, "SELECT COUNT(*) as jml FROM notifikasi WHERE user_id='$user_id_nav' AND is_read=0");
} catch (Exception $e) {}

$unreads = 0;
if ($unreads_query) {
    $unreads = mysqli_fetch_assoc($unreads_query)['jml'];
}

// Ambil foto profil
$user_nav = mysqli_fetch_assoc(mysqli_query($conn, "SELECT foto FROM users WHERE id='$user_id_nav'"));
?>
<nav class="navbar navbar-expand-lg navbar-light sticky-top shadow-sm" style="background-color: #ffffff;">
    <div class="container py-2">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= $prefix ?>dashboard.php">
            <div style="width:32px; height: 32px; background: linear-gradient(135deg, #0f172a, #1e293b); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold; font-size: 1.1rem;"><i data-lucide="scale" style="width: 18px; height: 18px;"></i></div>
            <span class="fw-bold" style="color: #0f172a; letter-spacing: 0.5px;">KOMDIS</span>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#userNavbar" aria-controls="userNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="userNavbar">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-2">
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-pill <?= $current_page == 'dashboard.php' ? 'active bg-navy text-white fw-bold shadow-sm' : 'text-secondary fw-medium' ?>" href="<?= $prefix ?>dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-pill <?= $current_page == 'laporan.php' || $current_page == 'detail_laporan.php' ? 'active bg-navy text-white fw-bold shadow-sm' : 'text-secondary fw-medium' ?>" href="<?= $prefix ?>laporan.php">Riwayat Laporan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-pill <?= $current_page == 'tambah_laporan.php' ? 'active bg-navy text-white fw-bold shadow-sm' : 'text-secondary fw-medium' ?>" href="<?= $prefix ?>tambah_laporan.php">Buat Laporan</a>
                </li>
            </ul>

            <!-- Right Side (User Profile & Notif) -->
            <ul class="navbar-nav align-items-center gap-2 mt-3 mt-lg-0">
                <!-- Notifications -->
                <li class="nav-item">
                    <a class="nav-link position-relative" href="<?= $prefix ?>notifikasi.php">
                        <i data-lucide="bell" style="width: 20px; height: 20px;"></i>
                        <?php if($unreads > 0): ?>
                        <span class="position-absolute top-20 start-80 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            <?= $unreads ?>
                        </span>
                        <?php endif; ?>
                    </a>
                </li>

                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rounded-circle shadow-sm overflow-hidden" style="width: 35px; height: 35px; background: #e2e8f0; color: #4a5568; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                            <?php if(!empty($user_nav['foto'])): ?>
                                <img src="../assets/upload/profil/<?= $user_nav['foto'] ?>" class="w-100 h-100" style="object-fit: cover;">
                            <?php else: ?>
                                <?= substr($_SESSION['nama'] ?? 'U', 0, 1) ?>
                            <?php endif; ?>
                        </div>
                        <span class="fw-semibold text-dark d-none d-sm-block"><?= explode(' ', $_SESSION['nama'])[0] ?? 'User' ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2 rounded-3" aria-labelledby="userMenu">
                        <li><a class="dropdown-item rounded mb-1 d-flex align-items-center gap-2" href="<?= $prefix ?>profile.php"><i data-lucide="user" style="width: 16px; height: 16px;"></i> Profil Saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item rounded text-danger fw-bold d-flex align-items-center gap-2" href="../auth/logout.php"><i data-lucide="log-out" style="width: 16px; height: 16px;"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>

<style>
.navbar-nav .nav-link { transition: all 0.2s; }
.navbar-nav .nav-link:hover { color: #0f172a !important; }
.bg-navy { background-color: #0f172a !important; }
</style>
