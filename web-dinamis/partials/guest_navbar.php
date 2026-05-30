<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Deteksi halaman aktif
$currentPage = basename($_SERVER['PHP_SELF']);
$isLoggedIn = isset($_SESSION['login']);
$userRole = $_SESSION['role'] ?? '';
?>
<nav class="navbar navbar-expand-lg navbar-light sticky-top bg-white" style="box-shadow: 0 2px 20px rgba(0,0,0,0.05); border-bottom: 1px solid rgba(0,0,0,0.05);">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="home.php">
            <div style="width:36px;height:36px;background:linear-gradient(135deg,#0f172a,#1e293b);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:#fff;box-shadow:0 4px 10px rgba(15,23,42,0.3);"><i data-lucide="scale" style="width: 20px; height: 20px;"></i></div>
            <div>
                <span style="font-weight:800;font-size:1.1rem;letter-spacing:1px;color:#2d3748;">KOMDIS</span>
                <span style="font-size:.65rem;display:block;opacity:.7;line-height:1;margin-top:-2px;color:#4a5568;">KOMISI DISIPLIN HIMA</span>
            </div>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#guestNav" style="box-shadow: none;">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="guestNav">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill d-flex align-items-center gap-2 <?= $currentPage=='home.php' ? 'active fw-bold' : '' ?>"
                       href="home.php" style="<?= $currentPage=='home.php' ? 'background:rgba(15,23,42,.05); color:#0f172a;' : 'color:#4a5568; font-weight:500;' ?>">
                        <i data-lucide="home" style="width: 18px; height: 18px;"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill d-flex align-items-center gap-2 <?= $currentPage=='berita.php' ? 'active fw-bold' : '' ?>"
                       href="berita.php" style="<?= $currentPage=='berita.php' ? 'background:rgba(15,23,42,.05); color:#0f172a;' : 'color:#4a5568; font-weight:500;' ?>">
                        <i data-lucide="newspaper" style="width: 18px; height: 18px;"></i> Berita
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill d-flex align-items-center gap-2 <?= $currentPage=='aturan.php' ? 'active fw-bold' : '' ?>"
                       href="aturan.php" style="<?= $currentPage=='aturan.php' ? 'background:rgba(15,23,42,.05); color:#0f172a;' : 'color:#4a5568; font-weight:500;' ?>">
                        <i data-lucide="file-text" style="width: 18px; height: 18px;"></i> Aturan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill d-flex align-items-center gap-2 <?= $currentPage=='faq.php' ? 'active fw-bold' : '' ?>"
                       href="faq.php" style="<?= $currentPage=='faq.php' ? 'background:rgba(15,23,42,.05); color:#0f172a;' : 'color:#4a5568; font-weight:500;' ?>">
                        <i data-lucide="help-circle" style="width: 18px; height: 18px;"></i> FAQ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill d-flex align-items-center gap-2 <?= $currentPage=='kontak.php' ? 'active fw-bold' : '' ?>"
                       href="kontak.php" style="<?= $currentPage=='kontak.php' ? 'background:rgba(15,23,42,.05); color:#0f172a;' : 'color:#4a5568; font-weight:500;' ?>">
                        <i data-lucide="mail" style="width: 18px; height: 18px;"></i> Kontak
                    </a>
                </li>
            </ul>

            <!-- CTA Section -->
            <div class="d-flex gap-2 mt-3 mt-lg-0">
                <?php if ($isLoggedIn): ?>
                    <?php 
                    $dashboardUrl = ($userRole == 'admin') ? '../admin/dashboard.php' : '../user/dashboard.php';
                    ?>
                    <a href="<?= $dashboardUrl ?>" class="btn btn-sm fw-semibold px-4 d-flex align-items-center gap-2 text-white"
                       style="background: #0f172a; border-radius: 20px; box-shadow: 0 4px 15px rgba(15,23,42,.3); transition: transform 0.2s;">
                        <i data-lucide="layout-dashboard" style="width: 14px; height: 14px;"></i> Ke Dashboard
                    </a>
                <?php else: ?>
                    <a href="../auth/login.php" class="btn btn-sm fw-semibold px-4 d-flex align-items-center gap-2"
                       style="background:linear-gradient(135deg,#0f172a,#1e293b);color:#fff;border:none;border-radius:20px;box-shadow:0 4px 15px rgba(15,23,42,.3);transition:transform 0.2s;">
                        <i data-lucide="lock" style="width: 14px; height: 14px;"></i> Login
                    </a>
                    <a href="../auth/register.php" class="btn btn-sm fw-semibold px-4 d-flex align-items-center gap-2"
                       style="background:#f8f9fa;color:#4a5568;border:1px solid #e2e8f0;border-radius:20px;transition:all 0.3s;">
                        <i data-lucide="user-plus" style="width: 14px; height: 14px;"></i> Register
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
