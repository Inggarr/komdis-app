<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Komdis HIMA</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: radial-gradient(#0f172a 0.5px, transparent 0.5px);
            background-size: 24px 24px;
        }

        .auth-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(15, 23, 42, 0.05);
            width: 100%;
            max-width: 450px;
            padding: 40px;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: #0f172a;
            color: #fff;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 1.8rem;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.2);
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: #0f172a;
            box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.1);
        }

        .btn-navy {
            background-color: #0f172a;
            color: #fff;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            border: none;
            transition: all 0.2s;
        }

        .btn-navy:hover {
            background-color: #1e293b;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        }

        .auth-link {
            color: #0f172a;
            text-decoration: none;
            font-weight: 700;
        }

        .auth-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="auth-card position-relative">
        <a href="../guest/home.php" class="btn btn-sm btn-light border rounded-pill px-3 position-absolute" style="top: 20px; left: 20px;">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i> Kembali
        </a>
        <div class="text-center">
            <div class="brand-logo">
                <i data-lucide="user-plus"></i>
            </div>
            <h4 class="fw-bold mb-1" style="color: #0f172a;">Buat Akun</h4>
            <p class="text-muted small mb-4">Daftar sebagai Mahasiswa (Pelapor)</p>
        </div>

        <form action="../proses/register_proses.php" method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap..." required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">NIM</label>
                <input type="text" name="nim" class="form-control" placeholder="Masukkan NIM..." required>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold text-muted">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Buat password..." required>
                    <button class="btn btn-light border" type="button" id="togglePassword" style="border-top-right-radius: 12px; border-bottom-right-radius: 12px;">
                        <i data-lucide="eye" id="eyeIcon" style="width: 18px; height: 18px;"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-navy w-100 mb-3" name="register">Daftar Sekarang</button>
        </form>

        <p class="text-center mt-3 mb-0 text-muted small">
            Sudah punya akun? <a href="login.php" class="auth-link">Login di sini</a>
        </p>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#passwordInput');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'text') {
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        });
    </script>
</body>

</html>