<?php 
session_start(); 
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan - Komdis HIMA</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #fdfdfd; color: #2d3748; }
        .form-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05); padding: 40px; }
        .form-control, .form-select { border-radius: 12px; padding: 14px 20px; border: 1px solid #e2e8f0; background-color: #f8f9fa; font-size: 0.95rem; transition: all 0.2s; }
        .form-control:focus, .form-select:focus { background-color: #fff; border-color: #1cc88a; box-shadow: 0 0 0 4px rgba(28,200,138,0.1); }
        .form-label { font-weight: 600; font-size: 0.9rem; color: #4a5568; margin-bottom: 8px; }
        .btn-submit { background: #1cc88a; border: none; padding: 14px; border-radius: 12px; font-weight: 600; font-size: 1rem; color: #fff; transition: all 0.2s; }
        .btn-submit:hover { background: #13855c; transform: translateY(-2px); box-shadow: 0 4px 15px rgba(28,200,138,0.3); }
    </style>
</head>
<body>
    <?php include '../partials/user_navbar.php'; ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="text-center mb-4">
                    <i data-lucide="file-edit" class="text-success mb-3" style="width: 64px; height: 64px;"></i>
                    <h3 class="fw-bold" style="color: #1a202c;">Form Pengajuan Laporan</h3>
                    <p class="text-muted">Lengkapi form di bawah ini dengan bukti yang valid dan kronologi yang jelas. Identitas kamu aman bersama kami.</p>
                </div>

                <div class="form-card">
                    <form action="../proses/laporan_proses.php" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-4">
                            <label class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control" placeholder="Contoh: Pemalakan di Area Parkir oleh Anggota X" required>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <label class="form-label">Kategori Pelanggaran <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    <option value="Pelanggaran Etika">Pelanggaran Etika & Perilaku</option>
                                    <option value="Tindak Kekerasan">Tindak Kekerasan / Bullying</option>
                                    <option value="Penyalahgunaan Wewenang">Penyalahgunaan Wewenang</option>
                                    <option value="Kehilangan Barang">Pencurian / Kehilangan Barang</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Lokasi Kejadian <span class="text-danger">*</span></label>
                                <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Kantin Utama, Lt. 2" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Kronologi Lengkap <span class="text-danger">*</span></label>
                            <textarea name="kronologi" class="form-control" rows="5" placeholder="Ceritakan secara detail bagaimana kejadian tersebut berlangsung..." required></textarea>
                            <div class="form-text mt-2 text-muted" style="font-size: 0.8rem;">Sertakan waktu kejadian (tanggal dan jam) di dalam cerita kronologi jika memungkinkan.</div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label">Upload Bukti Pendukung (Opsional)</label>
                            <input type="file" name="bukti[]" multiple class="form-control" accept="image/*, .pdf">
                            <div class="form-text mt-2 text-muted" style="font-size: 0.8rem;">Bisa upload lebih dari 1 file (Foto, Screenshot, atau PDF). Maksimal ukuran total 5MB.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-submit" name="tambah">Kirim Laporan Sekarang</button>
                            <a href="dashboard.php" class="btn btn-light text-secondary fw-bold rounded-3 mt-2">Batalkan</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>