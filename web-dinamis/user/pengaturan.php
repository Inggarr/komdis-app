<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_SESSION['id'];

$user = false;
try {
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$id'"));
} catch(Exception $e){}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - Komdis HIMA</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fdfdfd; color: #2d3748; }
        .card-custom { background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05); }
        .avatar-lg { width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #0f172a, #1e293b); display: flex; align-items: center; justify-content: center; font-size: 3rem; color: #fff; font-weight: bold; margin: 0 auto; box-shadow: 0 10px 25px rgba(15,23,42,0.2); border: 5px solid #fff; overflow: hidden; }
        .form-control { border-radius: 12px; padding: 12px 15px; border: 1px solid #e2e8f0; }
        .btn-navy { background: #0f172a; color: #fff; }
        .btn-navy:hover { background: #1e293b; color: #fff; }
    </style>
</head>
<body>
    <?php include '../partials/user_navbar.php'; ?>

    <div class="container py-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h3 class="fw-bold mb-0" style="color: #1a202c;">Pengaturan Akun</h3>
            <a href="profile.php" class="btn btn-light fw-bold rounded-pill px-4 border text-secondary">← Kembali ke Profil</a>
        </div>

        <?php if(isset($_GET['msg'])): ?>
            <?php if($_GET['msg'] == 'profil_success'): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-pill px-4 mb-4 fw-bold small">✅ Profil berhasil diperbarui!</div>
            <?php elseif($_GET['msg'] == 'pass_success'): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-pill px-4 mb-4 fw-bold small">✅ Password berhasil diganti!</div>
            <?php elseif($_GET['msg'] == 'old_pass_error'): ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-pill px-4 mb-4 fw-bold small">❌ Password lama salah!</div>
            <?php elseif($_GET['msg'] == 'pass_mismatch'): ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-pill px-4 mb-4 fw-bold small">❌ Konfirmasi password tidak cocok!</div>
            <?php elseif($_GET['msg'] == 'format_error'): ?>
                <div class="alert alert-warning border-0 shadow-sm rounded-pill px-4 mb-4 fw-bold small">⚠️ Format foto tidak didukung (Gunakan JPG/PNG)!</div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Upload Foto -->
            <div class="col-md-4">
                <div class="card-custom p-4 text-center">
                    <h6 class="fw-bold mb-4">Foto Profil</h6>
                    <form action="../proses/profile_proses.php" method="POST" enctype="multipart/form-data" id="photoForm">
                        <div class="position-relative d-inline-block mb-3">
                            <div class="avatar-lg">
                                <?php if(!empty($user['foto'])): ?>
                                    <img src="../assets/upload/profil/<?= $user['foto'] ?>" class="w-100 h-100" style="object-fit: cover;">
                                <?php else: ?>
                                    <?= strtoupper(substr($user['nama'] ?? 'U', 0, 1)) ?>
                                <?php endif; ?>
                            </div>
                            <label for="fotoInput" class="position-absolute bottom-0 end-0 bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center border" style="width: 35px; height: 35px; cursor: pointer; transform: translate(5px, 5px);">
                                <i data-lucide="camera" style="width: 16px; height: 16px; color: #0f172a;"></i>
                                <input type="file" name="foto" id="fotoInput" class="d-none" onchange="document.getElementById('photoForm').submit()">
                            </label>
                            <input type="hidden" name="update_profil" value="1">
                            <input type="hidden" name="from_settings" value="1">
                            <input type="hidden" name="nama" value="<?= htmlspecialchars($user['nama']) ?>">
                            <input type="hidden" name="divisi" value="<?= htmlspecialchars($user['divisi']) ?>">
                        </div>
                    </form>
                    <p class="text-muted small mb-0">Klik ikon kamera untuk mengganti foto profil Anda.</p>
                </div>
            </div>

            <!-- Edit Data & Password -->
            <div class="col-md-8">
                <!-- Data Akun -->
                <div class="card-custom p-4 mb-4">
                    <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                        <i data-lucide="user" style="width: 20px; height: 20px; color: #0f172a;"></i> Informasi Pribadi
                    </h5>
                    <form action="../proses/profile_proses.php" method="POST">
                        <input type="hidden" name="from_settings" value="1">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label text-muted fw-bold small text-uppercase">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($user['nama'] ?? '') ?>" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label text-muted fw-bold small text-uppercase">NIM (Readonly)</label>
                                <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($user['nim'] ?? '') ?>" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted fw-bold small text-uppercase">Divisi / Jabatan</label>
                                <input type="text" name="divisi" class="form-control" value="<?= htmlspecialchars($user['divisi'] ?? '') ?>" placeholder="Misal: Mahasiswa Teknik Informatika">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" name="update_profil" class="btn btn-navy fw-bold px-4 rounded-pill">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                <!-- Ganti Password -->
                <div class="card-custom p-4">
                    <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                        <i data-lucide="lock" style="width: 20px; height: 20px; color: #0f172a;"></i> Ganti Kata Sandi
                    </h5>
                    <form action="../proses/profile_proses.php" method="POST">
                        <input type="hidden" name="from_settings" value="1">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label text-muted fw-bold small text-uppercase">Kata Sandi Saat Ini</label>
                                <div class="input-group">
                                    <input type="password" name="pass_lama" class="form-control pass-input" placeholder="Masukkan kata sandi sekarang..." required>
                                    <button class="btn btn-light border toggle-pass" type="button"><i data-lucide="eye" style="width: 18px;"></i></button>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label text-muted fw-bold small text-uppercase">Kata Sandi Baru</label>
                                <div class="input-group">
                                    <input type="password" name="pass_baru" class="form-control pass-input" placeholder="Buat kata sandi baru..." required>
                                    <button class="btn btn-light border toggle-pass" type="button"><i data-lucide="eye" style="width: 18px;"></i></button>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label text-muted fw-bold small text-uppercase">Konfirmasi Kata Sandi Baru</label>
                                <div class="input-group">
                                    <input type="password" name="konfirmasi" class="form-control pass-input" placeholder="Ulangi kata sandi baru..." required>
                                    <button class="btn btn-light border toggle-pass" type="button"><i data-lucide="eye" style="width: 18px;"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" name="update_password" class="btn btn-light fw-bold px-4 rounded-pill border">Ganti Kata Sandi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        // Toggle Password Visibility
        document.querySelectorAll('.toggle-pass').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.setAttribute('data-lucide', 'eye-off');
                } else {
                    input.type = 'password';
                    icon.setAttribute('data-lucide', 'eye');
                }
                lucide.createIcons();
            });
        });
    </script>
</body>
</html>
