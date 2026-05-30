<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Komdis HIMA</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fdfdfd; font-family: 'Inter', 'Segoe UI', sans-serif; }
        .hero-section { background: #ffffff; padding: 80px 0 60px; border-bottom: 1px solid rgba(0,0,0,0.03); margin-bottom: 40px; }
        .hero-section h1 { font-weight: 800; color: #1a202c; font-size: clamp(2rem, 4vw, 2.8rem); margin-bottom: 10px; }
        .hero-section p { color: #4a5568; font-size: 1.1rem; }
        .contact-card { border: 1px solid rgba(0,0,0,0.05); border-radius: 16px; box-shadow: 0 4px 25px rgba(0,0,0,.03); background: #ffffff; }
        .icon-box {
            width: 50px; height: 50px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; flex-shrink: 0;
        }
        .form-control { border-radius: 8px; border: 1px solid rgba(0,0,0,.1); padding: 12px 16px; background: #fafbfa; }
        .form-control:focus { box-shadow: 0 0 0 4px rgba(15,23,42,.1); border-color: #0f172a; background: #ffffff; }
        .form-label { color: #4a5568; font-weight: 600; font-size: 0.9rem; margin-bottom: 6px; }
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; flex-shrink: 0;
        }
        .icon-box.blue { background: rgba(15,23,42,.1); }
        .icon-box.green { background: rgba(28,200,138,.12); }
        .icon-box.yellow { background: rgba(246,194,62,.12); }
        .social-btn { border-radius: 30px; padding: 8px 20px; font-weight: 600; text-decoration: none; }
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

<div class="hero-section text-center mb-5">
    <div class="container">
        <h1 class="d-flex align-items-center justify-content-center gap-3"><i data-lucide="mail" style="width: 40px; height: 40px; color: #4e73df;"></i> Kontak Kami</h1>
        <p class="mb-0">Hubungi Komisi Disiplin HIMA untuk pertanyaan atau informasi lebih lanjut</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4 justify-content-center">

        <!-- Info Kontak -->
        <div class="col-md-5">
            <div class="card contact-card p-4 h-100">
                <h5 class="fw-bold mb-4">Informasi Kontak</h5>

                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box blue me-3"><i data-lucide="mail" style="width: 20px; height: 20px; color: #0f172a;"></i></div>
                    <div>
                        <small class="text-muted d-block">Email</small>
                        <strong>komdis@hima.ac.id</strong>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box green me-3"><i data-lucide="phone" style="width: 20px; height: 20px; color: #1cc88a;"></i></div>
                    <div>
                        <small class="text-muted d-block">WhatsApp</small>
                        <strong>+62 812-3456-7890</strong>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box yellow me-3"><i data-lucide="map-pin" style="width: 20px; height: 20px; color: #f6c23e;"></i></div>
                    <div>
                        <small class="text-muted d-block">Lokasi Sekretariat</small>
                        <strong>Gedung HIMA Lt. 2, Kampus Utama</strong>
                    </div>
                </div>

                <hr>
                <p class="text-muted small mb-3">Jam Operasional:</p>
                <p class="small mb-1 d-flex align-items-center gap-2"><i data-lucide="clock" style="width: 14px; height: 14px;"></i> Senin – Jumat: 08.00 – 16.00</p>
                <p class="small d-flex align-items-center gap-2"><i data-lucide="clock" style="width: 14px; height: 14px;"></i> Sabtu: 09.00 – 12.00</p>

                <hr>
                <p class="text-muted small mb-2">Media Sosial</p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="#" class="social-btn btn btn-outline-primary btn-sm">Instagram</a>
                    <a href="#" class="social-btn btn btn-outline-success btn-sm">WhatsApp</a>
                    <a href="#" class="social-btn btn btn-outline-dark btn-sm">Twitter/X</a>
                </div>
            </div>
        </div>

        <!-- Form Pesan -->
        <div class="col-md-6">
            <div class="card contact-card p-4 h-100">
                <h5 class="fw-bold mb-4">Kirim Pesan</h5>
                <form>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama kamu">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email / NIM</label>
                        <input type="text" class="form-control" placeholder="Email atau NIM kamu">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subjek</label>
                        <input type="text" class="form-control" placeholder="Subjek pesan">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Pesan</label>
                        <textarea class="form-control" rows="5" placeholder="Tulis pesanmu di sini..."></textarea>
                    </div>
                    <button type="submit" class="btn fw-bold w-100 py-3" style="background: #0f172a; color: #fff; border-radius: 12px; border: none;">
                        <i data-lucide="send" style="width: 18px; height: 18px;"></i> Kirim Pesan
                    </button>
                    <small class="text-muted d-block mt-2 text-center">
                        Atau langsung buat laporan resmi? <a href="../auth/login.php">Login dulu</a>
                    </small>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include '../partials/footer.php'; ?>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script>
    lucide.createIcons();
</script>
</body>
</html>
